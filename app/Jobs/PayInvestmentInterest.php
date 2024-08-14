<?php

namespace App\Jobs;

use App\Enums\InterestPeriod;
use App\Models\Investment;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PayInvestmentInterest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $settings = Setting::firstWhere('status', true);
        $investments = Investment::where('status', false)->get();

        foreach ($investments as $key => $value) {

            $start_date = Carbon::parse($value->created_at);
            $end_date = Carbon::parse(now());

            // Check Diffrence in hrs, days, weeks, months, years
            if ($value->interest_period == InterestPeriod::HOURLY->value) {
                $due_run_time = $start_date->diffInHours($end_date);
            } elseif ($value->interest_period == InterestPeriod::DAILY->value) {
                $due_run_time = $start_date->diffInDays($end_date);
            } elseif ($value->interest_period == InterestPeriod::WEEKLY->value) {
                $due_run_time = $start_date->diffInWeeks($end_date);
            } elseif ($value->interest_period == InterestPeriod::MONTHLY->value) {
                $due_run_time = $start_date->diffInMonths($end_date);
            } elseif ($value->interest_period == InterestPeriod::ANNUALLY->value) {
                $due_run_time = $start_date->diffInYears($end_date);
            }



            // Calculate Investment Interest
            $interest = $value->rate_type == 'percent' ? ($value->rate_number * $value->amount) / 100 : $value->rate_number;

            // Caluculated some variables
            $run_time =  $due_run_time - $value->run_time;
            $total_run_time = $value->maturity / $value->interest_period;


            // Check if the script is due to run and how many times
            for ($i = 0; $i < $run_time && $i < $total_run_time - $value->run_time; $i++) {
                // Get Client Current Balance
                if ($settings->allow_withdraw_deposit) {
                    $client_balance = User::select('balance')->findorFail($value->user_id)->balance;
                } else {
                    $client_balance = User::select('available_balance')->findorFail($value->user_id)->available_balance;
                }

                // Create Transaction records
                $value->transaction()->create([
                    'user_id' => $value->user_id,
                    'trx_num' => strval(bin2hex(random_bytes(10))),
                    'amount' => $interest,
                    'post_amount' => $client_balance + $interest,
                    'status' => true,
                ]);

                // Increament Investment Run Time
                $curr_invest = Investment::findorFail($value->id);
                $curr_invest->increment('run_time', 1);
                $curr_invest->increment('acc_profit', $interest);

                // Increament User Balance
                // User::where('id', $value->user_id)->incrementEach([
                //     'balance' => $interest,
                //     'available_balance' => $interest,
                // ]);
            }


            // Mark the Investment as Matured if the Run_Time is greater or equal to the number of time is meant to run
            $invest = Investment::with('plan')->findorFail($value->id);
            if ($invest->run_time >= round($invest->maturity / $invest->interest_period)) {

                // Get Client Current Balance
                if ($settings->allow_withdraw_deposit) {
                    $current_balance = User::select('balance')->findorFail($value->user_id)->balance;
                } else {
                    $current_balance = User::select('available_balance')->findorFail($value->user_id)->available_balance;
                }

                if ($invest->plan->return_capital_amount) {

                    // Create Transaction records
                    $invest->transaction()->create([
                        'user_id' => $invest->user_id,
                        'trx_num' => strval(bin2hex(random_bytes(10))),
                        'amount' => $invest->amount,
                        'post_amount' => $current_balance + $invest->amount,
                        'status' => true,
                    ]);

                    // Increament User Balance by Invested Amount
                    User::where('id', $value->user_id)->incrementEach([
                        'balance' => $invest->amount + $invest->acc_profit,
                        'available_balance' => $invest->amount + $invest->acc_profit,
                    ]);
                } else {
                    // Increament User Balance by Profit Amount
                    User::where('id', $value->user_id)->incrementEach([
                        'balance' => $invest->acc_profit,
                        'available_balance' => $invest->acc_profit,
                    ]);
                }

                $invest->update(['status' => true]);
            }
        }
    }
}
