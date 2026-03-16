<?php

namespace App\Livewire;

use App\Models\Bus;
use App\Models\BusRoute;
use Livewire\Component;
use Livewire\WithPagination;

class BusManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    public $editingBusId;
    public $plate_number;
    public $status = 'active';
    public $route_id;

    // Dynamic Lists for staff
    public $drivers = [];
    public $conductors = [];
    public $attendants = [];

    protected $rules = [
        'plate_number' => 'required|string|max:20',
        'status' => 'required|string|in:active,maintenance,inactive',
        'route_id' => 'nullable|exists:bus_routes,id',
        'drivers.*.name' => 'required|string|max:255',
        'drivers.*.phone' => 'required|string|max:20',
        'conductors.*.name' => 'required|string|max:255',
        'conductors.*.phone' => 'required|string|max:20',
        'attendants.*.name' => 'required|string|max:255',
        'attendants.*.phone' => 'required|string|max:20',
    ];

    public function mount()
    {
        $this->plate_number = '';
        $this->status = 'active';
        $this->route_id = '';
        $this->drivers = [];
        $this->conductors = [];
        $this->attendants = [];
    }

    public function addDriver()
    {
        $this->drivers[] = ['name' => '', 'phone' => ''];
    }

    public function removeDriver($index)
    {
        unset($this->drivers[$index]);
        $this->drivers = array_values($this->drivers);
    }

    public function addConductor()
    {
        $this->conductors[] = ['name' => '', 'phone' => ''];
    }

    public function removeConductor($index)
    {
        unset($this->conductors[$index]);
        $this->conductors = array_values($this->conductors);
    }

    public function addAttendant()
    {
        $this->attendants[] = ['name' => '', 'phone' => ''];
    }

    public function removeAttendant($index)
    {
        unset($this->attendants[$index]);
        $this->attendants = array_values($this->attendants);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editBus($id)
    {
        $this->cancelEdit();
        $this->editingBusId = $id;
        $bus = Bus::findOrFail($id);
        
        $this->plate_number = $bus->plate_number;
        $this->status = $bus->status;
        $this->route_id = $bus->route_id;
        $this->drivers = $bus->drivers ?? [];
        $this->conductors = $bus->conductors ?? [];
        $this->attendants = $bus->attendants ?? [];

        $this->dispatch('open-bus-modal');
    }

    public function cancelEdit()
    {
        $this->reset(['editingBusId', 'plate_number', 'status', 'route_id', 'drivers', 'conductors', 'attendants']);
        $this->resetErrorBag();
    }

    public function saveBus()
    {
        $this->validate();

        $data = [
            'plate_number' => $this->plate_number,
            'status' => $this->status,
            'route_id' => $this->route_id ?: null,
            'drivers' => $this->drivers,
            'conductors' => $this->conductors,
            'attendants' => $this->attendants,
        ];

        if ($this->editingBusId) {
            Bus::findOrFail($this->editingBusId)->update($data);
            session()->flash('message', 'Bus updated successfully.');
        } else {
            Bus::create($data);
            session()->flash('message', 'Bus added successfully.');
        }

        $this->cancelEdit();
        $this->dispatch('bus-saved');
    }

    public function deleteBus($id)
    {
        Bus::findOrFail($id)->delete();
        session()->flash('message', 'Bus deleted successfully.');
    }

    public function render()
    {
        return view('livewire.bus-management', [
            'buses' => Bus::with('route')->where(function($query) {
                    $query->where('plate_number', 'like', '%' . $this->search . '%')
                        ->orWhere('model', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate($this->perPage),
            'routes' => BusRoute::all()
        ]);
    }
}
