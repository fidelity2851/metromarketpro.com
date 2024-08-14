<?php

namespace App\Livewire\Deposit;

use App\Models\Deposit;
use Livewire\Attributes\On;
use Livewire\Component;

class DepositInvoice extends Component
{

    public $deposit_details;


    // Get Deposit Invoice Details
    #[On('GetDepositInvoice')]
    public function DepositInvoiceDetails($deposit_id)
    {
        $this->deposit_details = Deposit::with('user', 'deposit_method')->findorFail($deposit_id);
    }

    public function render()
    {
        return view('livewire.deposit.deposit-invoice');
    }
}
