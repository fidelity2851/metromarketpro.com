<?php

namespace App\Livewire\Client;

use App\Models\Deposit;
use Livewire\Component;
use Livewire\WithPagination;

class ClientDeposit extends Component
{
    use WithPagination;

    public $user_id;

    public function mount($user_id)
    {
       $this->user_id = $user_id;
    }

    public function render()
    {
        $deposits = Deposit::where('user_id', $this->user_id)->latest()->paginate(30);
        
        return view('livewire.client.client-deposit', ['deposits' => $deposits]);
    }
}
