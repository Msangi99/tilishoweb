<?php

namespace App\Livewire;

use App\Models\Office;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeManagement extends Component
{
    use WithPagination;

    public $showList = true;

    public $search = '';
    public $perPage = 10;

    public $editingOfficeId;
    public $name = '';

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('offices', 'name')->ignore($this->editingOfficeId),
            ],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function editOffice($id): void
    {
        if (! Schema::hasTable('offices')) {
            return;
        }

        $this->showList = false;
        $this->resetErrorBag();
        $this->editingOfficeId = $id;
        $office = Office::findOrFail($id);
        $this->name = $office->name;
    }

    public function cancelEdit(): void
    {
        $this->reset(['editingOfficeId', 'name']);
        $this->resetErrorBag();
    }

    public function showOfficeList(): void
    {
        $this->showList = true;
        $this->cancelEdit();
    }

    public function showCreateForm(): void
    {
        $this->showList = false;
        $this->cancelEdit();
    }

    public function saveOffice(): void
    {
        if (! Schema::hasTable('offices')) {
            session()->flash('message', 'Database is not ready: run php artisan migrate on the server to create the offices table.');

            return;
        }

        $this->validate();

        $name = trim($this->name);

        if ($this->editingOfficeId) {
            $office = Office::findOrFail($this->editingOfficeId);
            $office->update(['name' => $name]);
            session()->flash('message', 'Office updated successfully.');
        } else {
            Office::create(['name' => $name]);
            session()->flash('message', 'Office added successfully.');
        }

        $this->cancelEdit();
    }

    public function deleteOffice($id): void
    {
        if (! Schema::hasTable('offices')) {
            return;
        }

        Office::findOrFail($id)->delete();
        session()->flash('message', 'Office deleted successfully.');
    }

    public function render()
    {
        if (! Schema::hasTable('offices')) {
            return view('livewire.office-management', [
                'offices' => new LengthAwarePaginator([], 0, max(1, (int) $this->perPage)),
                'officesTableMissing' => true,
            ]);
        }

        return view('livewire.office-management', [
            'offices' => Office::query()
                ->when($this->search !== '', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })
                ->orderBy('name')
                ->paginate($this->perPage),
            'officesTableMissing' => false,
        ]);
    }
}
