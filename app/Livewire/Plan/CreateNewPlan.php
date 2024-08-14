<?php

namespace App\Livewire\Plan;

use App\Models\Plan;
use Livewire\Component;

class CreateNewPlan extends Component
{
    public $title;
    public $sub_title;
    public $min_investment;
    public $max_investment;
    public $rate_type = 'percent';
    public $rate_number;
    public $interest_period;
    public $maturity;
    public $return_capital_amount = true;
    public $payout_buiness_days_only = true;
    public $status = true;


    public function CreatePlan()
    {
        $valid = $this->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'min_investment' => 'required|integer',
            'max_investment' => 'required|integer',
            'rate_type' => 'required|string|max:255',
            'rate_number' => 'required|numeric|',
            'interest_period' => 'required|numeric|',
            'maturity' => 'required|string|max:255',
            'return_capital_amount' => 'required|boolean|',
            'payout_buiness_days_only' => 'required|boolean|',
            'status' => 'required|boolean|',
        ]);

        if ($valid) {
            $plan =  Plan::create([
                'title' => $this->title,
                'sub_title' => $this->sub_title,
                'min_investment' => $this->min_investment,
                'max_investment' => $this->max_investment,
                'rate_type' => $this->rate_type,
                'rate_number' => $this->rate_number,
                'interest_period' => $this->interest_period,
                'maturity' => $this->maturity,
                'payout_buiness_days_only' => $this->payout_buiness_days_only,
                'return_capital_amount' => $this->return_capital_amount,
                'status' => $this->status,
            ]);

            if ($plan) {
                // Reset Variables
                $this->reset(['title', 'sub_title', 'min_investment', 'max_investment', 'rate_type', 'rate_number', 'interest_period', 'maturity', 'payout_buiness_days_only', 'return_capital_amount', 'status']);

                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Plan Created Successfully.']);

                // Dispatch created successfully
                $this->dispatch('planCreated');
            } else {
                // Dispatch Error Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'An error occured.']);
            }
        }
    }

    public function render()
    {
        return view('livewire.plan.create-new-plan');
    }
}
