<?php

namespace App\Livewire\Investment;


use App\Enums\InterestPeriod;
use App\Enums\RoleTitle;
use App\Models\Investment;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\NewInvestment as NotificationsNewInvestment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TopupInvestment extends Component
{

    public $investments;
    public $users = [];

    public $search;
    public $client;
    public $investment_plan;
    public $amount;


    #[Computed]
    public function availableBalance()
    {
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
    }

    // Reload investments when client changes
    public function updatedClient()
    {
        $this->GetInvestmentPlans();
    }

    // Search for Users
    public function SearchUsers()
    {
        $this->users = User::Search($this->search)->withWhereHas('role', function ($query) {
            $query->whereNot('title', RoleTitle::ADMIN)->whereNot('title', RoleTitle::TEAM);
        })->where('status', true)->get();
    }

    // Get all Investment Plans
    public function GetInvestmentPlans()
    {
        $this->investments = Investment::with('plan')->where('user_id', Gate::allows('userOnly') ? auth()->id() : $this->client)->where('status', false)->get();
    }


    // Make Investment
    public function TopUpYourInvestment()
    {
        $valid = $this->validate([
            'client' => [Gate::allows('adminOnly') ? 'required' : 'nullable', 'numeric', 'max:255',],
            'investment_plan' => 'required|string|max:255',
            'amount' => ['required', 'numeric', 'min:' . 10],
        ]);

        if ($valid) {
            $this->client = Gate::allows('adminOnly') ? $this->client : auth()->id();
            $current_investment = $this->investments->firstWhere('id', $this->investment_plan);
            $current_plan = $current_investment->plan;
            // dd($current_investment->plan);

            // Get Client Current Balance
            $client_balance = User::select('balance')->findorFail($this->client);


            // Calculate the Run Time
            if (InterestPeriod::HOURLY->value == $current_investment->interest_period) {
                $duration = 24 * $current_investment->maturity;
            } else {
                $duration = $current_investment->maturity / $current_investment->interest_period;
            }


            // Calculate the Investment Profit
            if ($current_investment->rate_type == 'percent') {
                $profit = (($current_investment->rate_number / 100) * $this->amount) * $duration;
            } else {
                $profit = $current_investment->rate_number * $duration;
            }
        }

        if ($this->amount <= $current_plan->max_investment) {

            if ($client_balance->balance < $this->amount) {
                // Dispatch Error Message
                $this->dispatch('showToast', ['status' => false, 'message' => 'Insufficent Fund, Deposit and try again']);
                return;
            }

            // Create the Investment Record
            $invested = Investment::where('id', $this->investment_plan)->where('user_id', $this->client)->first();
            $invested->increment('amount', $this->amount);
            $invested->increment('profit', $profit);

            if ($invested) {
                // Create The Transaction Record
                $transaction = $invested->transaction()->create([
                    'user_id' => $this->client,
                    'trx_num' => strval(bin2hex(random_bytes(10))),
                    'amount' => -$this->amount,
                    'post_amount' => $client_balance->balance - $this->amount,
                    'status' => true,
                ]);
            }

            if ($transaction) {
                // Decreament User Balance
                User::findorFail($this->client)->decrement('balance', $this->amount);
            }

            // Reset Variables
            $this->reset(['search', 'users', 'client', 'amount', 'investment_plan']);

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Investment Top Up Successful']);

            // Emit To Sibling Components
            $this->dispatch('NewInvestmentCreated');
        } else {
            // Dispatch Error Message
            $this->dispatch('showToast', ['status' => false, 'message' => 'Amount does not match Investment Pricing']);
        }
    }

    public function mount()
    {
        $this->GetInvestmentPlans();
    }

    public function render()
    {
        return view('livewire.investment.topup-investment');
    }
}
