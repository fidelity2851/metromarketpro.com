<?php

namespace App\Livewire\Withdraw;

use App\Enums\RoleTitle;
use App\Enums\WithdrawalMethod as EnumsWithdrawalMethod;
use App\Events\RewardReferral;
use App\Mail\WithdrawalRequest;
use App\Models\Deposit;
use App\Models\DepositMethod;
use App\Models\Setting;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\WithdrawalMethod;
use App\Notifications\ApprovedWithdrawal;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewWithdrawal extends Component
{

    use WithFileUploads;

    public $withdrawal_methods;


    public $users = [];

    public $search;
    public $client;
    public $ammount;
    public $withdrawal_method;
    public $fee;

    public $settings;
    public $withdrawal_details;


    #[Computed]
    public function availableBalance()
    {
        if ($this->settings->allow_withdraw_deposit) {
            if (Gate::allows('adminOnly')) {
                if (empty($this->client)) {
                    return 0;
                } else {
                    $user = User::select('balance')->firstWhere('id', $this->client);
                    return $user->balance;
                }
            } else {
                $user = User::select('balance')->firstWhere('id', auth()->id());
                return $user->balance;
            }
        } else {
            if (Gate::allows('adminOnly')) {
                if (empty($this->client)) {
                    return 0;
                } else {
                    $user = User::select('available_balance')->firstWhere('id', $this->client);
                    return $user->available_balance;
                }
            } else {
                $user = User::select('available_balance')->firstWhere('id', auth()->id());
                return $user->available_balance;
            }
        }
    }

    // Updating client properties
    public function updatedClient()
    {
        $this->GetClientWithdrawalDetails();
    }

    // Updating withdrawal_method properties
    public function updatedWithdrawalMethod()
    {
        $this->GetClientWithdrawalDetails();
    }

    // Updating withdrawal_method properties
    public function updatedAmmount()
    {
        $this->CalculateWithdrawalFee();
    }

    // Get all client withdrawal details
    public function GetClientWithdrawalDetails()
    {
        $this->withdrawal_details = WithdrawalMethod::firstWhere('user_id', Gate::allows('adminOnly') ? $this->client : auth()->id());
    }

    // Search for Users
    public function SearchUsers()
    {
        $this->users = User::Search($this->search)->withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::USER);
        })->where('status', true)->get();
    }

    public function CalculateWithdrawalFee()
    {
        // Calculate the Withdrawal Fee
        if ($this->settings->withdrawal_fee_type == 'percentage') {
            $this->fee =  ($this->settings->withdrawal_fee * $this->ammount) / 100;
        }
        if ($this->settings->withdrawal_fee_type == 'fixed') {
            $this->fee =  ($this->settings->withdrawal_fee * $this->ammount) / 100;
        }
    }


    // Make a deposit
    public function MakeWithdrawal()
    {
        $valid = $this->validate([
            'client' => [Gate::allows('adminOnly') ? 'required' : 'nullable', 'string', 'max:255',],
            'ammount' => ['required', 'numeric', 'min:' . ($this->settings ? $this->settings->min_withdrawal : 100),],
            'withdrawal_method' => 'required|string|max:255',
        ]);

        if ($valid) {

            // Get Client Current Balance
            if ($this->settings->allow_withdraw_deposit) {
                $client_balance = User::select('balance')->findorFail(Gate::allows('adminOnly') ? $this->client : auth()->id())->balance;
            } else {
                $client_balance = User::select('available_balance')->findorFail(Gate::allows('adminOnly') ? $this->client : auth()->id())->available_balance;
            }


            // Check If User has Withdrawal Details
            if (!$this->withdrawal_details) {
                // Dispatch Error Message
                $this->dispatch('showToast', ['status' => false, 'message' => 'No Withdrawal Details Found']);
                return;
            }

            // Check If User has Insufficent Funds
            if ($client_balance < $this->ammount) {
                // Dispatch Error Message
                $this->dispatch('showToast', ['status' => false, 'message' => 'Insufficent Funds, Pls deposit and try again']);
                return;
            }

            // Create The Withdrawal Record
            $withdrawal = Withdrawal::create([
                'user_id' => Gate::allows('adminOnly') ? $this->client : auth()->id(),
                'withdrawal_type' => $this->withdrawal_method,
                'trx_num' => strval(bin2hex(random_bytes(10))),
                'amount' => $this->ammount,
                'fee' => $this->fee,
                'status' => Gate::allows('adminOnly') ? true : false,
            ]);

            if ($withdrawal) {
                // Create The Transaction Record
                $transaction = $withdrawal->transaction()->create([
                    'user_id' => Gate::allows('adminOnly') ? $this->client : auth()->id(),
                    'trx_num' => strval(bin2hex(random_bytes(10))),
                    'amount' => $this->ammount,
                    'post_amount' => $client_balance - $this->ammount,
                    'status' => $withdrawal->status == true ? true : false,
                ]);

                if ($withdrawal->status == true) {
                    // Send Notification
                    Notification::send($withdrawal->user, new ApprovedWithdrawal($withdrawal));
                } else {
                    // Send Withdrawal Request Email
                    Mail::to(env('DEFAULT_EMAIL', 'info@quantmarketpro.com'))->send(new WithdrawalRequest($withdrawal));
                }

                if ($transaction) {
                    // Decreament User Balance
                    if ($this->settings->allow_withdraw_deposit) {
                        User::where('id', Gate::allows('adminOnly') ? $this->client : auth()->id())->decrementEach([
                            'balance' => $this->ammount,
                        ]);
                    } else {
                        User::where('id', Gate::allows('adminOnly') ? $this->client : auth()->id())->decrementEach([
                            'balance' => $this->ammount,
                            'available_balance' => $this->ammount,
                        ]);
                    }
                }
            }

            // Reset Variables
            $this->reset(['search', 'client', 'users', 'ammount', 'withdrawal_method',]);

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Funds Withdrawed Successfully']);

            // Emit To Current Components
            $this->dispatch('NewWithdrawalCreated');
        }
    }

    public function mount()
    {
        $this->settings = Setting::firstWhere('status', true);
    }


    public function render()
    {
        return view('livewire.withdraw.new-withdrawal');
    }
}
