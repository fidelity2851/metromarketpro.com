<?php

namespace App\Livewire\Transfer;

use App\Enums\RoleTitle;
use App\Models\Setting;
use App\Models\Transfer;
use App\Models\User;
use App\Notifications\FundsTransfered;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;

class NewTransfer extends Component
{

    public $senders = [];
    public $receivers = [];

    public $search_sender;
    public $search_receiver;
    public $sender;
    public $receiver;
    public $amount;
    public $fee = 0;
    public $settings;



    #[Computed]
    public function availableBalance()
    {
        if ($this->settings->allow_withdraw_deposit) {
            if (Gate::allows('adminOnly')) {
                if (empty($this->sender)) {
                    return 0;
                } else {
                    $user = User::select('balance')->firstWhere('id', $this->sender);
                    return $user->balance;
                }
            } else {
                $user = User::select('balance')->firstWhere('id', auth()->id());
                return $user->balance;
            }
        } else {
            if (Gate::allows('adminOnly')) {
                if (empty($this->sender)) {
                    return 0;
                } else {
                    $user = User::select('available_balance')->firstWhere('id', $this->sender);
                    return $user->available_balance;
                }
            } else {
                $user = User::select('available_balance')->firstWhere('id', auth()->id());
                return $user->available_balance;
            }
        }
    }


    // Search for Users
    public function SearchSenders()
    {
        $this->senders = User::Search($this->search_sender)->withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::USER);
        })->where('status', true)->get();
    }
    public function SearchReceivers()
    {
        $this->receivers = User::where('email', $this->search_receiver)->withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::USER);
        })->whereNot('id', auth()->id())->whereNot('id', $this->sender)->where('status', true)->get();
    }


    public function TransferFund()
    {
        $valid = $this->validate([
            'sender' => [Gate::allows('adminOnly') ? 'required' : 'nullable', 'string', 'max:255',],
            'receiver' => ['required', 'string', 'max:255',],
            'amount' => ['required', 'numeric', 'min:' . 100,],
        ]);

        if ($valid) {
            // Get Client Current Balance
            if ($this->settings->allow_withdraw_deposit) {
                $client_balance = User::select('balance')->findorFail(Gate::allows('adminOnly') ? $this->sender : auth()->id())->balance;
            } else {
                $client_balance = User::select('available_balance')->findorFail(Gate::allows('adminOnly') ? $this->sender : auth()->id())->available_balance;
            }

            // Check If User has Insufficent Funds
            if ($client_balance < $this->amount) {
                // Dispatch Error Message
                $this->dispatch('showToast', ['status' => false, 'message' => 'Insufficent Funds, Pls deposit and try again']);
                return;
            }

            // Create transfer Record
            $transfer = Transfer::create([
                'sender_id' => Gate::allows('adminOnly') ? $this->sender : auth()->id(),
                'receiver_id' => $this->receiver,
                'trx_num' => strval(bin2hex(random_bytes(10))),
                'amount' => $this->amount,
                'fee' => $this->fee,
                'status' => true,
            ]);

            if ($transfer) {
                // Create The Transaction Record
                $transaction = $transfer->transaction()->create([
                    'user_id' => Gate::allows('adminOnly') ? $this->sender : auth()->id(),
                    'trx_num' => strval(bin2hex(random_bytes(10))),
                    'amount' => $this->amount,
                    'post_amount' => $client_balance - $this->amount,
                    'status' => $transfer->status == true ? true : false,
                ]);

                // Decreament Sender Balance
                if ($this->settings->allow_withdraw_deposit) {

                    if (Gate::allows('adminOnly')) {
                        User::where('id', $this->sender)->decrement('balance', $this->amount);
                    } else {
                        User::where('id', auth()->id())->decrement('balance', $this->amount);
                    }
                } else {

                    if (Gate::allows('adminOnly')) {
                        User::where('id', $this->sender)->decrement('balance', $this->amount);
                        User::where('id', $this->sender)->decrement('available_balance', $this->amount);
                    } else {
                        User::where('id', auth()->id())->decrement('balance', $this->amount);
                        User::where('id', auth()->id())->decrement('available_balance', $this->amount);
                    }
                }

                // Increament Reveiver Balance
                if ($this->settings->allow_withdraw_deposit) {
                    User::where('id', $this->receiver)->increment('balance', $this->amount);
                } else {
                    User::where('id', $this->receiver)->increment('balance', $this->amount);
                    User::where('id', $this->receiver)->increment('available_balance', $this->amount);
                }

            }


            // Notify the Receiver
            Notification::send($transfer->receiver, new FundsTransfered($transfer));

            // Reset Variables
            $this->reset(['search_sender', 'search_receiver', 'sender', 'receiver', 'senders', 'receivers', 'amount',]);

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Funds Transfered Successfully']);

            // Emit To Current Components
            $this->dispatch('NewTransferCreated');
        }
    }

    public function mount()
    {
        $this->settings = Setting::firstWhere('status', true);
    }

    public function render()
    {
        return view('livewire.transfer.new-transfer');
    }
}
