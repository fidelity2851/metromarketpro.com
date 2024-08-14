<?php

namespace App\Livewire\Support;

use App\Enums\RoleTitle;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class NewTicket extends Component
{

    public $users = [];
    public $managers = [];

    public $search;

    public $subject;
    public $client;
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
            $query->where('title', RoleTitle::TEAM);
        })->where('status', true)->get();
    }

    // Create New Support Ticket
    public function CreateTicket()
    {
        $valid = $this->validate([
            'client' => [Gate::allows('adminOnly') ? 'required' : 'nullable', 'string', 'max:255',],
            'subject' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'manager' => ['nullable', 'string', 'max:255',],
            'message' => 'required|string|max:255',
        ]);

        if ($valid) {
            SupportTicket::create([
                'user_id' => $this->client,
                'manager_id' => $this->manager,
                'subject' => $this->subject,
                'category' => $this->category,
                'priority' => $this->priority,
                'message' => $this->message,
            ]);
        }

        // Reset Variables
        $this->reset(['search', 'users', 'client', 'manager', 'subject', 'category', 'priority', 'message']);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Ticket Created Successfully']);

        // Emit To Sibling Components
        $this->dispatch('NewTicketCreated');
    }

    public function mount()
    {
        $this->GetAllTeamMember();
    }

    public function render()
    {
        return view('livewire.support.new-ticket');
    }
}
