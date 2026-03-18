<?php

namespace App\Livewire;

use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BusManagement extends Component
{
    use WithPagination;

    /** When false, show create form first (default). When true, show list of buses. */
    public $showList = false;

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
        'drivers' => 'array',
        'drivers.*' => 'exists:users,id',
        'conductors' => 'array',
        'conductors.*' => 'exists:users,id',
        'attendants' => 'array',
        'attendants.*' => 'exists:users,id',
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editBus($id)
    {
        $this->showList = false;
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

    public function showBusList()
    {
        $this->showList = true;
        $this->cancelEdit();
    }

    public function showCreateForm()
    {
        $this->showList = false;
        $this->cancelEdit();
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
            'buses' => Bus::with('route')->where(function ($query) {
                    $query->where('plate_number', 'like', '%' . $this->search . '%')
                        ->orWhere('model', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate($this->perPage),
            'routes' => BusRoute::all(),
            // Only staff users can be assigned to buses
            'users' => User::where('role', 'staff')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
