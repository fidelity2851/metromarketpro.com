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

class NewInvestment extends Component
{
    public $plans;
    public $users = [];

    public $search;
    public $client;
    public $investment_plan;
    public $amount;

    public $min_investment;
    public $max_investment;

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


    // Set Deposit Fee While Updating deposit_method properties
    public function updatedInvestmentPlan()
    {
        foreach ($this->plans as $value) {
            if ($value->id == $this->investment_plan) {
                $this->min_investment = $value->min_investment;
                $this->max_investment = $value->max_investment;
            }
        }
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
        $this->plans = Plan::where('status', true)->get();
    }


    // Make Investment
    public function MakeInvestment()
    {
        $valid = $this->validate([
            'client' => [Gate::allows('adminOnly') ? 'required' : 'nullable', 'numeric', 'max:255',],
            'investment_plan' => 'required|string|max:255',
            'amount' => ['required', 'numeric', 'min:' . ($this->min_investment != null ? $this->min_investment : 10), 'max:' . ($this->max_investment != null ? $this->max_investment : 10)],
        ]);

        if ($valid) {
            $this->client = Gate::allows('adminOnly') ? $this->client : auth()->id();
            $current_plan = $this->plans->firstWhere('id', $this->investment_plan);

            // Get Client Current Balance
            $client_balance = User::select('balance')->findorFail($this->client);

            // Calculate the Due date
            $due_date = Carbon::now()->addDays($current_plan->maturity);

            // Calculate the Run Time
            if (InterestPeriod::HOURLY->value == $current_plan->interest_period) {
                $duration = 24 * $current_plan->maturity;
            } else {
                $duration = $current_plan->maturity / $current_plan->interest_period;
            }


            // Calculate the Investment Profit
            if ($current_plan->rate_type == 'percent') {
                $profit = (($current_plan->rate_number / 100) * $this->amount) * $duration;
            } else {
                $profit = $current_plan->rate_number * $duration;
            }
        }

        if ($this->amount >= $current_plan->min_investment && $this->amount <= $current_plan->max_investment) {

            // Check if Client has Sufficient Balance
            if ($this->amount > $client_balance->balance) {
                // Dispatch Error Message
                $this->dispatch('showToast', ['status' => false, 'message' => 'Insufficient Fund, Deposit and try again']);
                return;
            }

            // Create the Investment Record
            $invested = Investment::create([
                'user_id' => $this->client,
                'plan_id' => $this->investment_plan,
                'trx_num' => strval(bin2hex(random_bytes(10))),
                'amount' => $this->amount,
                'profit' => $profit,
                'rate_type' => $current_plan->rate_type,
                'rate_number' => $current_plan->rate_number,
                'interest_period' => $current_plan->interest_period,
                'maturity' => $current_plan->maturity,
                'due_date' => $due_date,
                'status' => false,
            ]);

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

            // Send Notification
            Notification::send($invested->user, new NotificationsNewInvestment($invested));

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Funds Invested Successfully']);

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
        return view('livewire.investment.new-investment');
    }
}
