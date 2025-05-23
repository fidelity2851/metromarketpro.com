<?php

namespace App\Http\Controllers;

use App\Enums\InterestPeriod;
use App\Jobs\PayInvestmentInterest;
use App\Models\Investment;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    // Index Investment Page
    public function index()
    {
        return view('invest');
    }

    public function edit($invest_id)
    {
        return view('edit_invest_profit', compact('invest_id'));
    }

    public function PayInvestmentIntrest()
    {

        PayInvestmentInterest::dispatch();

        // return back();
    }
}
