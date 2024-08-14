<?php

namespace App\Livewire\Withdraw;

use App\Models\Management;
use App\Models\Setting;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\ApprovedWithdrawal;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AllWithdrawal extends Component
{
    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;

    public $settings;


    #[Computed]
    public function totalWithdrawal()
    {
        if (Gate::allows('adminOnly')) {
            return Withdrawal::where('status', true)->sum('amount');
        } elseif (Gate::allows('teamOnly')) {
            $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function ($value) {
                return $value->client_id;
            });
            return Withdrawal::where('status', true)->whereIn('user_id', $client_ids)->sum('amount');
        } else {
            return Withdrawal::where([['user_id', auth()->id()], ['status', true]])->sum('amount');
        }
    }

    #[Computed]
    public function pendingWithdrawal()
    {
        if (Gate::allows('adminOnly')) {
            return Withdrawal::where('status', false)->sum('amount');
        } elseif (Gate::allows('teamOnly')) {
            $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function ($value) {
                return $value->client_id;
            });
            return Withdrawal::where('status', false)->whereIn('user_id', $client_ids)->sum('amount');
        } else {
            return Withdrawal::where([['user_id', auth()->id()], ['status', false]])->sum('amount');
        }
    }

    // Get Withdrawal Invoice Details
    public function WithdrawalInvoiceEvent($id)
    {
        $this->dispatch('GetWithdrawalInvoice', withdrawal_id: $id)->to(WithdrawalInvoice::class);
    }

    // Approve a Withdrawal and it's Relations
    public function ApproveWithdrawal($id)
    {
        $withdrawal = Withdrawal::findorFail($id);
        $withdrawal->update(['status' => true,]);

        if ($withdrawal->status == true) {

            // Get Client Current Balance
            $client_balance = User::select('balance')->findorFail($withdrawal->user_id);

            // Update The Transaction Record
            $transaction = $withdrawal->transaction()->update(['status' => true,]);

            // Send Notification
            Notification::send($withdrawal->user, new ApprovedWithdrawal($withdrawal));

            if ($transaction) {
                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Approved Successfully.']);
            }
        }
    }

    // Disapprove a Withdrawal and it's Relations
    public function DisapproveWithdrawal($id)
    {
        $withdrawal = Withdrawal::findorFail($id);
        $withdrawal->update(['status' => false,]);
        $disapproved = $withdrawal->transaction()->update(['status' => false]);

        if ($disapproved) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Disapproved Successfully.']);
        }
    }

    // Delete a Withdrawal and it's Relations
    public function DeleteWithdrawal($id)
    {
        $withdrawal = Withdrawal::findorFail($id);

        if ($withdrawal) {
            // Delete the Withdrawal Record
            $withdrawal->delete();

            // Update User Balance
            if ($this->settings->allow_withdraw_deposit) {
                User::findorFail($withdrawal->user_id)->increment('balance', $withdrawal->amount);
            } else {
                User::findorFail($withdrawal->user_id)->increment('balance', $withdrawal->amount);
                User::findorFail($withdrawal->user_id)->increment('available_balance', $withdrawal->amount);
            }

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
        }
    }

    public function mount()
    {
        $this->settings = Setting::firstWhere('status', true);
    }

    #[On('NewWithdrawalCreated')]
    public function render()
    {
        $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function ($value) {
            return $value->client_id;
        });

        $withdrawals = Withdrawal::withWhereHas('user', function ($query) use ($client_ids) {
            Gate::allows('userOnly') ? $query->where('id', auth()->id()) : $query;
            Gate::allows('teamOnly') ? $query->whereIn('id', $client_ids) : $query;
        })->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);


        return view('livewire.withdraw.all-withdrawal', ['withdrawals' => $withdrawals]);
    }
}
