<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class SiteSettings extends Component
{

    public $must_verify_email;
    public $allow_deposit;
    public $allow_investment;
    public $allow_withdrawal;
    public $allow_transfer;
    public $allow_withdraw_deposit;
    

    // Update Site Settings
    public function UpdateSiteSettings() {
        $valid = $this->validate([
            'must_verify_email' => 'required|boolean|max:255',
            'allow_deposit' => 'required|boolean|max:255',
            'allow_investment' => 'required|boolean|max:255',
            'allow_withdrawal' => 'required|boolean|max:255',
            'allow_transfer' => 'required|boolean|max:255',
            'allow_withdraw_deposit' => 'required|boolean|max:255',
        ]);

        if ($valid) {
            $settings = Setting::updateOrCreate(
                ['status' => 1],
                [
                    'must_verify_email' => $this->must_verify_email ? true : false,
                    'allow_deposit' => $this->allow_deposit ? true : false,
                    'allow_investment' => $this->allow_investment ? true : false,
                    'allow_withdrawal' => $this->allow_withdrawal ? true : false,
                    'allow_transfer' => $this->allow_transfer ? true : false,
                    'allow_withdraw_deposit' => $this->allow_withdraw_deposit ? true : false,
                ]
            );

            if ($settings) {
                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

                // Reload Site Details
                $this->GetSiteSettings();
            }
        }
    }

    // Get Site Details
    public function GetSiteSettings()
    {
        $settings = Setting::firstWhere('status', 1);
        if ($settings) {
            $this->must_verify_email = $settings->must_verify_email;
            $this->allow_deposit = $settings->allow_deposit;
            $this->allow_investment = $settings->allow_investment;
            $this->allow_withdrawal = $settings->allow_withdrawal;
            $this->allow_transfer = $settings->allow_transfer;
            $this->allow_withdraw_deposit = $settings->allow_withdraw_deposit;
        }
    }
    
    public function  mount() {
        $this->GetSiteSettings();
    }
    
    public function render()
    {
        return view('livewire.settings.site-settings');
    }
}
