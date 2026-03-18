<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parcel;
use App\Models\Bus;
use Illuminate\Support\Facades\Auth;

class ParcelScanner extends Component
{
    public $tracking_number;
    public $parcel;
    public $bus;
    public $travel_date;
    public $start_travel_time;
    public $end_travel_time;
    public $error;
    public $success;

    public function mount()
    {
        $this->travel_date = now()->format('Y-m-d');
    }

    public function processScan()
    {
        $this->reset(['error', 'success', 'parcel', 'bus']);

        $user = Auth::user();
        $this->bus = $user->assignedBus();

        if (!$this->bus) {
            $this->error = "Hujapangiwa bas lolote. Tafadhali wasiliana na Admin.";
            return;
        }

        $this->parcel = Parcel::where('tracking_number', $this->tracking_number)->first();

        if (!$this->parcel) {
            $this->error = "Mzigo wenye namba hii ({$this->tracking_number}) haujapatikana.";
            return;
        }

        if ($this->parcel->scanned_by) {
            $this->error = "Mzigo huu tayari umeshascanishwa na " . $this->parcel->scannedBy->name . " kwenye bas " . ($this->parcel->bus->plate_number ?? 'Unknown') . ".";
            $this->parcel = null;
            return;
        }
    }

    public function saveScan()
    {
        if (!$this->parcel || !$this->bus) {
            $this->error = "Hitilafu imetokea. Tafadhali jaribu tena.";
            return;
        }

        $now = now();

        $this->parcel->update([
            'scanned_by' => Auth::id(),
            'bus_id' => $this->bus->id,
            'travel_date' => $now->toDateString(),
            'start_travel_time' => $now->format('H:i'),
            'end_travel_time' => null,
            'status' => 'packed', // Initial scanned status
        ]);

        $this->success = "Mzigo {$this->parcel->tracking_number} umescanishwa kikamilifu kwenye bas {$this->bus->plate_number}!";
        $this->reset(['tracking_number', 'parcel']);
    }

    public function render()
    {
        return view('livewire.parcel-scanner');
    }
}
