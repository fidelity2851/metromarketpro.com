<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:adminOnly');
    }
    
    
    public function index() {

        return view('general_setting');
    }
}
