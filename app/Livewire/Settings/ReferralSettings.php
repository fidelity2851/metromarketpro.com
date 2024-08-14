<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class ReferralSettings extends Component
{
    public $referral_active;
    public $pay_referral_once;
    public $pay_referral_without_deposit;
    public $referral_pay_type;
    public $referral_pay_rate;


    // Update Referral Settings
    public function UpdateReferralSettings()
    {
        $valid = $this->validate([
            'referral_active' => 'required|boolean|max:255',
            'pay_referral_once' => 'required|boolean|max:255',
            'pay_referral_without_deposit' => 'required|boolean|max:255',
            'referral_pay_type' => 'required_if:referral_active,1|nullable|string|max:255',
            'referral_pay_rate' => 'required_unless:referral_pay_type,null|nullable|numeric|max:255',
        ]);

        if ($valid) {
            $settings = Setting::updateOrCreate(
                ['status' => 1],
                [
                    'referral_active' => $this->referral_active ? true : false,
                    'pay_referral_once' => $this->pay_referral_once ? true : false,
                    'pay_referral_without_deposit' => $this->pay_referral_without_deposit ? true : false,
                    'referral_pay_type' => $this->referral_pay_type,
                    'referral_pay_rate' => $this->referral_pay_rate,
                ]
            );

            if ($settings) {
                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

                // Reload Referral Details
                $this->GetReferralSettings();
            }
        }
    }

    // Get Referral Details
    public function GetReferralSettings()
    {
        $settings = Setting::firstWhere('status', 1);
        if ($settings) {
            $this->referral_active = $settings->referral_active;
            $this->pay_referral_once = $settings->pay_referral_once;
            $this->pay_referral_without_deposit = $settings->pay_referral_without_deposit;
            $this->referral_pay_type = $settings->referral_pay_type;
            $this->referral_pay_rate = $settings->referral_pay_rate;
        }
    }

    public function mount()
    {
        $this->GetReferralSettings();
    }

    public function render()
    {
        return view('livewire.settings.referral-settings');
    }
}
