<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parcel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public $createdCount;
    public $createdAmount;
    public $transportedCount;
    public $transportedAmount;
    public $receivedCount;
    public $receivedAmount;
    public $chartData;

    public function mount()
    {
        $this->calculateStats();
    }

    public function calculateStats()
    {
        $userId = Auth::id();

        // Parcels this staff created
        $this->createdCount = Parcel::where('created_by', $userId)->count();
        $this->createdAmount = Parcel::where('created_by', $userId)->sum('amount');

        // Parcels this staff is recorded as transporter
        $this->transportedCount = Parcel::where('transported_by_id', $userId)->count();
        $this->transportedAmount = Parcel::where('transported_by_id', $userId)->sum('amount');

        // Parcels this staff received
        $this->receivedCount = Parcel::where('received_by_id', $userId)->count();
        $this->receivedAmount = Parcel::where('received_by_id', $userId)->sum('amount');

        // Chart Data (Last 7 days)
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');
            $counts[] = Parcel::where('created_by', $userId)
                ->whereDate('created_at', $date)
                ->count();
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
