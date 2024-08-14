<?php

namespace App\Livewire\Withdraw;

use App\Models\Withdrawal;
use Livewire\Attributes\On;
use Livewire\Component;

class WithdrawalInvoice extends Component
{
    public $withdrawal_details;


    // Get Withdrawal Invoice Details
    #[On('GetWithdrawalInvoice')]
    public function WithdrawalInvoiceDetails($withdrawal_id)
    {
        $this->withdrawal_details = Withdrawal::with('user.withdrawal_method')->findorFail($withdrawal_id);

        // dd($this->withdrawal_details);
    }

    public function render()
    {
        return view('livewire.withdraw.withdrawal-invoice');
    }
}
