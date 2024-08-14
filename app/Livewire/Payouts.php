<?php

namespace App\Livewire;

use App\Models\Management;
use App\Models\Transaction;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Payouts extends Component
{
    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;



    public function render()
    {
        if (Gate::allows('adminOnly')) {
            $payouts = Transaction::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        } elseif (Gate::allows('teamOnly')) {
            $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function ($value) {
                return $value->client_id;
            });

            $payouts = Transaction::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->whereIn('user_id', $client_ids)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        } elseif (Gate::allows('userOnly')) {
            $payouts = Transaction::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->where('user_id', auth()->id())->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        }

        return view('livewire.payouts', ['payouts' => $payouts]);
    }
}
