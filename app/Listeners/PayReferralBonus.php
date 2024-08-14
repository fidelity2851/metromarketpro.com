<?php

namespace App\Listeners;

use App\Events\RewardReferral;
use App\Models\Deposit;
use App\Models\Referral;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PayReferralBonus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RewardReferral $event): void
    {
        $settings = Setting::firstWhere('status', true);

        if ($settings->referral_active) {
            $deposit = $event->deposit;

            // Check the Referral Paying Duration
            if ($settings->pay_referral_once == true) {
                $deposit_count = Deposit::where(['user_id' => $deposit->user_id], ['status' => true])->count();

                // Check whether it is the Client first Deposit
                if ($deposit_count > 1) {
                    return;
                }
            }

            // Get the Referral Record
            $referral = Referral::firstWhere('referee_id', $deposit->user_id);

            if ($referral) {
                // Get Client Current Balance

                if ($settings->allow_withdraw_deposit) {
                    $client_balance = User::select('balance')->findorFail($referral->referral_id)->balance;
                } else {
                    $client_balance = User::select('available_balance')->findorFail($referral->referral_id)->available_balance;
                }

                // Calculate the Referral Bonus
                $referral_bonus = $settings->referral_pay_type == 'percentage' ? ($settings->referral_pay_rate * $deposit->amount) / 100 : $settings->referral_pay_rate;

                $paid = $referral->increment('amount', $referral_bonus);

                if ($paid) {
                    // Update Referral Record
                    $referral->transaction()->create([
                        'user_id' => $referral->referral_id,
                        'trx_num' => strval(bin2hex(random_bytes(10))),
                        'amount' => $referral_bonus,
                        'post_amount' => $referral_bonus + $client_balance,
                        'status' => true,
                    ]);

                    // Increament User Balance
                    User::where('id', $referral->referral_id)->incrementEach([
                        'balance' => $referral_bonus,
                        'available_balance' => $referral_bonus,
                    ]);
                }
            }
        }
    }
}
