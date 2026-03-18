<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parcel;
use App\Models\Bus;
use Livewire\WithPagination;

class ParcelManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function getStations()
    {
        return \App\Models\BusRoute::all()->flatMap(function ($route) {
            $list = [$route->from, $route->to];
            if ($route->stations) {
                $extra = explode(',', $route->stations);
                foreach ($extra as $e) {
                    $list[] = trim($e);
                }
            }
            return $list;
        })->unique()->filter()->sort()->values();
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
    public $receiver_name;
    public $receiver_phone;
    public $origin;
    public $destination;
    public $amount;
    public $description;
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
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:20',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
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
        $this->receiver_name = $parcel->receiver_name;
        $this->receiver_phone = $parcel->receiver_phone;
        $this->origin = $parcel->origin;
        $this->destination = $parcel->destination;
        $this->amount = $parcel->amount;
        $this->description = $parcel->description;
        $this->status = $parcel->status;
        $this->bus_id = $parcel->bus_id;
        $this->travel_date = optional($parcel->travel_date)->format('Y-m-d') ?? now()->format('Y-m-d');
    }

    public function cancelEdit()
    {
        $this->reset(['editingParcelId', 'sender_name', 'sender_phone', 'receiver_name', 'receiver_phone', 'origin', 'destination', 'amount', 'description', 'status', 'bus_id', 'travel_date']);
        $this->travel_date = now()->format('Y-m-d');
        $this->resetErrorBag();
    }

    public function saveParcel()
    {
        $this->validate();

        if ($this->editingParcelId) {
            // Editing parcels is disabled for safety
            session()->flash('message', 'Editing existing parcels is not allowed.');
        } else {
            Parcel::create([
                'sender_name' => $this->sender_name,
                'sender_phone' => $this->sender_phone,
                'receiver_name' => $this->receiver_name,
                'receiver_phone' => $this->receiver_phone,
                'origin' => $this->origin,
                'destination' => $this->destination,
                'amount' => $this->amount,
                'description' => $this->description,
                'status' => 'pending',
                'bus_id' => $this->bus_id,
                'travel_date' => $this->travel_date,
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
                        ->orWhere('sender_name', 'like', '%' . $this->search . '%')
                        ->orWhere('receiver_name', 'like', '%' . $this->search . '%')
                        ->orWhere('origin', 'like', '%' . $this->search . '%')
                        ->orWhere('destination', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate($this->perPage),
            'stations' => $this->getStations(),
            'buses' => Bus::orderBy('plate_number')->get(),
        ]);
    }
}
