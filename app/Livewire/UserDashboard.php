<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parcel;
use Carbon\Carbon;

class UserDashboard extends Component
{
    public $todayCount;
    public $todayAmount;
    public $weekCount;
    public $weekAmount;
    public $chartData;

    public function mount()
    {
        $this->calculateStats();
    }

    public function calculateStats()
    {
        // For staff, we might want to filter by their own registrations
        // but often they want to see the branch/general activity.
        // I'll show general activity for now as it's a "summary page".
        
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();

        $this->todayCount = Parcel::whereDate('created_at', $today)->count();
        $this->todayAmount = Parcel::whereDate('created_at', $today)->sum('amount');

        $this->weekCount = Parcel::where('created_at', '>=', $startOfWeek)->count();
        $this->weekAmount = Parcel::where('created_at', '>=', $startOfWeek)->sum('amount');

        // Chart Data (Last 7 days)
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');
            $counts[] = Parcel::whereDate('created_at', $date)->count();
        }

        $this->chartData = [
            'labels' => $labels,
            'counts' => $counts
        ];
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
