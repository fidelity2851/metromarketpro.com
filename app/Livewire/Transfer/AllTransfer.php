<?php

namespace App\Livewire\Transfer;

use App\Models\Management;
use App\Models\Transfer;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AllTransfer extends Component
{
    use WithPagination;
    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;

    #[Computed]
    public function totalTransferOut()
    {
        if (Gate::allows('adminOnly')) {
            return Transfer::where('status', true)->sum('amount');
        } elseif (Gate::allows('teamOnly')) {
            $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function ($value) {
                return $value->client_id;
            });
            return Transfer::where('status', true)->whereIn('sender_id', $client_ids)->sum('amount');
        } else {
            return Transfer::where([['sender_id', auth()->id()], ['status', true]])->sum('amount');
        }
    }

    #[Computed]
    public function totalTransferIn()
    {
        if (Gate::allows('adminOnly')) {
            return Transfer::where('status', true)->sum('amount');
        } elseif (Gate::allows('teamOnly')) {
            $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function ($value) {
                return $value->client_id;
            });
            return Transfer::where('status', true)->whereIn('receiver_id', $client_ids)->sum('amount');
        } else {
            return Transfer::where([['receiver_id', auth()->id()], ['status', true]])->sum('amount');
        }
    }

    // Get Transfer Invoice Details
    public function TransferInvoiceEvent($id)
    {
        $this->dispatch('GetTransferInvoice', transfer_id: $id)->to(TransferInvoice::class);
    }


    #[On('NewTransferCreated')]
    public function render()
    {
        $client_ids = Management::select('client_id')->where('manager_id', auth()->id())->get()->map(function ($value) {
            return $value->client_id;
        });

        // $transfers = Transfer::withWhereHas('sender', function ($query) use ($client_ids) {
        //     Gate::allows('userOnly') ? $query->where('id', auth()->id()) : $query;
        //     Gate::allows('teamOnly') ? $query->whereIn('id', $client_ids) : $query;
        // })->withWhereHas('receiver', function ($query) use ($client_ids) {
        //     Gate::allows('userOnly') ? $query->where('id', auth()->id()) : $query;
        //     Gate::allows('teamOnly') ? $query->whereIn('id', $client_ids) : $query;
        // })->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);


        if (Gate::allows('userOnly')) {
            $transfers = Transfer::with(['sender', 'receiver'])
                ->where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())
                ->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        } else {
            $transfers = Transfer::with(['sender', 'receiver'])->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        }

        return view('livewire.transfer.all-transfer', ['transfers' => $transfers]);
    }
}
