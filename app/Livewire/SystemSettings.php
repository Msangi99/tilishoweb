<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SystemSetting;

class SystemSettings extends Component
{
    public $sms_enabled = false;

    public $sender_id;

    public $api_key;

    public string $fee_tra_percent = '18';

    public string $fee_developer_percent = '3';

    public function mount()
    {
        $this->sms_enabled = (bool) ((int) (SystemSetting::getValue('sms_enabled', 0)));
        $this->sender_id = (string) SystemSetting::getValue('sms_sender_id', '');
        $this->api_key = (string) SystemSetting::getValue('sms_api_key', '');
        $this->fee_tra_percent = (string) SystemSetting::getValue('fee_tra_percent', '18');
        $this->fee_developer_percent = (string) SystemSetting::getValue('fee_developer_percent', '3');
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

    public function saveFeePercentages(): void
    {
        $this->validate([
            'fee_tra_percent' => 'required|numeric|min:0|max:100',
            'fee_developer_percent' => 'required|numeric|min:0|max:100',
        ]);

        SystemSetting::setValue('fee_tra_percent', (string) $this->fee_tra_percent);
        SystemSetting::setValue('fee_developer_percent', (string) $this->fee_developer_percent);

        session()->flash('message', 'Fee percentages updated successfully.');
    }

    public function render()
    {
        return view('livewire.system-settings');
    }
}
