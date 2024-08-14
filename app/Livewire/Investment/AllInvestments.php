<?php

namespace App\Livewire\Investment;

use App\Models\Investment;
use App\Models\Management;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AllInvestments extends Component
{
    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;


    #[Computed]
    public function investedAmount()
    {
        if (Gate::allows('adminOnly')) {
            return Investment::sum('amount');
        } else {
            return Investment::where('user_id', auth()->id())->sum('amount');
        }
    }

    #[Computed]
    public function totalProfit()
    {
        if (Gate::allows('adminOnly')) {
            return Investment::sum('acc_profit');
        } else {
            return Investment::where('user_id', auth()->id())->sum('acc_profit');
        }
    }

    // Get Deposit Invoice Details
    public function InvestmentInvoiceEvent($id)
    {
        $this->dispatch('GetInvestmentInvoice', invest_id: $id)->to(InvestmentInvoice::class);
    }

    // Pause Investment
    public function PauseInvestment($id)
    {
        // Get Investment Record
        $invest = Investment::findorFail($id);
        $invest->update([
            'isActive' => false,
        ]);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Paused Successfully.']);
    }

    // Pause Investment
    public function ResumeInvestment($id)
    {
        // Get Investment Record
        $invest = Investment::findorFail($id);
        $invest->update([
            'isActive' => true,
        ]);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Resumed Successfully.']);
    }

    // Delete an Investment
    public function DeleteInvestment($id)
    {
        // Get Investment Record
        $invest = Investment::findorFail($id);

        // Refund the User
        if ($invest->status == false) {
            // Get the Investment Owner
            $user = User::findorFail($invest->user_id);

            // Create The Transaction Record
            $transaction = $invest->transaction()->create([
                'user_id' => $invest->user_id,
                'trx_num' => strval(bin2hex(random_bytes(10))),
                'amount' => $invest->amount,
                'post_amount' => $user->balance + $invest->amount,
                'status' => true,
            ]);

            // Increament User Balance
            $user->increment('balance', $invest->amount);
        }

        if ($transaction) {
            // Delete Investment Record
            $invest->delete();

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
        }
    }


    #[On('NewInvestmentCreated')]
    public function render()
    {
        if (Gate::allows('adminOnly')) {
            $investments = Investment::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('plan')->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);;
        } elseif (Gate::allows('teamOnly')) {
            $client_ids = Management::where('manager_id', auth()->id())->get()->map(function ($value) {
                return $value->client_id;
            });
            $investments = Investment::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('plan')->whereIn('user_id', $client_ids)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);;
        } else {
            $investments = Investment::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('plan')->where('user_id', auth()->id())->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        }

        return view('livewire.investment.all-investments', ['investments' => $investments]);
    }
}
