<?php

namespace App\Livewire;

use App\Models\Office;
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
        Office::findOrFail($id)->delete();
        session()->flash('message', 'Office deleted successfully.');
    }

    public function render()
    {
        return view('livewire.office-management', [
            'offices' => Office::query()
                ->when($this->search !== '', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })
                ->orderBy('name')
                ->paginate($this->perPage),
        ]);
    }
}
