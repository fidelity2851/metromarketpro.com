<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepositMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:adminOnly');
    }

    // Edit Deposit Method Page
    public function edit($method)
    {
        return view('edit_deposit_method', compact('method'));
    }

    // Index Deposit Method Page
    public function index()
    {
        return view('deposit_methods');
    }
}
