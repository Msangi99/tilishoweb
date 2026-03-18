<?php

namespace App\Livewire;

use App\Models\BusRoute;
use Livewire\Component;
use Livewire\WithPagination;

class RouteManagement extends Component
{
    use WithPagination;

    /** When true, show list of routes (default). When false, show create/edit form. */
    public $showList = true;

    public $search = '';
    public $perPage = 10;
    
    public $editingRouteId;
    public $from;
    public $to;
    public $stations;

    public $locations = [
        'Arusha',
        'Dar es Salaam',
        'Dodoma',
        'Iringa',
        'Kagera',
        'Katavi',
        'Kigoma',
        'Kilimanjaro',
        'Lindi',
        'Manyara',
        'Mara',
        'Marangu',
        'Mbeya',
        'Morogoro',
        'Moshi',
        'Mtwara',
        'Mwanza',
        'Njombe',
        'Pemba North',
        'Pemba South',
        'Pwani',
        'Rombo',
        'Rukwa',
        'Ruvuma',
        'Shinyanga',
        'Simiyu',
        'Singida',
        'Songwe',
        'Tabora',
        'Tanga',
        'Tarakea',
        'Zanzibar Central/South',
        'Zanzibar North',
        'Zanzibar Urban/West',
    ];

    protected $rules = [
        'from' => 'required|string|max:255',
        'to' => 'required|string|max:255',
        'stations' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editRoute($id)
    {
        $this->showList = false;
        $this->editingRouteId = $id;
        $route = BusRoute::findOrFail($id);
        
        $this->from = $route->from;
        $this->to = $route->to;
        $this->stations = $route->stations;

        $this->dispatch('open-route-modal');
    }

    public function cancelEdit()
    {
        $this->reset(['editingRouteId', 'from', 'to', 'stations']);
        $this->resetErrorBag();
    }

    public function showRouteList()
    {
        $this->showList = true;
        $this->cancelEdit();
    }

    public function showCreateForm()
    {
        $this->showList = false;
        $this->cancelEdit();
    }

    public function saveRoute()
    {
        $this->validate();

        if ($this->editingRouteId) {
            $route = BusRoute::findOrFail($this->editingRouteId);
            $route->update([
                'from' => $this->from,
                'to' => $this->to,
                'stations' => $this->stations,
            ]);
            session()->flash('message', 'Route updated successfully.');
        } else {
            BusRoute::create([
                'from' => $this->from,
                'to' => $this->to,
                'stations' => $this->stations,
            ]);
            session()->flash('message', 'Route added successfully.');
        }

        $this->cancelEdit();
        $this->dispatch('route-saved');
    }

    public function deleteRoute($id)
    {
        BusRoute::findOrFail($id)->delete();
        session()->flash('message', 'Route deleted successfully.');
    }

    public function render()
    {
        return view('livewire.route-management', [
            'routes' => BusRoute::where(function($query) {
                    $query->where('from', 'like', '%' . $this->search . '%')
                        ->orWhere('to', 'like', '%' . $this->search . '%')
                        ->orWhere('stations', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate($this->perPage)
        ]);
    }
}
