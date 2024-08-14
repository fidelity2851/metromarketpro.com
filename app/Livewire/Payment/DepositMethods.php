<?php

namespace App\Livewire\Payment;

use App\Models\DepositMethod;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DepositMethods extends Component
{
    use WithPagination;

    public $per_page = 30;

    public function DeleteDepositMethod($id){
        DepositMethod::findorFail($id)->delete();
    }

    public function DisableMethod($id) {
        DepositMethod::findorFail($id)->update([
            'status' => false
        ]);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Deposit Method Disbaled Successfully.']);
    }
    
    public function EnableMethod($id) {
        DepositMethod::findorFail($id)->update([
            'status' => true
        ]);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Deposit Method Enabled Successfully.']);
    }
    
    #[On('DepositMethodCreated')]
    public function render()
    {
        $all_methods = DepositMethod::paginate($this->per_page);
        return view('livewire.payment.deposit-methods', ['methods' => $all_methods]);
    }
}
