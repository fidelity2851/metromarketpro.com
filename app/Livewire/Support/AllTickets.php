<?php

namespace App\Livewire\Support;

use App\Models\Investment;
use App\Models\Management;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AllTickets extends Component
{

    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;


    #[On('NewTicketCreated')]
    public function render()
    {
        if (Gate::allows('adminOnly')) {
            $tickets = SupportTicket::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('manager')->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);;
        } elseif (Gate::allows('teamOnly')) {
            $client_ids = Management::where('manager_id', auth()->id())->get()->map(function ($value) {
                return $value->client_id;
            });
            $tickets = SupportTicket::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('manager')->whereIn('user_id', $client_ids)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);;
        } else {
            $tickets = SupportTicket::withWhereHas('user', function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
                $query->orWhere('username', 'like', '%' . $this->search . '%');
                $query->orWhere('email', 'like', '%' . $this->search . '%');
            })->with('manager')->where('user_id', auth()->id())->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        }

        return view('livewire.support.all-tickets', ['tickets' => $tickets]);
    }
}
