<?php

namespace App\Jobs;

use App\Models\deposit;
use App\Models\Trade;
use App\Models\tradingbot;
use App\Models\User;
use App\Models\withdraw;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateTradeProfits implements ShouldQueue
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
        // $trades = Trade::all();
        // foreach ($trades as $trade) {
        //     $decodedTrade = json_decode($trade['trades']);
        //     $amount_earned = 0;
        //     foreach ($decodedTrade as $dcd) {
        //         $profit = $dcd->profit;
        //         $amount_earned += $profit;
        //     }
        //     Trade::where('id', $trade['id'])->update(['total_amount_earned' => strval($amount_earned)]);
        // }

        $users = User::all();
        
        foreach($users as $user) {
            // starting balances
            $totalDemoAccountDeposits = 10000;
            $totalLiveAccountDeposits = deposit::where(['user_id' => $user['id'], 'deposit_status' => 1])->get()->sum('amount');

            // trade profits
            $totalDemoAccountProfit = tradingbot::where(['user_id' => $user['id'], 'account_type' => 'demo', 'status' => '0'])->get()
            ->sum('amount_earned');
            
            $totalLiveAccountProfit = tradingbot::where(['user_id' => $user['id'], 'account_type' => 'live', 'status' => '0'])->get()
            ->sum('amount_earned');

            // withdrawals
            $totalLiveAccountWithdrawals = withdraw::where(['user_id' => $user['id'], 'withdraw_status' => 1])->get()->sum('amount');

            // active trades
            $activeLiveTrade = tradingbot::where(['user_id' => $user['id'], 'account_type' => 'live', 'status' => '1'])->get()->sum('amount');
            $activeDemoTrade = tradingbot::where(['user_id' => $user['id'], 'account_type' => 'demo', 'status' => '1'])->get()->sum('amount');

            $liveBalance = floatval($totalLiveAccountDeposits) - floatval($totalLiveAccountWithdrawals) - floatval($activeLiveTrade) + floatval($totalLiveAccountProfit);
            $demoBalance = floatval($totalDemoAccountDeposits) - floatval($activeDemoTrade) + floatval($totalDemoAccountProfit);

            User::where('id', $user['id'])->update(['balance' => strval($liveBalance), 'demo_balance' => strval($demoBalance)]);

            // sync tradingbots and trades
            $userTradingBots = tradingbot::where(['user_id' => $user['id'], 'amount_earned' => '0'])->get()->toArray();
            
            // $userTradingBots = tradingbot::where(['user_id' => $user['id']])->get()->toArray();

            if (empty($userTradingBots)) {
                continue;
            }

            foreach ($userTradingBots as $bot) {
                // revert balances
                // $trade = Trade::where('bot_id', $bot['id'])->get()->toArray();
                // if ($trade[0]['stopped_robot_at_position'] == 0) {
                //     tradingbot::where(['id' => $bot['id']])->update(['amount_earned' => '0']);
                // }

                $trade = Trade::where(['bot_id' => $bot['id']])->get()->toArray();
                if ($trade[0]['stopped_robot_at_position'] == 287) {
                    $amount_earned = intval($trade[0]['total_amount_earned']);
                    $companyCommission = 0.01 * $amount_earned;
                    $amount_earned = $amount_earned - $companyCommission;
                    tradingbot::where(['id' => $bot['id']])->update(['amount_earned' => strval($amount_earned)]);
                }
            }
        }
    }
}
