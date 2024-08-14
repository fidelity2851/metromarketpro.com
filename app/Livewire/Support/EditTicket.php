<?php

namespace App\Livewire\Support;

use App\Enums\RoleTitle;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditTicket extends Component
{
    public $users = [];
    public $managers = [];
    public $ticket;

    public $search;

    public $subject;
    public $category;
    public $priority;
    public $manager;
    public $message;


    // Search for Users
    public function SearchUsers()
    {
        $this->users = User::Search($this->search)->withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::USER);
        })->where('status', true)->get();
    }

    // Get All Team Members
    public function GetAllTeamMember()
    {
        $this->managers = User::Search($this->search)->withWhereHas('role', function ($query) {
            $query->whereNot('title', RoleTitle::USER);
        })->where('status', true)->get();
    }

    // Create New Support Ticket
    public function UpdateTicket()
    {
        $valid = $this->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'manager' => ['nullable', 'numeric', 'max:255',],
            'message' => 'required|string|max:255',
        ]);

        if ($valid) {
            SupportTicket::firstWhere('id', $this->ticket->id)->update([
                'manager_id' => $this->manager,
                'subject' => $this->subject,
                'category' => $this->category,
                'priority' => $this->priority,
                'message' => $this->message,
            ]);
        }

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Ticket Updated Successfully']);

        // Reload current Ticket
        $this->FillTicketValues($this->ticket->id);
    }

    public function FillTicketValues($ticket_id)
    {
        $this->ticket = SupportTicket::findorFail($ticket_id);

        $this->subject = $this->ticket->subject;
        $this->category = $this->ticket->category;
        $this->priority = $this->ticket->priority;
        $this->manager = $this->ticket->manager_id;
        $this->message = $this->ticket->message;
    }

    public function mount($ticket_id)
    {
        $this->GetAllTeamMember();
        $this->FillTicketValues($ticket_id);
    }

    public function render()
    {
        return view('livewire.support.edit-ticket');
    }
}
