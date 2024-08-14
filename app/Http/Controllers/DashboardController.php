<?php

namespace App\Http\Controllers;

use App\Enums\RoleTitle;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Management;
use App\Models\Plan;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        if (Gate::allows('adminOnly')) {
            $total_deposit = Deposit::where('status', true)->sum('amount');
            $total_withdrawal = Withdrawal::where('status', true)->sum('amount');
            $total_package = Plan::where('status', true)->count();
            $total_users = User::withWhereHas('role', function ($query) {
                $query->whereNot('title', RoleTitle::ADMIN->value);
            })->count();
            $recent_transactions = Transaction::select('trx_num', 'transactionable_type', 'amount')->where('status', true)->latest()->paginate(8);

            return view('dashboard', compact('total_deposit', 'total_withdrawal', 'total_package', 'total_users', 'recent_transactions'));
        }
        if (Gate::allows('userOnly')) {
            $total_deposit = Deposit::where([['user_id', auth()->id()], ['status', true]])->sum('amount');
            $total_profit = Investment::where([['user_id', auth()->id()],])->sum('acc_profit');
            $referral_bonus = Referral::where([['referral_id', auth()->id()], ['status', true]])->sum('amount');
            $total_withdrawal = Withdrawal::where([['user_id', auth()->id()], ['status', true]])->sum('amount');
            $total_balance = Auth::user()->balance;
            $active_package = Investment::where([['user_id', auth()->id()], ['status', false]])->count();
            $recent_transactions = Transaction::select('trx_num', 'transactionable_type', 'amount')->where([['user_id', auth()->id()], ['status', true]])->latest()->paginate(8);

            return view('dashboard', compact('total_deposit', 'total_profit', 'referral_bonus', 'total_withdrawal', 'total_balance', 'active_package', 'recent_transactions'));
        }
        if (Gate::allows('teamOnly')) {
            $total_deposit = Deposit::where('status', true)->sum('amount');
            $total_profit = Transaction::where([['user_id', auth()->id()], ['amount', '>', 0], ['transactionable_type', 'App\Models\Investment'], ['status', true]])->sum('amount');
            $referral_bonus = Referral::where([['referral_id', auth()->id()], ['status', true]])->sum('amount');
            $total_withdrawal = Withdrawal::where([['user_id', auth()->id()], ['status', true]])->sum('amount');
            $total_balance = Auth::user()->balance;
            $total_users = Management::where('manager_id', auth()->id())->count();
            $clients = Management::where('manager_id', auth()->id())->get()->map(function (Management $management) {
                return $management->client_id;
            });
            $recent_transactions = Transaction::select('trx_num', 'transactionable_type', 'amount')->whereIn('user_id', $clients)->where('status', true)->latest()->paginate(8);

            return view('dashboard', compact('total_deposit', 'total_profit', 'referral_bonus', 'total_withdrawal', 'total_balance', 'total_users', 'recent_transactions'));
        }

        return abort(403);
    }
}
