<?php

namespace App\Livewire\Profile;

use App\Models\WithdrawalMethod as ModelsWithdrawalMethod;
use Livewire\Component;

class WithdrawalMethod extends Component
{
    public $bitcoin_address;
    public $network_type;
    public $bank_name;
    public $account_number;
    public $account_name;

    public function UpdateWithdrawalMethod()
    {
        $valid = $this->validate([
            'bitcoin_address' => 'nullable|string|max:255',
            'network_type' => 'required_unless:bitcoin_address,null|nullable|string|max:255',
            'bank_name' => 'required_unless:account_number,null|nullable|string|max:255',
            'account_number' => 'required_unless:bank_name,null|nullable|string|max:255',
            'account_name' => 'required_unless:bank_name,null|nullable|string|max:255',
        ]);

        if ($valid) {
            $withdrawal = ModelsWithdrawalMethod::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'user_id' => auth()->id(),
                    'bitcoin_address' => $this->bitcoin_address,
                    'network_type' => $this->network_type,
                    'bank_name' => $this->bank_name,
                    'account_number' => $this->account_number,
                    'account_name' => $this->account_name,
                ]
            );

            if ($withdrawal) {
                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

                // Get User Withdrawal Details
                $this->GetWithdrawalDetails();
            }
        }
    }

    // Get User Withdrawal Details
    public function GetWithdrawalDetails() {
        $withdrawal = ModelsWithdrawalMethod::firstWhere('user_id', auth()->id());

        if ($withdrawal) {
           $this->bitcoin_address = $withdrawal->bitcoin_address;
           $this->network_type = $withdrawal->network_type;
           $this->bank_name = $withdrawal->bank_name;
           $this->account_number = $withdrawal->account_number;
           $this->account_name = $withdrawal->account_name;
        }
    }

    public function mount() {
        $this->GetWithdrawalDetails();
    }
    
    public function render()
    {
        return view('livewire.profile.withdrawal-method');
    }
}
