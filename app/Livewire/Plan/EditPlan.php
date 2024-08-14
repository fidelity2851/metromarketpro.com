<?php

namespace App\Livewire\Plan;

use App\Models\Plan;
use Livewire\Component;

class EditPlan extends Component
{

    public $plan;

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


    public function FillPlanValues($plan_id) {

        $this->plan = Plan::findorFail($plan_id);
        
        $this->title = $this->plan->title;
        $this->sub_title = $this->plan->sub_title;
        $this->min_investment = $this->plan->min_investment;
        $this->max_investment = $this->plan->max_investment;
        $this->rate_type = $this->plan->rate_type;
        $this->rate_number = $this->plan->rate_number;
        $this->interest_period = $this->plan->interest_period;
        $this->maturity = $this->plan->maturity;
        $this->payout_buiness_days_only = $this->plan->payout_buiness_days_only ? true : false;
        $this->return_capital_amount = $this->plan->return_capital_amount ? true : false;
        $this->status = $this->plan->status ? true : false;
    }

    public function UpdatePlan() {
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
            $plan =  Plan::where('id', $this->plan->id)->update([
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
                $this->FillPlanValues($this->plan->id);
                
                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Plan Updated Successfully.']);

            } else {
                // Dispatch Error Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'An error occured.']);
            }
        }
    }

    public function mount($plan) {
        $this->FillPlanValues($plan);
    }
    
    public function render() {
        return view('livewire.plan.edit-plan');
    }
}
