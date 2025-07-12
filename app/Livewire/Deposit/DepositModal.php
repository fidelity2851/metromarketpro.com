<?php

namespace App\Livewire\Deposit;

use App\Enums\RoleTitle;
use App\Events\RewardReferral;
use App\Mail\DepositRequest;
use App\Models\Deposit;
use App\Models\DepositMethod;
use App\Models\User;
use App\Notifications\ApprovedDeposit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class DepositModal extends Component
{

    use WithFileUploads;

    public $deposit_methods;


    public $users = [];

    public $search;
    public $client;
    public $ammount;
    public $deposit_method;
    public $min_deposit;
    public $deposit_fee;
    public $proof;


    // Set Deposit Fee While Updating deposit_method properties
    public function updatedDepositMethod()
    {
        foreach ($this->deposit_methods as $value) {
            if ($value->id == $this->deposit_method) {
                $this->min_deposit = $value->min_deposit;
                $this->deposit_fee = $value->fee;
            }
        }
    }

    // Get all deposit methods
    public function GetDepositMethods()
    {
        $this->deposit_methods = DepositMethod::where('status', true)->get();
    }

    // Search for Users
    public function SearchUsers()
    {
        $this->users = User::Search($this->search)->withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::USER);
        })->where('status', true)->get();
    }


    // Make a deposit
    public function MakeDeposit()
    {

        $valid = $this->validate([
            'client' => [Gate::allows('adminOnly') ? 'required' : 'nullable', 'string', 'max:255',],
            'ammount' => ['required', 'numeric', 'min:' . ($this->min_deposit ? $this->min_deposit : 10),],
            'deposit_method' => 'required|string|max:255',
            'proof' => [Gate::allows('userOnly') ? 'required' : 'nullable', 'image:png, image:jpg, image:jpeg', 'max:3000'],
        ]);

        if ($valid) {
            if (Gate::allows('userOnly')) {
                // Generate New Image Path
                $proof_name = strval(bin2hex(random_bytes(5))) . $this->proof->getClientOriginalName();
            }

            // Create The Deposit Record
            $deposit = Deposit::create([
                'user_id' => Gate::allows('adminOnly') ? $this->client : auth()->id(),
                'method_id' => $this->deposit_method,
                'trx_num' => strval(bin2hex(random_bytes(10))),
                'amount' => $this->ammount,
                'fee' => $this->deposit_fee,
                'proof' => Gate::allows('userOnly') ? $proof_name : null,
                'status' => Gate::allows('adminOnly') ? true : false,
            ]);

            if ($deposit) {
                if (Gate::allows('userOnly')) {
                    // Upload Images to Local Disk
                    $this->proof->storeAs('public/deposit/', $proof_name);
                }

                if ($deposit->status == true) {

                    // Get Client Current Balance
                    $client_balance = User::select('balance')->findorFail(Gate::allows('adminOnly') ? $this->client : auth()->id());

                    // Create The Transaction Record
                    $transaction = $deposit->transaction()->create([
                        'user_id' => Gate::allows('adminOnly') ? $this->client : auth()->id(),
                        'trx_num' => strval(bin2hex(random_bytes(10))),
                        'amount' => $this->ammount,
                        'post_amount' => $this->ammount + $client_balance->balance,
                        'status' => true,
                    ]);

                    if ($transaction && Gate::allows('adminOnly')) {
                        // Increament User Balance
                        User::findorFail($this->client)->increment('balance', $this->ammount);
                    }

                    // Dispatch RewardReferral Event
                    RewardReferral::dispatchIf($deposit->status == true, $deposit);

                    // Send Notification
                    Notification::send($deposit->user, new ApprovedDeposit($deposit));
                } else {
                    // Send Deposit Request Email
                    Mail::to(env('DEFAULT_EMAIL', 'info@metromarketpro.net'))->send(new DepositRequest($deposit));
                }
            }

            // Reset Variables
            $this->reset(['search', 'client', 'users', 'ammount', 'deposit_method', 'deposit_fee', 'proof']);

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Funds Deposited, Waiting approval']);

            // Emit To Current Components
            $this->dispatch('NewDepositCreated');
        }
    }

    public function mount()
    {
        $this->GetDepositMethods();
    }

    public function render()
    {
        return view('livewire.deposit.deposit-modal');
    }
}
