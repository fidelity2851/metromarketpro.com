<?php

namespace App\Livewire\Transfer;

use App\Models\Transfer;
use Livewire\Attributes\On;
use Livewire\Component;

class TransferInvoice extends Component
{
    public $transfer_details;


    // Get transfer Invoice Details
    #[On('GetTransferInvoice')]
    public function TransferInvoiceDetails($transfer_id)
    {
        $this->transfer_details = Transfer::with('sender', 'receiver')->findorFail($transfer_id);

        // dd($this->transfer_details);
    }

    public function render()
    {
        return view('livewire.transfer.transfer-invoice');
    }
}
