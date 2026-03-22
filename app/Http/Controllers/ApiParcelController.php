<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\User;
use App\Services\Sms\ParcelSmsComposer;
use App\Services\Sms\SmsCoTzClient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiParcelController extends Controller
{
    /**
     * Get parcels for the authenticated user (staff).
     * Optional query: date (Y-m-d) to filter by travel_date; default is today.
     * Optional query: type = created|transported|received; default is created.
     */
    public function myParcels(Request $request)
    {
        $user = $request->user();
        $date = $request->query('date');
        $type = $request->query('type', 'created');

        $request->validate([
            'type' => 'nullable|in:created,transported,received',
        ]);

        if ($date !== null && $date !== '') {
            $request->validate(['date' => 'date_format:Y-m-d']);
        }

        $query = Parcel::query()
            ->with(['bus', 'transportedBus', 'scannedBy', 'createdBy']);

        if ($type === 'transported') {
            $query->where('transported_by_id', $user->id);
        } elseif ($type === 'received') {
            $query->where('received_by_id', $user->id);
        } else {
            $query->where('created_by', $user->id);
        }

        if ($date) {
            $query->whereDate('travel_date', $date);
        } else {
            $query->whereDate('travel_date', Carbon::today()->toDateString());
        }

        $parcels = $query->orderBy('created_at', 'desc')->paginate(20);

        // Append creator info for app
        $parcels->getCollection()->transform(function (Parcel $p) {
            $p->created_by_name = optional($p->createdBy)->name;
            $p->created_by_phone = optional($p->createdBy)->phone;
            return $p;
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'parcels' => $parcels->items(),
                'pagination' => [
                    'current_page' => $parcels->currentPage(),
                    'last_page' => $parcels->lastPage(),
                    'per_page' => $parcels->perPage(),
                    'total' => $parcels->total(),
                ],
            ],
        ]);
    }

    /**
     * Create a new parcel.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'parcel_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1|max:999999',
            'weight_band' => 'required|string|in:under_20kg,over_20kg',
            'creator_office' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:20',
            'sender_email' => 'nullable|string|email|max:255',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_email' => 'nullable|string|email|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            // Bus and timetable will be filled later when parcel is scanned / assigned
            'bus_id' => 'nullable|exists:buses,id',
            'travel_date' => 'nullable|date|after_or_equal:today',
            'start_travel_time' => 'nullable|date_format:H:i',
            'end_travel_time' => 'nullable|date_format:H:i|after:start_travel_time',
        ]);

        $parcel = Parcel::create([
            'parcel_name' => $validated['parcel_name'],
            'quantity' => $validated['quantity'],
            'weight_band' => $validated['weight_band'],
            'creator_office' => $validated['creator_office'],
            'sender_name' => $validated['sender_name'],
            'sender_phone' => $validated['sender_phone'],
            'sender_email' => isset($validated['sender_email']) && trim((string) $validated['sender_email']) !== ''
                ? trim($validated['sender_email'])
                : null,
            'receiver_name' => $validated['receiver_name'],
            'receiver_phone' => $validated['receiver_phone'],
            'receiver_email' => isset($validated['receiver_email']) && trim((string) $validated['receiver_email']) !== ''
                ? trim($validated['receiver_email'])
                : null,
            'origin' => $validated['origin'],
            'destination' => $validated['destination'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'bus_id' => $validated['bus_id'] ?? null,
            'travel_date' => $validated['travel_date'] ?? null,
            'start_travel_time' => $validated['start_travel_time'] ?? null,
            'end_travel_time' => $validated['end_travel_time'] ?? null,
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        // Append creator info for app
        $parcel->load(['bus', 'transportedBus', 'scannedBy', 'createdBy']);
        $parcel->created_by_name = optional($parcel->createdBy)->name;
        $parcel->created_by_phone = optional($parcel->createdBy)->phone;

        // SMS notifications (best-effort)
        try {
            $sms = app(SmsCoTzClient::class);
            $composer = app(ParcelSmsComposer::class);
            $sms->send($parcel->sender_phone, $composer->createdForSender($parcel));
            $sms->send($parcel->receiver_phone, $composer->createdForReceiver($parcel));
        } catch (\Throwable $e) {
            \Log::warning('Parcel created SMS failed', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Parcel created successfully',
            'data' => [
                'parcel' => $parcel,
            ],
        ], 201);
    }

    /**
     * Scan parcel QR code.
     */
    public function scanParcel(Request $request)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string|exists:parcels,tracking_number',
        ]);

        $parcel = Parcel::where('tracking_number', $validated['tracking_number'])
            ->with(['bus', 'transportedBus', 'scannedBy', 'createdBy'])
            ->first();

        $parcel->created_by_name = optional($parcel->createdBy)->name;
        $parcel->created_by_phone = optional($parcel->createdBy)->phone;

        return response()->json([
            'status' => 'success',
            'data' => [
                'parcel' => $parcel->fresh(['bus', 'transportedBus', 'scannedBy', 'createdBy']),
            ],
        ]);
    }

    /**
     * Assign transporter using selected bus worker on the staff's assigned bus.
     */
    public function assignTransporter(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'tracking_number' => 'required|string|exists:parcels,tracking_number',
            'worker_name' => 'required|string|max:255',
            'worker_role' => 'nullable|string|max:50',
        ]);

        $parcel = Parcel::where('tracking_number', $validated['tracking_number'])
            ->with(['bus', 'transportedBus', 'scannedBy', 'createdBy'])
            ->first();
        $bus = $user->assignedBus();

        if (! $bus) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hakuna basi lililopangiwa kwa mtumiaji huyu',
            ], 400);
        }

        $routeName = $bus->route ? $bus->route->from.' → '.$bus->route->to : null;

        $displayName = $validated['worker_name'];
        if (! empty($validated['worker_role'])) {
            $displayName = strtoupper($validated['worker_role']).': '.$displayName;
        }

        $parcel->update([
            'transported_by_id' => $user->id,
            'transported_by_name' => $displayName,
            'transported_by_phone' => $user->phone,
            'transported_bus_id' => $bus->id,
            'transported_route' => $routeName,
            'transported_at' => now(),
            'status' => 'in-transit',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Usafirishaji umehifadhiwa',
            'data' => [
                'parcel' => $parcel->fresh(['bus', 'transportedBus', 'scannedBy', 'createdBy']),
            ],
        ]);
    }

    /**
     * Assign receiver using current authenticated staff.
     */
    public function assignReceiver(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'tracking_number' => 'required|string|exists:parcels,tracking_number',
        ]);

        $parcel = Parcel::where('tracking_number', $validated['tracking_number'])->first();

        if (! $parcel->transported_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parcel haijakabidhiwa kwa usafirishaji bado',
            ], 400);
        }

        $parcel->update([
            'received_by_id' => $user->id,
            'received_by_name' => $user->name,
            'received_by_phone' => $user->phone,
            'received_at' => now(),
            'status' => 'received',
        ]);

        // SMS notification to receiver (best-effort)
        try {
            $parcelFresh = $parcel->fresh();
            $sms = app(SmsCoTzClient::class);
            $composer = app(ParcelSmsComposer::class);
            $sms->send($parcelFresh->receiver_phone, $composer->receivedNotice($parcelFresh));
        } catch (\Throwable $e) {
            \Log::warning('Parcel received SMS failed', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Parcel imepokelewa',
            'data' => [
                'parcel' => $parcel->fresh(['bus', 'scannedBy']),
            ],
        ]);
    }

    /**
     * View parcel details by tracking number without changing its status.
     */
    public function viewParcel($trackingNumber)
    {
        $parcel = Parcel::where('tracking_number', $trackingNumber)
            ->with(['bus', 'transportedBus', 'scannedBy', 'createdBy'])
            ->first();

        if (! $parcel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parcel haijapatikana',
            ], 404);
        }

        // Append creator info for app
        $parcel->created_by_name = optional($parcel->createdBy)->name;
        $parcel->created_by_phone = optional($parcel->createdBy)->phone;

        return response()->json([
            'status' => 'success',
            'data' => [
                'parcel' => $parcel,
            ],
        ]);
    }

    /**
     * Get all buses for selection (regardless of status).
     */
    public function getBuses()
    {
        $buses = Bus::with('route')
            ->orderBy('plate_number')
            ->get();

        // Resolve all unique staff IDs to User names so the mobile app can
        // show "Juma - driver" instead of just numeric IDs.
        $allStaffIds = [];
        foreach ($buses as $bus) {
            $allStaffIds = array_merge(
                $allStaffIds,
                is_array($bus->drivers) ? $bus->drivers : [],
                is_array($bus->conductors) ? $bus->conductors : [],
                is_array($bus->attendants) ? $bus->attendants : [],
            );
        }
        $allStaffIds = array_values(array_unique($allStaffIds));

        $usersById = $allStaffIds
            ? User::whereIn('id', $allStaffIds)->get()->keyBy('id')
            : collect();

        $buses = $buses->map(function ($bus) use ($usersById) {
            $mapCrew = function ($ids, string $role) use ($usersById) {
                if (! is_array($ids)) {
                    return [];
                }

                return collect($ids)->map(function ($id) use ($usersById, $role) {
                    $user = $usersById[$id] ?? null;

                    return [
                        'id' => $id,
                        'name' => $user?->name ?? (string) $id,
                        'role' => $role,
                    ];
                })->all();
            };

            return [
                'id' => $bus->id,
                'plate_number' => $bus->plate_number,
                'model' => $bus->model ?? 'N/A',
                'capacity' => $bus->capacity ?? 0,
                'status' => $bus->status,
                'route_id' => $bus->route_id,
                'route_name' => $bus->route ? $bus->route->from . ' → ' . $bus->route->to : 'No Route',
                // Mobile app expects arrays; we now send objects with names
                'drivers' => $mapCrew($bus->drivers, 'driver'),
                'conductors' => $mapCrew($bus->conductors, 'conductor'),
                'attendants' => $mapCrew($bus->attendants, 'attendant'),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'buses' => $buses,
            ],
        ]);
    }

    /**
     * Get available routes.
     */
    public function getRoutes()
    {
        $routes = BusRoute::all();

        return response()->json([
            'status' => 'success',
            'data' => [
                'routes' => $routes,
            ],
        ]);
    }
}
