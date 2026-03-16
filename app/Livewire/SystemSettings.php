<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SystemSetting;

class SystemSettings extends Component
{
    public $sender_id;
    public $api_key;

    public function mount()
    {
        $this->sender_id = SystemSetting::where('key', 'sms_sender_id')->first()?->value ?? '';
        $this->api_key = SystemSetting::where('key', 'sms_api_key')->first()?->value ?? '';
    }

    public function saveSmsSettings()
    {
        $this->validate([
            'sender_id' => 'required|string|max:50',
            'api_key' => 'required|string|max:255',
        ]);

        SystemSetting::updateOrCreate(
            ['key' => 'sms_sender_id'],
            ['value' => $this->sender_id]
        );

        SystemSetting::updateOrCreate(
            ['key' => 'sms_api_key'],
            ['value' => $this->api_key]
        );

        session()->flash('message', 'SMS Settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.system-settings');
    }
}
