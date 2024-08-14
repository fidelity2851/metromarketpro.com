<?php

namespace App\Livewire\Deposit;

use App\Events\RewardReferral;
use App\Models\Deposit;
use App\Models\Management;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\ApprovedDeposit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AllDeposit extends Component
{
    use WithPagination;

    public $total_deposit;
    public $pending_deposit;

    public $deposit_ids = [];


    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;



    // Get Total and Pending Deposit
    public function GetSumDeposit($client_ids)
    {
        $this->total_deposit = Deposit::withWhereHas('user', function ($query) use ($client_ids) {
            Gate::allows('userOnly') ? $query->where('id', auth()->id()) : $query;
            Gate::allows('teamOnly') ? $query->whereIn('id', $client_ids) : $query;
        })->where('status', true)->sum('amount');

        $this->pending_deposit = Deposit::withWhereHas('user', function ($query) use ($client_ids) {
            Gate::allows('userOnly') ? $query->where('id', auth()->id()) : $query;
            Gate::allows('teamOnly') ? $query->whereIn('id', $client_ids) : $query;
        })->where('status', false)->sum('amount');
    }

    // Get Deposit Invoice Details
    public function DepositInvoiceEvent($id)
    {
        $this->dispatch('GetDepositInvoice', deposit_id: $id)->to(DepositInvoice::class);
    }

    // Approve a Deposit and it's Relations
    public function ApproveDeposit($id)
    {
        $deposit = Deposit::findorFail($id);
        $deposit->update(['status' => true,]);

        if ($deposit->status == true) {

            // Get Client Current Balance
            $client_balance = User::select('balance')->findorFail($deposit->user_id);

            // Create The Transaction Record
            $tran_details = $deposit->transaction;

            if ($tran_details) {
                $transaction = $deposit->transaction()->update(['status' => true,]);
            } else {
                $transaction = $deposit->transaction()->create([
                    'user_id' => $deposit->user_id,
                    'trx_num' => strval(bin2hex(random_bytes(10))),
                    'amount' => $deposit->amount,
                    'post_amount' => $deposit->amount + $client_balance->balance,
                    'status' => true,
                ]);
            }

            if ($transaction) {
                // Update User Balance
                User::findorFail($deposit->user_id)->increment('balance', $deposit->amount);

                // Send Notification
                Notification::send($deposit->user, new ApprovedDeposit($deposit));

                // Dispatch RewardReferral Event
                RewardReferral::dispatch($deposit);

                // Dispatch Success Message
                $this->dispatch('showToast', ['status' => true, 'message' => 'Approved Successfully.']);
            }
        }
    }

    // Disapprove a Deposit and it's Relations
    public function DisapproveDeposit($id)
    {
        $deposit = Deposit::findorFail($id);
        $deposit->update(['status' => false,]);
        $disapproved = $deposit->transaction()->update(['status' => false]);

        if ($disapproved) {
            User::findorFail($deposit->user_id)->decrement('balance', $deposit->amount);
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Disapproved Successfully.']);
        }
    }

    // Delete a Deposit and it's Relations
    public function DeleteDeposit($id)
    {
        $deposit = Deposit::findorFail($id);

        if ($deposit) {

            // Delete Image Proof if Exist
            Storage::delete('public/deposit/' . $deposit->proof);

            // Delete the Deposit Record
            $deposit->delete();

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
        }
    }


    #[On('NewDepositCreated')]
    public function render()
    {
        $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function($value) {
            return $value->client_id;
        });

        $this->GetSumDeposit($client_ids);
       
        $deposits = Deposit::withWhereHas('user', function ($query) use ($client_ids) {
            Gate::allows('userOnly') ? $query->where('id', auth()->id()) : $query;
            Gate::allows('teamOnly') ? $query->whereIn('id', $client_ids) : $query;
        })->with('deposit_method')->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);

        return view('livewire.deposit.all-deposit', ['deposits' => $deposits]);
    }
}
