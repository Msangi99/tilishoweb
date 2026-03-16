<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
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

        $todayCount = Parcel::whereDate('created_at', $today)->count();
        $todayAmount = Parcel::whereDate('created_at', $today)->sum('amount');

        $weekCount = Parcel::where('created_at', '>=', $startOfWeek)->count();
        $weekAmount = Parcel::where('created_at', '>=', $startOfWeek)->sum('amount');

        // Chart Data (Last 7 days)
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');
            $counts[] = Parcel::whereDate('created_at', $date)->count();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'today_count' => $todayCount,
                'today_amount' => $todayAmount,
                'week_count' => $weekCount,
                'week_amount' => $weekAmount,
                'chart' => [
                    'labels' => $labels,
                    'counts' => $counts,
                ],
            ],
        ]);
    }
}
