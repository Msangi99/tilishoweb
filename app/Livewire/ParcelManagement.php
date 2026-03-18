<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parcel;
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

    public function mount()
    {
        $this->action = request()->query('action');
        $this->parcelId = request()->query('id');
        if ($this->action === 'edit' && $this->parcelId) {
            $this->editParcel((int) $this->parcelId);
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
            'status' => 'required|in:pending,in-transit,delivered,cancelled',
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
    }

    public function cancelEdit()
    {
        $this->reset(['editingParcelId', 'sender_name', 'sender_phone', 'receiver_name', 'receiver_phone', 'origin', 'destination', 'amount', 'description', 'status']);
        $this->resetErrorBag();
    }

    public function saveParcel()
    {
        $this->validate();

        if ($this->editingParcelId) {
            $parcel = Parcel::findOrFail($this->editingParcelId);
            $parcel->update([
                'sender_name' => $this->sender_name,
                'sender_phone' => $this->sender_phone,
                'receiver_name' => $this->receiver_name,
                'receiver_phone' => $this->receiver_phone,
                'origin' => $this->origin,
                'destination' => $this->destination,
                'amount' => $this->amount,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Parcel updated successfully.');
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
                'status' => $this->status,
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
            'stations' => $this->getStations()
        ]);
    }
}
