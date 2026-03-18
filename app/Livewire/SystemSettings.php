<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SystemSetting;

class SystemSettings extends Component
{
    public $sms_enabled = false;
    public $sender_id;
    public $api_key;

    public function mount()
    {
        $this->sms_enabled = (bool) ((int) (SystemSetting::getValue('sms_enabled', 0)));
        $this->sender_id = (string) SystemSetting::getValue('sms_sender_id', '');
        $this->api_key = (string) SystemSetting::getValue('sms_api_key', '');
    }

    public function saveSmsSettings()
    {
        $this->validate([
            'sms_enabled' => 'boolean',
            'sender_id' => 'required|string|max:50',
            'api_key' => 'required|string|max:255',
        ]);

        SystemSetting::setValue('sms_enabled', $this->sms_enabled ? '1' : '0');
        SystemSetting::setValue('sms_sender_id', $this->sender_id);
        SystemSetting::setValue('sms_api_key', $this->api_key);

        session()->flash('message', 'SMS Settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.system-settings');
    }
}
