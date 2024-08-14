<?php

namespace App\Livewire\Payment;

use App\Models\DepositMethod;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditDepositMethod extends Component
{
    use WithFileUploads;

    public $method;

    public $title;
    public $deposit_method;
    public $wallet_address;
    public $network_type;
    public $bank_name;
    public $account_number;
    public $account_name;
    public $min_deposit;
    public $fee;
    public $logo;
    public $qr_code;
    public $old_logo;
    public $old_qr_code;

    public function UpdateDepositMethod()
    {
        $valid = $this->validate([
            'title' => 'required|string|max:255',
            'deposit_method' => 'required|string|max:255',
            'qr_code' => 'nullable|image:png, image:jpg, image:jpeg|max:2000',
            'wallet_address' => 'required_if:deposit_method,Crypto|nullable|string|max:255',
            'network_type' => 'required_if:deposit_method,Crypto|nullable|string|max:255',
            'bank_name' => 'required_if:deposit_method,Wire Transfer|nullable|string|max:255',
            'account_number' => 'required_if:deposit_method,Wire Transfer|nullable|string|max:255',
            'account_name' => 'required_if:deposit_method,Wire Transfer|nullable|string|max:255',
            'min_deposit' => 'required|numeric|',
            'fee' => 'required|numeric|',
            'logo' => 'nullable|image:png, image:jpg, image:jpeg|max:2000',
        ]);

        if ($valid) {

            $deposit_method = DepositMethod::where('id', $this->method->id)->update([
                'name' => $this->title,
                'deposit_method' => $this->deposit_method,
                'wallet_address' => $this->wallet_address,
                'network_type' => $this->network_type,
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'account_name' => $this->account_name,
                'min_deposit' => $this->min_deposit,
                'fee' => $this->fee,
            ]);


            if ($deposit_method) {
                if ($this->logo) {
                    // Generate new image path
                    $logo_name = bin2hex(random_bytes(5)) . $this->logo->getClientOriginalName();

                    // Delete Old Image if Exist
                    Storage::delete('public/settings/deposit_method/' . $this->method->logo);

                    DepositMethod::where('id', $this->method->id)->update([
                        'logo' => strval($logo_name),
                    ]);

                    $this->logo->storeAs('public/settings/deposit_method/', $logo_name);
                }

                if ($this->qr_code) {
                    // Generate new image path
                    $qr_code_name = bin2hex(random_bytes(5)) . $this->qr_code->getClientOriginalName();

                    // Delete Old Image if Exist
                    Storage::delete('public/settings/deposit_method/' . $this->method->qr_code);

                    DepositMethod::where('id', $this->method->id)->update([
                        'qr_code' => strval($qr_code_name),
                    ]);

                    $this->qr_code->storeAs('public/settings/deposit_method/', $qr_code_name);
                }

                $this->reset('logo', 'qr_code');

                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Deposit Method Updated Successfully.']);

                // Reload New Data
                $this->GetDepositMethod($this->method->id);
            }
        }
    }

    public function GetDepositMethod($method)
    {
        $this->method = DepositMethod::findorFail($method);

        $this->title = $this->method->name;
        $this->deposit_method = $this->method->deposit_method;
        $this->wallet_address = $this->method->wallet_address;
        $this->network_type = $this->method->network_type;
        $this->bank_name = $this->method->bank_name;
        $this->account_number = $this->method->account_number;
        $this->account_name = $this->method->account_name;
        $this->min_deposit = $this->method->min_deposit;
        $this->fee = $this->method->fee;
        $this->old_logo = $this->method->logo;
        $this->old_qr_code = $this->method->qr_code;
    }

    public function mount($method)
    {
        $this->GetDepositMethod($method);
    }

    public function render()
    {
        return view('livewire.payment.edit-deposit-method');
    }
}
