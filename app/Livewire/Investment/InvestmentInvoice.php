<?php

namespace App\Livewire\Investment;

use App\Models\Investment;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class InvestmentInvoice extends Component
{
    use WithPagination;

    public $investment_details;


    // Get Investment Invoice Details
    #[On('GetInvestmentInvoice')]
    public function InvestmentInvoiceDetails($invest_id)
    {
        $this->investment_details = Investment::withWhereHas('transaction', function ($query) {
            $query->where('status', true)->latest()->limit(100);
        })->with('user', 'plan')->findorFail($invest_id);

    }

    public function render()
    {
        return view('livewire.investment.investment-invoice');
    }
}
