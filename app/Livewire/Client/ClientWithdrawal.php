<?php

namespace App\Livewire\Client;

use App\Models\Withdrawal;
use Livewire\Component;
use Livewire\WithPagination;

class ClientWithdrawal extends Component
{
    use WithPagination;

    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        $withdrawals = Withdrawal::where('user_id', $this->user_id)->latest()->paginate(30);

        return view('livewire.client.client-withdrawal', ['withdrawals' => $withdrawals]);
    }
}
