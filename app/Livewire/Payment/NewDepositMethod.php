<?php

namespace App\Livewire\Payment;

use App\Enums\DepositMethod as EnumsDepositMethod;
use App\Models\DepositMethod;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewDepositMethod extends Component
{
    use WithFileUploads;

    public $title;
    public $deposit_method;
    public $wallet_address;
    public $network_type;
    public $bank_name;
    public $account_number;
    public $account_name;
    public $min_deposit;
    public $fee = 0;
    public $logo;
    public $qr_code;



    public function CreateDepositMethod()
    {
        $valid = $this->validate([
            'title' => 'required|string|max:255',
            'deposit_method' => 'required|string|max:255',
            'qr_code' => 'required_if:deposit_method,Crypto|max:2000',
            'wallet_address' => 'required_if:deposit_method,Crypto|nullable|string|max:255',
            'network_type' => 'required_if:deposit_method,Crypto|nullable|string|max:255',
            'bank_name' => 'required_if:deposit_method,Wire Transfer|nullable|string|max:255',
            'account_number' => 'required_if:deposit_method,Wire Transfer|nullable|string|max:255',
            'account_name' => 'required_if:deposit_method,Wire Transfer|nullable|string|max:255',
            'min_deposit' => 'required|numeric|',
            'fee' => 'required|numeric|',
            'logo' => 'required|image:png, image:jpg, image:jpeg|max:2000',
        ]);

        if ($valid) {
            // Generate new image path
            $logo_name = bin2hex(random_bytes(5)) . $this->logo->getClientOriginalName();
            if ($this->qr_code) {
                $qr_code = bin2hex(random_bytes(5)) . $this->qr_code->getClientOriginalName();
            }

            $deposit_method = DepositMethod::create([
                'name' => $this->title,
                'deposit_method' => $this->deposit_method,
                'qr_code' => $this->qr_code,
                'wallet_address' => $this->wallet_address,
                'network_type' => $this->network_type,
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'account_name' => $this->account_name,
                'min_deposit' => $this->min_deposit,
                'fee' => $this->fee,
                'logo' => strval($logo_name),
            ]);

            if ($deposit_method) {
                $this->logo->storeAs('public/settings/deposit_method/', $logo_name);
                if ($this->qr_code) {
                    $this->qr_code->storeAs('public/settings/deposit_method/', $qr_code);
                }

                // Reset Variables
                $this->reset(['title', 'deposit_method', 'qr_code', 'wallet_address', 'network_type', 'bank_name', 'account_number', 'account_name', 'min_deposit', 'fee', 'logo',]);

                // Dispatch created successfully
                $this->dispatch('DepositMethodCreated');

                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'New Deposit Method Created Successfully.']);
            }
        }
    }

    public function render()
    {
        return view('livewire.payment.new-deposit-method');
    }
}
