<?php

namespace App\Livewire\Client;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class ClientPayout extends Component
{
    use WithPagination;

    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        $payouts = Transaction::where('user_id', $this->user_id)->latest()->paginate(30);

        return view('livewire.client.client-payout', ['payouts' => $payouts]);
    }
}
