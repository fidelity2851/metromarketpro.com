<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class KycVerificationSettings extends Component
{
    public $kyc_active;
    public $deposit_without_kyc;
    public $withdraw_without_kyc;


    // Update KYC Settings
    public function UpdateKycSettings() {
        $valid = $this->validate([
            'kyc_active' => 'required|boolean|max:255',
            'deposit_without_kyc' => 'required|boolean|max:255',
            'withdraw_without_kyc' => 'required|boolean|max:255',
        ]);

        if($valid){
            $settings = Setting::updateOrCreate(
                ['status' => 1],
                [
                    'kyc_active' => $this->kyc_active ? true : false,
                    'deposit_without_kyc' => $this->deposit_without_kyc ? true : false,
                    'withdraw_without_kyc' => $this->withdraw_without_kyc ? true : false,
                ]
            );

            if ($settings) {
                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

                // Reload KYC Settings
                $this->GetKycSettings();
            }
        }
    }

    // Get KYC Settings
    public function GetKycSettings(){
        $settings = Setting::firstWhere('status', 1);

        if($settings){
            $this->kyc_active = $settings->kyc_active;
            $this->deposit_without_kyc = $settings->deposit_without_kyc;
            $this->withdraw_without_kyc = $settings->withdraw_without_kyc;
        }
    }

    public function mount() {
        $this->GetKycSettings();
    }
    
    public function render()
    {
        return view('livewire.settings.kyc-verification-settings');
    }
}
