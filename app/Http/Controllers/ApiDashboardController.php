<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiDashboardController extends Controller
{
    /**
     * Return dashboard statistics for the mobile app.
     */
    public function stats(Request $request)
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Totals
        $totalParcels = Parcel::count();
        $totalRevenue = Parcel::sum('amount');

        // Today
        $todayCount = Parcel::whereDate('created_at', $today)->count();
        $todayAmount = Parcel::whereDate('created_at', $today)->sum('amount');

        // This week
        $weekCount = Parcel::where('created_at', '>=', $startOfWeek)->count();
        $weekAmount = Parcel::where('created_at', '>=', $startOfWeek)->sum('amount');

        // This month
        $monthCount = Parcel::where('created_at', '>=', $startOfMonth)->count();
        $monthAmount = Parcel::where('created_at', '>=', $startOfMonth)->sum('amount');

        // This year
        $yearCount = Parcel::where('created_at', '>=', $startOfYear)->count();
        $yearAmount = Parcel::where('created_at', '>=', $startOfYear)->sum('amount');

        // Chart Data (Last 7 days)
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');
            $counts[] = Parcel::whereDate('created_at', $date)->count();
        }

        // Staff stats
        $totalStaff = User::where('role', 'staff')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // Recent activity (last 10 parcels)
        $recentParcels = Parcel::with(['createdBy', 'transportedBy', 'receivedBy'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function (Parcel $p) {
                return [
                    'id' => $p->id,
                    'tracking_number' => $p->tracking_number,
                    'sender_name' => $p->sender_name,
                    'receiver_name' => $p->receiver_name,
                    'origin' => $p->origin,
                    'destination' => $p->destination,
                    'amount' => $p->amount,
                    'status' => $p->display_status,
                    'created_at' => $p->created_at?->toDateTimeString(),
                    'created_by' => $p->createdBy?->name,
                    'transported_by' => $p->transportedBy?->name,
                    'received_by' => $p->receivedBy?->name,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'totals' => [
                    'parcels' => $totalParcels,
                    'revenue' => $totalRevenue,
                ],
                'today' => [
                    'count' => $todayCount,
                    'amount' => $todayAmount,
                ],
                'week' => [
                    'count' => $weekCount,
                    'amount' => $weekAmount,
                ],
                'month' => [
                    'count' => $monthCount,
                    'amount' => $monthAmount,
                ],
                'year' => [
                    'count' => $yearCount,
                    'amount' => $yearAmount,
                ],
                'chart' => [
                    'labels' => $labels,
                    'counts' => $counts,
                ],
                'staff' => [
                    'total_staff' => $totalStaff,
                    'total_admins' => $totalAdmins,
                ],
                'recent_parcels' => $recentParcels,
            ],
        ]);
    }
}
