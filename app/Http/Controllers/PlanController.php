<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:adminOnly');
    }

    // Index Plan Page
    public function index()
    {
        return view('plans');
    }

    // Edit Plan Page
    public function edit($plan)
    {
        return view('edit_plan', compact('plan'));
    }
}
