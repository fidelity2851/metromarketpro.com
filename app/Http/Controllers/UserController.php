<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:adminOnly');
    }

    // Index User Page
    public function index()
    {
        return view('client');
    }

    // View User Page
    public function show($user)
    {
        // Authorize whether the Auth User in the Admin or the Manager
        $this->authorize('isManager', $user);

        return view('view_client', compact('user'));
    }

    // Edit User Page
    public function edit($user)
    {
        // Authorize whether the Auth User in the Admin or the Manager
        $this->authorize('isManager', $user);

        return view('edit_client', compact('user'));
    }
}
