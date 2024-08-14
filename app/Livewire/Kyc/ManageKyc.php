<?php

namespace App\Livewire\Kyc;

use App\Enums\KycStatus;
use App\Livewire\KycModal;
use App\Models\KYC;
use App\Models\User;
use App\Notifications\ApprovedKyc;
use App\Notifications\RejectedKyc;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ManageKyc extends Component
{
    public $kyc;

    public $id_verify = false;
    public $address_verify = false;
    public $passport_verify = false;

    public $id_reason;
    public $address_reason;
    public $passport_reason;


    public function UpdateKyc()
    {
        $valid = $this->validate([
            'id_verify' => 'required|boolean|max:255',
            'id_reason' => 'required_if:id_verify,false|nullable|string|max:255',
            // 'address_verify' => 'required|boolean|max:255',
            // 'address_reason' => 'required_if:address_verify,false|nullable|string|max:255',
            // 'passport_verify' => 'required|boolean|max:255',
            // 'passport_reason' => 'required_if:passport_verify,false|nullable|string|max:255',
        ]);

        if ($valid) {
            KYC::where('id', $this->kyc->id)->update([
                'verify_reason' => $this->id_reason,
                // 'address_reason' => $this->address_reason,
                // 'passport_reason' => $this->passport_reason,
                'status' => ($this->id_verify == true) ? KycStatus::APPROVED->value : KycStatus::REJECTED->value,
            ]);

            $kyc = KYC::findOrFail($this->kyc->id);

            if ($this->id_verify == true) {
                User::where('id', $this->kyc->user_id)->update([
                    'isVerified' => true,
                ]);

                // Send Notification
                Notification::send($kyc->user, new ApprovedKyc($kyc));
            } else {
                User::where('id', $this->kyc->user_id)->update([
                    'isVerified' => false,
                ]);

                // Send Notification
                Notification::send($kyc->user, new RejectedKyc($kyc));
            }
        }

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'KYC Updated Successfully.']);

        // Refetch the Kyc Data
        $this->GetKyc($this->kyc->id);
    }

    public function GetKyc($kyc)
    {
        $this->kyc = KYC::findOrFail($kyc);

        $this->id_verify = $this->kyc->status == KycStatus::APPROVED->value ? true : false;
        // $this->address_verify = $this->kyc->status == KycStatus::APPROVED->value ? true : false;
        // $this->passport_verify = $this->kyc->status == KycStatus::APPROVED->value ? true : false;

        $this->id_reason = $this->kyc->verify_reason;
        // $this->address_reason = $this->kyc->address_reason;
        // $this->passport_reason = $this->kyc->passport_reason;
    }

    public function mount($kyc)
    {
        $this->GetKyc($kyc);
    }

    public function render()
    {
        return view('livewire.kyc.manage-kyc');
    }
}
