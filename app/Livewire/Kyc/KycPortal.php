<?php

namespace App\Livewire\Kyc;

use App\Enums\KycStatus;
use App\Models\KYC;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class KycPortal extends Component
{
    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;

    public $select_all_checkbox = false;
    public $kyc_ids = [];


    public function DeleteKyc()
    {
        $kycs = KYC::select('id', 'user_id', 'verify_proof', 'address_proof', 'passport')->whereIn('id', $this->kyc_ids)->get();

        foreach ($kycs as $kyc) {
            // Delete Old Images if Exist
            Storage::delete('public/kyc/' . $kyc->verify_proof);
            Storage::delete('public/kyc/' . $kyc->address_proof);
            Storage::delete('public/kyc/' . $kyc->passport);

            // Mark Users As Not Verified On User Table
            User::find($kyc->user_id)->update(['isVerified' => false]);
        }

        // Delete Does Records
        $deleted = KYC::destroy($this->kyc_ids);


        if ($deleted) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
        }
    }
    public function ApproveKyc()
    {
        $kycs = KYC::select('id', 'user_id',)->whereIn('id', $this->kyc_ids)->get();

        foreach ($kycs as $kyc) {
            // Mark Users As Verified On User Table
            User::find($kyc->user_id)->update(['isVerified' => true]);

            // Update Kyc Table
            $kyc->update(['status' => KycStatus::APPROVED]);
        }

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Approved Successfully.']);
    }
    public function RejectKyc()
    {
        $kycs = KYC::select('id', 'user_id',)->whereIn('id', $this->kyc_ids)->get();

        foreach ($kycs as $kyc) {
            // Mark Users As Not Verified On User Table
            User::find($kyc->user_id)->update(['isVerified' => false]);

            // Update Kyc Table
            $kyc->update(['status' => KycStatus::REJECTED]);
        }

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Rejected Successfully.']);
    }

    public function render()
    {
        $all_kyc = KYC::withWhereHas('user', function ($query) {
            $query->where('fullname', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })->SortBY($this->sort_by)->orderBy('updated_at', $this->order_by)->paginate($this->per_page);

        return view('livewire.kyc.kyc-portal', ['kycs' => $all_kyc]);
    }
}
