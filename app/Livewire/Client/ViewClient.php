<?php

namespace App\Livewire\Client;

use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Livewire\Component;
use Livewire\WithPagination;

class ViewClient extends Component
{
    use WithPagination;

    public $user;

    public $pending_deposit;





    public function TotalPendingDeposit()
    {
        $this->pending_deposit = Deposit::where('user_id', $this->user->id)->where('status', false)->sum('amount');
    }

    public function GetClient($user)
    {
        $this->user = User::findOrFail($user);
    }



    public function mount($user)
    {
        $this->GetClient($user);
        $this->TotalPendingDeposit();
    }

    public function render()
    {
        return view('livewire.client.view-client');
    }
}
