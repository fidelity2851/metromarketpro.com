<?php

namespace App\Livewire\Investment;

use App\Models\Investment;
use Livewire\Component;

class EditProfit extends Component
{
    public $invest_id;
    public $type;
    public $amount;

    public function UpdateProfit()
    {
        $this->validate([
            'type' => 'required|integer|',
            'amount' => 'required|numeric|min:1',
        ]);
        $invest = Investment::findorFail($this->invest_id);
        if ($this->type == 1) {
            // Top up profit
            $invest->transaction()->create([
                'user_id' => $invest->user_id,
                'trx_num' => strval(bin2hex(random_bytes(10))),
                'amount' => $this->amount,
                'post_amount' => $this->amount,
                'status' => true,
            ]);
            $invest->increment('acc_profit', $this->amount);
        } else if ($this->type == 2) {
            // Reduce profit
            $invest->transaction()->create([
                'user_id' => $invest->user_id,
                'trx_num' => strval(bin2hex(random_bytes(10))),
                'amount' => -$this->amount,
                'post_amount' => $this->amount,
                'status' => true,
            ]);
            $invest->decrement('acc_profit', $this->amount);
        }

        $this->reset('type', 'amount');

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Successfully.']);
    }
    public function render()
    {
        return view('livewire.investment.edit-profit');
    }

    public function mount($invest_id)
    {
        $this->invest_id = $invest_id;
    }
}
