<?php

namespace App\Jobs;

use App\Models\Trade;
use App\Models\tradingbot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MatureTrades implements ShouldQueue
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
        $users = User::all();

        foreach($users as $user) {
            $userTradingBots = tradingbot::where(['user_id' => $user['id'], 'status' => '1'])->get()->toArray();
            
            foreach ($userTradingBots as $bot) { 
                $currentDateTime = Carbon::createFromFormat('d-m-Y H:i:s', date("d-m-Y H:i:s"));
                $duration_end = Carbon::createFromFormat('d-m-Y H:i:s', $bot['duration_end']);

                if ($currentDateTime->gt($duration_end)) {
                    $tradeExpired = Trade::where('bot_id', $bot['id'])->get()->toArray();
                    $tradeAmountEarned = $tradeExpired[0]['total_amount_earned'];
                    $companyCommission = 0.01 * floatval($tradeAmountEarned);
                    $finalAmountEarned = floatval($tradeAmountEarned) - $companyCommission;
    
                    // update amount earned in the trading bot
                    tradingbot::where('id', $bot['id'])->update(['amount_earned' => strval($finalAmountEarned), 'status' => '0']);
                    Trade::where('id', $tradeExpired[0]['id'])->update(['stopped_robot_at_position' => 287]);
    
                    if($bot['account_type'] == 'demo') {
                        $demoBalanceExpired = floatval($user['demo_balance']) + floatval($bot['amount']) + $finalAmountEarned;
                        User::where('id', $user['id'])->update(['demo_balance' => strval($demoBalanceExpired)]);
                    }
                    
                    if($bot['account_type'] == 'live') {
                        $liveBalanceExpired = floatval($user['balance']) + floatval($bot['amount']) + $finalAmountEarned;
                        User::where('id', $user['id'])->update(['balance' => strval($liveBalanceExpired)]);
                    }
                }

            }
        }
    }
}
