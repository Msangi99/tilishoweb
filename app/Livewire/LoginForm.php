<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginForm extends Component
{
    public $username;
    public $password;

    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->flash('message', 'Karibu tena!');
            return redirect()->to('/dashboard');
        } else {
            session()->flash('error', 'Username au password sio sahihi.');
        }
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}
