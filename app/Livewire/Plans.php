<?php

namespace App\Livewire;

use App\Models\Plan;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Plans extends Component
{    
    use WithPagination;
    
    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;


    
    public function BlockPlan($id)
    {
        $plan = Plan::where('id', $id)->update([
            'status' => false,
        ]);

        if ($plan) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Plan Blocked Successfully.']);
        }
    }

    public function ActivatePlan($id)
    {
        $plan = Plan::where('id', $id)->update([
            'status' => true,
        ]);

        if ($plan) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Plan Activated Successfully.']);
        }
    }

    #[On('planCreated')]
    public function render()
    {
        $all_plans = Plan::Search($this->search)->SortBy($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        
        return view('livewire.plans', ['plans' => $all_plans]);
    }
}
