<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    public $editingUserId;
    public $name;
    public $username;
    public $email;
    public $phone;
    public $password;
    public $role = 'staff';

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $this->editingUserId,
            'email' => 'required|email|max:255|unique:users,email,' . $this->editingUserId,
            'phone' => 'nullable|string|max:20',
            'password' => $this->editingUserId ? 'nullable|string|min:8' : 'required|string|min:8',
            'role' => 'required|in:admin,staff',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editUser($id)
    {
        $this->editingUserId = $id;
        $user = User::findOrFail($id);
        
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->password = ''; // Clear password field

        $this->dispatch('open-user-modal');
    }

    public function cancelEdit()
    {
        $this->reset(['editingUserId', 'name', 'username', 'email', 'phone', 'password', 'role']);
        $this->role = 'staff';
        $this->resetErrorBag();
    }

    public function saveUser()
    {
        $this->validate();

        if ($this->editingUserId) {
            $user = User::findOrFail($this->editingUserId);
            $data = [
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);
            session()->flash('message', 'User updated successfully.');
        } else {
            User::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'password' => Hash::make($this->password),
            ]);
            session()->flash('message', 'User created successfully.');
        }

        $this->cancelEdit();
        $this->dispatch('user-saved');
    }

    public function render()
    {
        return view('livewire.user-management', [
            'users' => User::where(function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->where('username', '!=', 'admin')
                ->latest()
                ->paginate($this->perPage)
        ]);
    }
}
