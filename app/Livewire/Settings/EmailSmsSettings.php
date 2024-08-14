<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class EmailSmsSettings extends Component
{
    public $smtp_host;
    public $smtp_port;
    public $smtp_protocol;
    public $smtp_user;
    public $smtp_password;
    public $sms_phone;
    public $sms_active;



    // Update Email & Sms Settings
    public function UpdateEmailSmsSettings()
    {
        $valid = $this->validate([
            'smtp_host' => 'nullable|string|max:255|',
            'smtp_port' => 'nullable|string|max:255|',
            'smtp_protocol' => 'nullable|string|max:255|',
            'smtp_user' => 'nullable|string|max:255|',
            'smtp_password' => 'nullable|string|max:255|',
            'sms_phone' => 'required_if:sms_active,1|nullable|string|max:255|',
            'sms_active' => 'nullable|boolean|max:255|',
        ]);

        if ($valid) {
            $settings = Setting::updateOrCreate(
                ['status' => 1],
                [
                'smtp_host' => $this->smtp_host,
                'smtp_port' => $this->smtp_port,
                'smtp_protocol' => $this->smtp_protocol,
                'smtp_user' => $this->smtp_user,
                'smtp_password' => $this->smtp_password,
                'sms_phone' => $this->sms_phone,
                'sms_active' => $this->sms_active ? true : false,
            ]);

            if ($settings) {
                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

                // Get Settings Values
                $this->GetEmailSmsSettings();
            }
        }
    }

    // Get Email & Sms Settings
    public function GetEmailSmsSettings()
    {
        $settings = Setting::where('status', 1)->first();

        if ($settings) {
            $this->smtp_host = $settings->smtp_host;
            $this->smtp_port = $settings->smtp_port;
            $this->smtp_protocol = $settings->smtp_protocol;
            $this->smtp_user = $settings->smtp_user;
            $this->smtp_password = $settings->smtp_password;
            $this->sms_phone = $settings->sms_phone;
            $this->sms_active = $settings->sms_active;
        }
    }

    public function mount()
    {
        $this->GetEmailSmsSettings();
    }

    public function render()
    {
        return view('livewire.settings.email-sms-settings');
    }
}
