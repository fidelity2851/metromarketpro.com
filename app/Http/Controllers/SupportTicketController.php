<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        return view('support');
    }

    public function view($ticket)
    {
        // Authorize whether the Auth User in the Owner or the Manager or Admin
        $this->authorize('isTicketOwner', $ticket);

        return view('manage_ticket', compact('ticket'));
    }

    public function edit($ticket)
    {
        return view('edit_ticket', compact('ticket'));
    }
}
