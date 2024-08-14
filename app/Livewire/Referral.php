<?php

namespace App\Livewire;

use App\Enums\RoleTitle;
use App\Models\Management;
use App\Models\Referral as ModelsReferral;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Referral extends Component
{
    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;

    public $referral_ids = [];

    #[Computed]
    public function referralCount()
    {
        // Check if is Admin
        if (Gate::allows('adminOnly')) {
            return ModelsReferral::count();
        }

        return ModelsReferral::where('referral_id', auth()->id())->where('status', true)->count();
    }

    #[Computed]
    public function referralBonus()
    {
        // Check if is Admin
        if (Gate::allows('adminOnly')) {
            return ModelsReferral::sum('amount');
        }

        return ModelsReferral::where('referral_id', auth()->id())->where('status', true)->sum('amount');
    }

    public function DeleteReferral($id)
    {
        // Get Referral Record
        $referral = ModelsReferral::findorFail($id);

        // Delete Related Transaction Record
        $deleted = Transaction::where([['transactionable_id', $referral->id], ['transactionable_type', get_class(new ModelsReferral())]])->delete();

        if ($deleted) {
            // Delete Referral Record
            $referral->delete();

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
        }
    }

    public function render()
    {

        // Check if is Admin
        if (Gate::allows('adminOnly')) {
            $all_referral = ModelsReferral::withWhereHas('referral', function ($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                    ->orWhere('fullname', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('referee')->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        } else {
            $all_referral = ModelsReferral::withWhereHas('referral', function ($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                    ->orWhere('fullname', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('referee')->where('referral_id', auth()->id())->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        }

        return view('livewire.referral', ['referrals' => $all_referral]);
    }
}
