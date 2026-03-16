<?php

namespace App\Livewire;

use Livewire\Component;

class ParcelForm extends Component
{
    public $sender_name;
    public $sender_phone;
    public $receiver_name;
    public $receiver_phone;
    public $origin;
    public $destination;
    public $parcel_description;
    public $success_message;

    protected $rules = [
        'sender_name' => 'required|min:3',
        'sender_phone' => 'required',
        'receiver_name' => 'required|min:3',
        'receiver_phone' => 'required',
        'origin' => 'required',
        'destination' => 'required',
        'parcel_description' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        // In a real app, logic to save parcel would go here.
        // For this demo, we just show a success message.

        $this->success_message = "Mizigo imesajiliwa kikamilifu! Tutawasiliana nawe hivi punde.";
        $this->reset(['sender_name', 'sender_phone', 'receiver_name', 'receiver_phone', 'origin', 'destination', 'parcel_description']);
    }

    public function render()
    {
        return view('livewire.parcel-form');
    }
}
