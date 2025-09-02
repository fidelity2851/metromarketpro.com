<?php

namespace App\Livewire;

use App\Enums\KycStatus;
use App\Mail\KycUpload;
use App\Models\KYC;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class KycModal extends Component
{
    use WithFileUploads;

    public $verify_method;
    public $verify_proof;
    public $address_method;
    public $address_proof;
    public $passport;

    public $isSubmited = false;

    // Get User KYC Status
    public function KycStatus()
    {
        $kyc_status = KYC::firstWhere('user_id', auth()->id());

        if ($kyc_status) {
            switch ($kyc_status->status) {
                case 'Approved':
                    $this->isSubmited = true;
                    break;

                case 'Pending':
                    $this->isSubmited = true;
                    break;

                case 'Rejected':
                    $this->isSubmited = false;
                    break;

                default:
                    $this->isSubmited = false;
                    break;
            }
        }
    }

    // Upload KYC Documents
    public function UploadKyc()
    {
        $valid = $this->validate([
            'verify_method' => 'required|string|max:255',
            'verify_proof' => 'required_with:verify_method|image:png, image:jpg, image:jpeg|max:3000',
            // 'address_method' => 'required|string|max:255',
            // 'address_proof' => 'required_with:address_method|image:png, image:jpg, image:jpeg|max:3000',
            // 'passport' => 'required|image:png, image:jpg, image:jpeg|max:3000',
        ]);

        if ($valid) {
            // Generate new image path
            $verify_proof_name = bin2hex(random_bytes(5)) . $this->verify_proof->getClientOriginalName();
            // $address_proof_name = bin2hex(random_bytes(5)) . $this->address_proof->getClientOriginalName();
            // $passport_name = bin2hex(random_bytes(5)) . $this->passport->getClientOriginalName();

            // Delete Old Images if Exist
            $old_kyc = KYC::firstWhere('user_id', auth()->id());
            if ($old_kyc) {
                Storage::delete('public/kyc/' . $old_kyc->verify_proof);
                // Storage::delete('public/kyc/' . $old_kyc->address_proof);
                // Storage::delete('public/kyc/' . $old_kyc->passport);
            }

            // Update Or Create KYC Record
            $kyc = KYC::updateOrCreate(['user_id' => auth()->id()], [
                'user_id' => auth()->id(),
                'verify_method' => $this->verify_method,
                'verify_proof' => $verify_proof_name,
                // 'address_method' => $this->address_method,
                // 'address_proof' => $address_proof_name,
                // 'passport' => $passport_name,
                'status' => KycStatus::PENDING->value,
            ]);

            if ($kyc) {
                // Upload Images to Local Disk
                $this->verify_proof->storeAs('public/kyc/', $verify_proof_name);
                // $this->address_proof->storeAs('public/kyc/', $address_proof_name);
                // $this->passport->storeAs('public/kyc/', $passport_name);

                // Reset Variables
                $this->reset(['verify_method', 'verify_proof', 'address_method', 'address_proof', 'passport']);

                // Send Deposit Request Email
                Mail::to(env('DEFAULT_EMAIL', 'info@metrotradeglobal.com'))->send(new KycUpload($kyc));

                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'KYC Is Now Under Review.']);

                // Reload Kyc Status
                $this->KycStatus();
            }
        }
    }


    public function mount()
    {
        $this->KycStatus();
    }

    public function render()
    {
        return view('livewire.kyc-modal');
    }
}
