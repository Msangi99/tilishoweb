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
    public $weekTotalCount;
    public $weekTotalAmount;
    public $monthTotalCount;
    public $monthTotalAmount;
    public $chartData;

    public function mount()
    {
        $this->calculateStats();
    }

    public function calculateStats()
    {
        $userId = Auth::id();

        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Parcels this staff created
        $this->createdCount = Parcel::where('created_by', $userId)->count();
        $this->createdAmount = Parcel::where('created_by', $userId)->sum('amount');

        // Parcels this staff is recorded as transporter
        $this->transportedCount = Parcel::where('transported_by_id', $userId)->count();
        $this->transportedAmount = Parcel::where('transported_by_id', $userId)->sum('amount');

        // Parcels this staff received
        $this->receivedCount = Parcel::where('received_by_id', $userId)->count();
        $this->receivedAmount = Parcel::where('received_by_id', $userId)->sum('amount');

        // Weekly totals where this staff participated (created, transported or received)
        $this->weekTotalCount = Parcel::where(function ($q) use ($userId) {
                $q->where('created_by', $userId)
                  ->orWhere('transported_by_id', $userId)
                  ->orWhere('received_by_id', $userId);
            })
            ->where('created_at', '>=', $startOfWeek)
            ->count();

        $this->weekTotalAmount = Parcel::where(function ($q) use ($userId) {
                $q->where('created_by', $userId)
                  ->orWhere('transported_by_id', $userId)
                  ->orWhere('received_by_id', $userId);
            })
            ->where('created_at', '>=', $startOfWeek)
            ->sum('amount');

        // Monthly totals where this staff participated
        $this->monthTotalCount = Parcel::where(function ($q) use ($userId) {
                $q->where('created_by', $userId)
                  ->orWhere('transported_by_id', $userId)
                  ->orWhere('received_by_id', $userId);
            })
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        $this->monthTotalAmount = Parcel::where(function ($q) use ($userId) {
                $q->where('created_by', $userId)
                  ->orWhere('transported_by_id', $userId)
                  ->orWhere('received_by_id', $userId);
            })
            ->where('created_at', '>=', $startOfMonth)
            ->sum('amount');

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
