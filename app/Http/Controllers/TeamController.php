<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:adminOnly');
    }

    // Index Team Page
    public function index()
    {
        return view('team');
    }

    // Edit Team Page
    public function edit($team)
    {
        return view('edit_team', compact('team'));
    }
}
