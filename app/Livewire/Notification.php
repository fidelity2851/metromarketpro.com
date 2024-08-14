<?php

namespace App\Livewire;

use App\Models\Notification as ModelsNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Notification extends Component
{
    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;

    public function DeleteNotification($id)
    {
        ModelsNotification::findorFail($id)->delete();

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
    }

    public function render()
    {
        $notification = ModelsNotification::Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);

        return view('livewire.notification', ['notifications' => $notification]);
    }
}
