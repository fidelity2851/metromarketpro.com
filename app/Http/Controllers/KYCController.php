<?php

namespace App\Http\Controllers;

use App\Models\KYC;

class KYCController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:adminOnly');
    }

    // Index Kyc Page
    public function index()
    {
        return view('kyc_portal');
    }

    // Index Kyc Page
    public function show($kyc)
    {        
        return view('manage_kyc', compact('kyc'));
    }
}
