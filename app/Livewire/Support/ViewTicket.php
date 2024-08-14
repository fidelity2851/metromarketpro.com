<?php

namespace App\Livewire\Support;

use App\Models\Message;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ViewTicket extends Component
{
    #[Locked]
    public $id;

    // public $ticket;

    public $message;

    public function MarkResolved($id)
    {
        SupportTicket::findorFail($id)->update([
            'status' => true,
        ]);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Ticket Resolved Successfully']);
    }

    public function MarkPending($id)
    {
        SupportTicket::findorFail($id)->update([
            'status' => false,
        ]);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Ticket Pending Successfully']);
    }

    public function DeleteMessage($id)
    {
        Message::findorFail($id)->delete();

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully']);
    }

    public function SendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:255',
        ]);

        $ticket = SupportTicket::findorFail($this->id);

        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);


        // Reset Message Field
        $this->reset('message');

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Message Sent Successfully']);
    }

    public function mount($ticket_id)
    {
        $this->id = $ticket_id;
    }

    public function render()
    {
        $ticket = SupportTicket::with(['messages' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'user', 'manager'])->firstWhere('id', $this->id);

        return view('livewire.support.view-ticket', ['ticket' => $ticket]);
    }
}
