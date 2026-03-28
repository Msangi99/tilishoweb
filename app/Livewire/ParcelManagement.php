<?php

namespace App\Livewire;

use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\Office;
use App\Models\Parcel;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class ParcelManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function getStations()
    {
        $endpoints = BusRoute::all()->flatMap(fn ($route) => [$route->from, $route->to]);
        $offices = Office::query()->pluck('name');

        return $endpoints->merge($offices)->unique()->filter()->sort()->values();
    }
    
    public $status = 'pending';
    public $viewingParcel = null;
    public $showDetailsModal = false;

    /** 'create' | 'edit' | null (list) - from URL query for dedicated pages */
    public $action = null;
    public $parcelId = null;

    public $editingParcelId;
    public $sender_name;
    public $sender_phone;
    public $sender_email;
    public $receiver_name;
    public $receiver_phone;
    public $receiver_email;
    public $origin;
    public $destination;
    public $amount;
    public $description;
    public $parcel_name;
    public $quantity = 1;
    public $weight_band = 'under_20kg';
    public $creator_office;
    public $bus_id;
    public $travel_date;

    public function mount()
    {
        $this->action = request()->query('action');
        $this->parcelId = request()->query('id');
        $this->travel_date = now()->format('Y-m-d');

        // Disable editing from web UI – only allow create or list
        if ($this->action === 'edit') {
            $this->action = null;
            $this->parcelId = null;
            return;
        }

        if ($this->action === 'create') {
            // New parcel form; nothing to preload
            return;
        }
    }

    public function rules()
    {
        return [
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
            'description' => 'nullable|string',
            'bus_id' => 'nullable|exists:buses,id',
            'travel_date' => 'required|date',
        ];
    }

    public function viewParcel($id)
    {
        $this->viewingParcel = Parcel::findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function resetScan($id)
    {
        $parcel = Parcel::findOrFail($id);
        $parcel->update([
            'scanned_by' => null,
            'bus_id' => null,
            'travel_date' => null,
            'start_travel_time' => null,
            'end_travel_time' => null,
            'status' => 'pending'
        ]);
        
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Scan Reset',
            'text' => 'Scanning information cleared successfully.'
        ]);
    }

    public function closeDetails()
    {
        $this->showDetailsModal = false;
        $this->viewingParcel = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editParcel($id)
    {
        $this->editingParcelId = $id;
        $parcel = Parcel::findOrFail($id);

        $this->sender_name = $parcel->sender_name;
        $this->sender_phone = $parcel->sender_phone;
        $this->sender_email = $parcel->sender_email;
        $this->receiver_name = $parcel->receiver_name;
        $this->receiver_phone = $parcel->receiver_phone;
        $this->receiver_email = $parcel->receiver_email;
        $this->origin = $parcel->origin;
        $this->destination = $parcel->destination;
        $this->parcel_name = $parcel->parcel_name;
        $this->quantity = $parcel->quantity ?? 1;
        $this->weight_band = $parcel->weight_band ?? 'under_20kg';
        $this->creator_office = $parcel->creator_office;
        $this->amount = $parcel->amount;
        $this->description = $parcel->description;
        $this->status = $parcel->status;
        $this->bus_id = $parcel->bus_id;
        $this->travel_date = optional($parcel->travel_date)->format('Y-m-d') ?? now()->format('Y-m-d');
    }

    public function cancelEdit()
    {
        $this->reset(['editingParcelId', 'sender_name', 'sender_phone', 'sender_email', 'receiver_name', 'receiver_phone', 'receiver_email', 'origin', 'destination', 'amount', 'description', 'status', 'bus_id', 'travel_date', 'parcel_name', 'creator_office']);
        $this->quantity = 1;
        $this->weight_band = 'under_20kg';
        $this->travel_date = now()->format('Y-m-d');
        $this->resetErrorBag();
    }

    public function saveParcel()
    {
        // Explicit array avoids Livewire's checkRuleMatchesProperty + array_key_exists edge cases
        // when public properties include models (e.g. viewingParcel) alongside form fields.
        $data = [
            'parcel_name' => $this->parcel_name,
            'quantity' => $this->quantity,
            'weight_band' => $this->weight_band,
            'creator_office' => $this->creator_office,
            'sender_name' => $this->sender_name,
            'sender_phone' => $this->sender_phone,
            'sender_email' => $this->sender_email,
            'receiver_name' => $this->receiver_name,
            'receiver_phone' => $this->receiver_phone,
            'receiver_email' => $this->receiver_email,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'amount' => $this->amount,
            'description' => $this->description,
            'bus_id' => $this->bus_id,
            'travel_date' => $this->travel_date,
        ];

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            $this->resetErrorBag();
            foreach ($validator->errors()->messages() as $key => $messages) {
                foreach ($messages as $message) {
                    $this->addError($key, $message);
                }
            }

            return;
        }

        $validated = $validator->validated();

        if ($this->editingParcelId) {
            session()->flash('message', 'Editing existing parcels is not allowed.');
        } else {
            Parcel::create([
                'parcel_name' => $validated['parcel_name'],
                'quantity' => (int) $validated['quantity'],
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
                'status' => 'pending',
                'bus_id' => $validated['bus_id'] ?? null,
                'travel_date' => $validated['travel_date'] ?? null,
                'created_by' => auth()->id(),
            ]);
            session()->flash('message', 'Parcel registered successfully.');
        }

        $this->cancelEdit();
        return $this->redirect(route('dashboard', ['view' => 'parcels']), navigate: true);
    }

    public function deleteParcel($id)
    {
        Parcel::findOrFail($id)->delete();
        session()->flash('message', 'Parcel deleted successfully.');
    }

    public function render()
    {
        return view('livewire.parcel-management', [
            'parcels' => Parcel::where(function($query) {
                    $query->where('tracking_number', 'like', '%' . $this->search . '%')
                        ->orWhere('parcel_name', 'like', '%' . $this->search . '%')
                        ->orWhere('sender_name', 'like', '%' . $this->search . '%')
                        ->orWhere('receiver_name', 'like', '%' . $this->search . '%')
                        ->orWhere('origin', 'like', '%' . $this->search . '%')
                        ->orWhere('destination', 'like', '%' . $this->search . '%')
                        ->orWhere('creator_office', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate($this->perPage),
            'stations' => $this->getStations(),
            'buses' => Bus::orderBy('plate_number')->get(),
        ]);
    }
}
