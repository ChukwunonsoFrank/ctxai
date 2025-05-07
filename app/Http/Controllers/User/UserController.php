<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

//models
use App\Models\User;
use App\Models\Coins;
use App\Models\plans;
use App\Models\Trade;
use App\Models\tradingbot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getUserDetails()
    {
        $wallets = Coins::query()->get()->toArray();
        $plans = plans::query()->orderBy('order', 'asc')->get()->toArray();

        // returns on robot here
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => 1,
            ])
            ->get()->toArray();

        if (!empty($tradingbots)) {
            $currentdate = strtotime(date("d-m-Y H:i:s"));
            $currentDateTime = Carbon::createFromFormat('d-m-Y H:i:s', date("d-m-Y H:i:s"));
            $max_roi = $tradingbots[0]['max_roi_percentage'];
            $min_roi = $tradingbots[0]['min_roi_percentage'];
            $duration = $tradingbots[0]['plan_duration'];
            $duration_start = Carbon::createFromFormat('d-m-Y H:i:s', $tradingbots[0]['duration_start']);
            $duration_end = Carbon::createFromFormat('d-m-Y H:i:s', $tradingbots[0]['duration_end']);
            $amount = $tradingbots[0]['amount'];
            $profit_limit_exceed = $tradingbots[0]['profit_limit_exceed'];
            $tradingbot_id = $tradingbots[0]['id'];
            $trading_type = $tradingbots[0]['account_type'];
            $tradingbot_amountearned = $tradingbots[0]['amount_earned'];

            // profit will exceed
            if ($profit_limit_exceed == "yes") {
                $amount_earned = 0;

                $botTrade = Trade::where('bot_id', $tradingbot_id)->get()->toArray();

                if($botTrade[0]['stopped_robot_at_position']) {
                    $decodedTrades = json_decode($botTrade[0]['trades']);
                    for ($i = 0; $i < $botTrade[0]['stopped_robot_at_position']; $i++) {
                        $profit = $decodedTrades[$i]->profit;
                        $amount_earned += $profit;
                    }
                }

                if(is_null($botTrade[0]['stopped_robot_at_position'])) {
                    $decodedTrades = json_decode($botTrade[0]['trades']);
                    for ($i = 0; $i < count($decodedTrades); $i++) {
                        $timerEndsAt = $decodedTrades[$i]->timer_ends_at;
                        if (Carbon::now()->getTimestampMs() <= $timerEndsAt) {
                            for ($j = 0; $j < $i; $j++) {
                                $profit = $decodedTrades[$j]->profit;
                                $amount_earned += $profit;
                            }
                            break;
                        }
                        continue;
                    }
                }

                if ($currentDateTime->gt($duration_end)) {
                    if ($trading_type === 'demo') {
                        $tradeExpired = Trade::where('bot_id', $tradingbot_id)->get()->toArray();
                        $tradeAmountEarned = $tradeExpired[0]['total_amount_earned'];
                        $companyCommission = 0.01 * floatval($tradeAmountEarned);
                        $finalAmountEarned = floatval($tradeAmountEarned) - $companyCommission;
                        $demoBalanceExpired = floatval(auth()->user()->demo_balance) + floatval($amount) + $finalAmountEarned;
    
                        DB::transaction(function () use ($tradingbot_id, $finalAmountEarned, $tradeExpired, $demoBalanceExpired) {
                            tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => strval($finalAmountEarned), 'status' => '0']);
                            Trade::where('id', $tradeExpired[0]['id'])->update(['stopped_robot_at_position' => 287]);
                            User::where('id', auth()->user()->id)->update(['demo_balance' => strval($demoBalanceExpired)]);
                        });
                    }

                    if ($trading_type === 'live') {
                        $tradeExpired = Trade::where('bot_id', $tradingbot_id)->get()->toArray();
                        $tradeAmountEarned = $tradeExpired[0]['total_amount_earned'];
                        $companyCommission = 0.01 * floatval($tradeAmountEarned);
                        $finalAmountEarned = floatval($tradeAmountEarned) - $companyCommission;
                        $liveBalanceExpired = floatval(auth()->user()->balance) + floatval($amount) + $finalAmountEarned;
    
                        DB::transaction(function () use ($tradingbot_id, $finalAmountEarned, $tradeExpired, $liveBalanceExpired) {
                            tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => strval($finalAmountEarned), 'status' => '0']);
                            Trade::where('id', $tradeExpired[0]['id'])->update(['stopped_robot_at_position' => 287]);
                            User::where('id', auth()->user()->id)->update(['balance' => strval($liveBalanceExpired)]);
                        });
                    }
                } else {
                    $max_amount_earned = ($max_roi / 100) * floatval($amount);
                    $tradingbot_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => strval($amount_earned)]);
                }
            } else {
                //profit will not exceed
                $amount_earned = 0;

                $botTrade = Trade::where('bot_id', $tradingbot_id)->get()->toArray();

                if($botTrade[0]['stopped_robot_at_position']) {
                    $decodedTrades = json_decode($botTrade[0]['trades']);
                    for ($i = 0; $i < $botTrade[0]['stopped_robot_at_position']; $i++) {
                        $profit = $decodedTrades[$i]->profit;
                        $amount_earned += $profit;
                    }
                }

                if(is_null($botTrade[0]['stopped_robot_at_position'])) {
                    $decodedTrades = json_decode($botTrade[0]['trades']);
                    for ($i = 0; $i < count($decodedTrades); $i++) {
                        $timerEndsAt = $decodedTrades[$i]->timer_ends_at;
                        if (Carbon::now()->getTimestampMs() <= $timerEndsAt) {
                            for ($j = 0; $j < $i; $j++) {
                                $profit = $decodedTrades[$j]->profit;
                                $amount_earned += $profit;
                            }
                            break;
                        }
                        continue;
                    }
                }

                if ($currentDateTime->gt($duration_end)) {
                    if ($trading_type === 'demo') {
                        $tradeExpired = Trade::where('bot_id', $tradingbot_id)->get()->toArray();
                        $tradeAmountEarned = $tradeExpired[0]['total_amount_earned'];
                        $companyCommission = 0.01 * floatval($tradeAmountEarned);
                        $finalAmountEarned = floatval($tradeAmountEarned) - $companyCommission;
                        $demoBalanceExpired = floatval(auth()->user()->demo_balance) + floatval($amount) + $finalAmountEarned;
    
                        DB::transaction(function () use ($tradingbot_id, $finalAmountEarned, $tradeExpired, $demoBalanceExpired) {
                            tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => strval($finalAmountEarned), 'status' => '0']);
                            Trade::where('id', $tradeExpired[0]['id'])->update(['stopped_robot_at_position' => 287]);
                            User::where('id', auth()->user()->id)->update(['demo_balance' => strval($demoBalanceExpired)]);
                        });
                    }

                    if ($trading_type === 'live') {
                        $tradeExpired = Trade::where('bot_id', $tradingbot_id)->get()->toArray();
                        $tradeAmountEarned = $tradeExpired[0]['total_amount_earned'];
                        $companyCommission = 0.01 * floatval($tradeAmountEarned);
                        $finalAmountEarned = floatval($tradeAmountEarned) - $companyCommission;
                        $liveBalanceExpired = floatval(auth()->user()->balance) + floatval($amount) + $finalAmountEarned;
    
                        DB::transaction(function () use ($tradingbot_id, $finalAmountEarned, $tradeExpired, $liveBalanceExpired) {
                            tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => strval($finalAmountEarned), 'status' => '0']);
                            Trade::where('id', $tradeExpired[0]['id'])->update(['stopped_robot_at_position' => 287]);
                            User::where('id', auth()->user()->id)->update(['balance' => strval($liveBalanceExpired)]);
                        });
                    }
                } else {
                    //get max roi amount 
                    $max_amount_earned = ($max_roi / 100) * floatval($amount);
                    $tradingbot_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => strval($amount_earned)]);
                }
            }
        }

        $user = User::where('id', Auth::User()->id)->first()->toArray();

        return compact('user', 'wallets', 'plans');
    }

    function generateRandomFloatsWithSumConstrained($count, $target) {
        $random_numbers = [];
        for ($i = 0; $i < $count; $i++) {
            $random_numbers[] = mt_rand(0, 8000) / 1000; // Generates random floats between 0 and 1. Adjust range as needed
        }
    
        $current_sum = array_sum($random_numbers);
    
        $normalized_numbers = [];
        foreach ($random_numbers as $number) {
            $normalized_numbers[] = ($number / $current_sum) * $target;
        }

        $total_amount_earned = 0;
        foreach ($normalized_numbers as $nn) {
            $total_amount_earned += $nn;
        }
    
        return [
            'normalized_number' => $normalized_numbers,
            'total_amount_earned' => $total_amount_earned
        ];
    }

    public function getTradingAndSelectedAssetData()
    {
        $trading_pair_data = [
            [
                "name" => "BTC/USDT",
                "percentage" => "91%",
                "image" => "btc.png",
                "assetType" => "coin",
                "symbol" => "BTCUSDT"
            ],
            [
                "name" => "ETH/USDT",
                "percentage" => "95%",
                "image" => "eth.png",
                "assetType" => "coin",
                "symbol" => "ETHUSDT"
            ],
            [
                "name" => "LTC/USDT",
                "percentage" => "95%",
                "image" => "ltc.png",
                "assetType" => "coin",
                "symbol" => "LTCUSDT"
            ],
            [
                "name" => "SOL/USDT",
                "percentage" => "98%",
                "image" => "sol.png",
                "assetType" => "coin",
                "symbol" => "SOLUSDT"
            ],
            [
                "name" => "XRP/USDT",
                "percentage" => "93%",
                "image" => "xrp.png",
                "assetType" => "coin",
                "symbol" => "XRPUSDT"
            ],
            [
                "name" => "DOGE/USDT",
                "percentage" => "83%",
                "image" => "doge.png",
                "assetType" => "coin",
                "symbol" => "DOGEUSDT"
            ],
            [
                "name" => "BCH/USDT",
                "percentage" => "89%",
                "image" => "bch.png",
                "assetType" => "coin",
                "symbol" => "BCHUSDT"
            ],
            [
                "name" => "DAI/USDT",
                "percentage" => "97%",
                "image" => "dai.png",
                "assetType" => "coin",
                "symbol" => "DAIUSDT"
            ],
            [
                "name" => "BNB/USDT",
                "percentage" => "87%",
                "image" => "bnb.png",
                "assetType" => "coin",
                "symbol" => "BNBUSDT"
            ],
            [
                "name" => "ADA/USDT",
                "percentage" => "93%",
                "image" => "ada.png",
                "assetType" => "coin",
                "symbol" => "ADAUSDT"
            ],
            [
                "name" => "AVAX/USDT",
                "percentage" => "99%",
                "image" => "avax.png",
                "assetType" => "coin",
                "symbol" => "AVAXUSDT"
            ],
            [
                "name" => "TRX/USDT",
                "percentage" => "90%",
                "image" => "trx.png",
                "assetType" => "coin",
                "symbol" => "TRXUSDT"
            ],
            [
                "name" => "MATIC/USDT",
                "percentage" => "91%",
                "image" => "matic.png",
                "assetType" => "coin",
                "symbol" => "MATICUSDT"
            ],
            [
                "name" => "ATOM/USDT",
                "percentage" => "96%",
                "image" => "atom.png",
                "assetType" => "coin",
                "symbol" => "ATOMUSDT"
            ],
            [
                "name" => "LINK/USDT",
                "percentage" => "87%",
                "image" => "link.png",
                "assetType" => "coin",
                "symbol" => "LINKUSDT"
            ],
            [
                "name" => "DASH/USDT",
                "percentage" => "87%",
                "image" => "dash.png",
                "assetType" => "coin",
                "symbol" => "DASHUSDT"
            ],
            [
                "name" => "XLM/USDT",
                "percentage" => "93%",
                "image" => "xlm.png",
                "assetType" => "coin",
                "symbol" => "XLMUSDT"
            ],
            [
                "name" => "NEO/USDT",
                "percentage" => "93%",
                "image" => "neo.png",
                "assetType" => "coin",
                "symbol" => "NEOUSDT"
            ],
            [
                "name" => "Basic Altcoin Index",
                "percentage" => "88%",
                "image" => "ALTCOIN.svg",
                "assetType" => "coin",
                "symbol" => "XAI"
            ],
            [
                "name" => "BAT/USDT",
                "percentage" => "83%",
                "image" => "bat.png",
                "assetType" => "coin",
                "symbol" => "BATUSDT"
            ],
            [
                "name" => "ETC/USDT",
                "percentage" => "86%",
                "image" => "etc.png",
                "assetType" => "coin",
                "symbol" => "ETCUSDT"
            ],
            [
                "name" => "ZEC/USDT",
                "percentage" => "94%",
                "image" => "zec.png",
                "assetType" => "coin",
                "symbol" => "ZECUSDT"
            ],
            [
                "name" => "ONT/USDT",
                "percentage" => "96%",
                "image" => "ont.png",
                "assetType" => "coin",
                "symbol" => "ONTUSDT"
            ],
            [
                "name" => "STX/USDT",
                "percentage" => "96%",
                "image" => "stx.png",
                "assetType" => "coin",
                "symbol" => "STXUSDT"
            ],
            [
                "name" => "MKR/USDT",
                "percentage" => "95%",
                "image" => "mkr.png",
                "assetType" => "coin",
                "symbol" => "MKRUSDT"
            ],
            [
                "name" => "AAVE/USDT",
                "percentage" => "90%",
                "image" => "aave.png",
                "assetType" => "coin",
                "symbol" => "AAVEUSDT"
            ],
            [
                "name" => "XMR/USDT",
                "percentage" => "99%",
                "image" => "xmr.png",
                "assetType" => "coin",
                "symbol" => "XMRUSDT"
            ],
            [
                "name" => "YFI/USDT",
                "percentage" => "95%",
                "image" => "yfi.png",
                "assetType" => "coin",
                "symbol" => "YFIUSDT"
            ],
            // [
            //     "name" => "Asia Composite Index",
            //     "percentage" => "93%",
            //     "image" => "ASIA_X.svg",
            //     "assetType" => "currency"
            // ],
            // [
            //     "name" => "Europe Composite Index",
            //     "percentage" => "92%",
            //     "image" => "EUROPE_X.svg",
            //     "assetType" => "currency"
            // ],
            // [
            //     "name" => "Commodity Composite Index",
            //     "percentage" => "91%",
            //     "image" => "ASIA_X.svg",
            //     "assetType" => "currency",
            //     "symbol" => "AUDCAD"
            // ],
            [
                "name" => "Gold",
                "percentage" => "89%",
                "image" => "XAUUSD.svg",
                "assetType" => "currency",
                "symbol" => "XAUUSD"
            ],
            [
                "name" => "EUR/USD",
                "percentage" => "99%",
                "image" => "EURUSD_OTC.svg",
                "assetType" => "currency",
                "symbol" => "EURUSD"
            ],
            [
                "name" => "AUD/CAD",
                "percentage" => "96%",
                "image" => "AUDCAD.svg",
                "assetType" => "currency",
                "symbol" => "AUDCAD"
            ],
            [
                "name" => "GBP/USD",
                "percentage" => "85%",
                "image" => "GBPUSD_OTC.svg",
                "assetType" => "currency",
                "symbol" => "GBPUSD"
            ],
            [
                "name" => "GBP/NZD",
                "percentage" => "89%",
                "image" => "GBPNZD.svg",
                "assetType" => "currency",
                "symbol" => "GBPNZD"
            ],
            [
                "name" => "USD/JPY",
                "percentage" => "97%",
                "image" => "USDJPY_OTC.svg",
                "assetType" => "currency",
                "symbol" => "USDJPY"
            ],
            [
                "name" => "EUR/GBP",
                "percentage" => "95%",
                "image" => "EURGBP.svg",
                "assetType" => "currency",
                "symbol" => "EURGBP"
            ],
            [
                "name" => "GBP/CHF",
                "percentage" => "90%",
                "image" => "GBPCHF.svg",
                "assetType" => "currency",
                "symbol" => "GBPCHF"
            ],
            [
                "name" => "GBP/CAD",
                "percentage" => "88%",
                "image" => "GBPCAD.svg",
                "assetType" => "currency",
                "symbol" => "GBPCAD"
            ],
            [
                "name" => "NASDAQ",
                "percentage" => "92%",
                "image" => "NQ.svg",
                "assetType" => "currency",
                "symbol" => "NQ"
            ],
            [
                "name" => "CAC 40",
                "percentage" => "94%",
                "image" => "FCE.svg",
                "assetType" => "currency",
                "symbol" => "CAC40"
            ],
            [
                "name" => "Copper",
                "percentage" => "86%",
                "image" => "HG.svg",
                "assetType" => "currency",
                "symbol" => "XCUUSD"
            ],
            [
                "name" => "FTSE 100",
                "percentage" => "96%",
                "image" => "Z.svg",
                "assetType" => "currency",
                "symbol" => "FTSE"
            ],
            [
                "name" => "AUD/JPY",
                "percentage" => "93%",
                "image" => "AUDJPY.svg",
                "assetType" => "currency",
                "symbol" => "AUDJPY"
            ],
            [
                "name" => "CAD/CHF",
                "percentage" => "77%",
                "image" => "CADCHF.svg",
                "assetType" => "currency",
                "symbol" => "CADCHF"
            ],
            [
                "name" => "CAD/JPY",
                "percentage" => "85%",
                "image" => "CADJPY.svg",
                "assetType" => "currency",
                "symbol" => "CADJPY"
            ],
            [
                "name" => "EUR/AUD",
                "percentage" => "97%",
                "image" => "EURAUD.svg",
                "assetType" => "currency",
                "symbol" => "EURAUD"
            ],
            [
                "name" => "EUR/JPY",
                "percentage" => "91%",
                "image" => "EURJPY.svg",
                "assetType" => "currency",
                "symbol" => "EURJPY"
            ],
            [
                "name" => "EUR/CAD",
                "percentage" => "99%",
                "image" => "EURCAD.svg",
                "assetType" => "currency",
                "symbol" => "EURCAD"
            ],
            [
                "name" => "GPB/JPY",
                "percentage" => "83%",
                "image" => "GBPJPY.svg",
                "assetType" => "currency",
                "symbol" => "GBPJPY"
            ],
            [
                "name" => "NZD/CAD",
                "percentage" => "90%",
                "image" => "NZDCAD.svg",
                "assetType" => "currency",
                "symbol" => "NZDCAD"
            ],
            [
                "name" => "NZD/CHF",
                "percentage" => "98%",
                "image" => "NZDCHF.svg",
                "assetType" => "currency",
                "symbol" => "NZDCHF"
            ],
            [
                "name" => "NZD/JPY",
                "percentage" => "95%",
                "image" => "NZDJPY.svg",
                "assetType" => "currency",
                "symbol" => "NZDJPY"
            ],
            [
                "name" => "USD/MXN",
                "percentage" => "95%",
                "image" => "USDMXN.svg",
                "assetType" => "currency",
                "symbol" => "USDMXN"
            ],
            [
                "name" => "USD/SGD",
                "percentage" => "98%",
                "image" => "USDSGD.svg",
                "assetType" => "currency",
                "symbol" => "USDSGD"
            ],
            [
                "name" => "NZD/USD",
                "percentage" => "96%",
                "image" => "NZDUSD_OTC.svg",
                "assetType" => "currency",
                "symbol" => "NZDUSD"
            ],
            [
                "name" => "USD/CHF",
                "percentage" => "91%",
                "image" => "USDCHF_OTC.svg",
                "assetType" => "currency",
                "symbol" => "USDCHF"
            ],
            [
                "name" => "USD/CHF",
                "percentage" => "96%",
                "image" => "USDCHF_OTC.svg",
                "assetType" => "currency",
                "symbol" => "USDCHF"
            ],
            [
                "name" => "AUD/CHF",
                "percentage" => "96%",
                "image" => "AUDCHF.svg",
                "assetType" => "currency",
                "symbol" => "AUDCHF"
            ],
            [
                "name" => "CHF/JPY",
                "percentage" => "99%",
                "image" => "CHFJPY.svg",
                "assetType" => "currency",
                "symbol" => "CHFJPY"
            ]
        ];

        $exactTrade = $this->fetchExactTradeFromCurrentBotTrade();

        $selected_asset = Session::get('selected_asset');
        if (empty($selected_asset)) {
            Session::put('selected_asset', $exactTrade['trade']->asset_name ?? 'BTCUSDT');
            $selected_asset = $exactTrade['trade']->asset_name ?? 'BTCUSDT';
        } else {
            Session::put('selected_asset', $exactTrade['trade']->asset_name ?? 'BTCUSDT');
            $selected_asset = $exactTrade['trade']->asset_name ?? 'BTCUSDT';
        }

        $selected_asset_data = array_filter($trading_pair_data, function ($pair) use ($selected_asset) {
            return $pair['symbol'] === $selected_asset;
        });

        // Reset the index of returned data for consistent access
        if (!isset($selected_asset_data[0])) {
            foreach ($selected_asset_data as $data) {
                $selected_asset_data[0] = $data;
            }
        }
        return ['selected_asset_data' => $selected_asset_data, 'trading_pair_data' => $trading_pair_data];
    }

    public function generateTrades($duration, $amount, $max_roi)
    {
        $cryptoTradingPair = [
            [
                "name" => "BTC/USDT",
                "percentage" => "91%",
                "assetType" => "coin",
                "symbol" => "BTCUSDT",
                "image" => "btc.png"
            ],
            [
                "name" => "ETH/USDT",
                "percentage" => "95%",
                "assetType" => "coin",
                "symbol" => "ETHUSDT",
                "image" => "eth.png"
            ],
            [
                "name" => "LTC/USDT",
                "percentage" => "95%",
                "assetType" => "coin",
                "symbol" => "LTCUSDT",
                "image" => "ltc.png"
            ],
            [
                "name" => "SOL/USDT",
                "percentage" => "98%",
                "assetType" => "coin",
                "symbol" => "SOLUSDT",
                "image" => "sol.png"
            ],
            [
                "name" => "XRP/USDT",
                "percentage" => "93%",
                "assetType" => "coin",
                "symbol" => "XRPUSDT",
                "image" => "xrp.png"
            ],
            [
                "name" => "DOGE/USDT",
                "percentage" => "83%",
                "assetType" => "coin",
                "symbol" => "DOGEUSDT",
                "image" => "doge.png"
            ],
            [
                "name" => "BCH/USDT",
                "percentage" => "89%",
                "assetType" => "coin",
                "symbol" => "BCHUSDT",
                "image" => "bch.png"
            ],
            [
                "name" => "DAI/USDT",
                "percentage" => "97%",
                "assetType" => "coin",
                "symbol" => "DAIUSDT",
                "image" => "dai.png"
            ],
            [
                "name" => "BNB/USDT",
                "percentage" => "87%",
                "assetType" => "coin",
                "symbol" => "BNBUSDT",
                "image" => "bnb.png"
            ],
            [
                "name" => "ADA/USDT",
                "percentage" => "93%",
                "assetType" => "coin",
                "symbol" => "ADAUSDT",
                "image" => "ada.png"
            ],
            [
                "name" => "AVAX/USDT",
                "percentage" => "99%",
                "assetType" => "coin",
                "symbol" => "AVAXUSDT",
                "image" => "avax.png"
            ],
            [
                "name" => "TRX/USDT",
                "percentage" => "90%",
                "assetType" => "coin",
                "symbol" => "TRXUSDT",
                "image" => "trx.png"
            ],
            [
                "name" => "MATIC/USDT",
                "percentage" => "91%",
                "assetType" => "coin",
                "symbol" => "MATICUSDT",
                "image" => "matic.png"
            ],
            [
                "name" => "ATOM/USDT",
                "percentage" => "96%",
                "assetType" => "coin",
                "symbol" => "ATOMUSDT",
                "image" => "atom.png"
            ],
            [
                "name" => "LINK/USDT",
                "percentage" => "87%",
                "assetType" => "coin",
                "symbol" => "LINKUSDT",
                "image" => "link.png"
            ],
            [
                "name" => "DASH/USDT",
                "percentage" => "87%",
                "assetType" => "coin",
                "symbol" => "DASHUSDT",
                "image" => "dash.png"
            ],
            [
                "name" => "XLM/USDT",
                "percentage" => "93%",
                "assetType" => "coin",
                "symbol" => "XLMUSDT",
                "image" => "xlm.png"
            ],
            [
                "name" => "NEO/USDT",
                "percentage" => "93%",
                "assetType" => "coin",
                "symbol" => "NEOUSDT",
                "image" => "neo.png"
            ],
            [
                "name" => "BAT/USDT",
                "percentage" => "83%",
                "assetType" => "coin",
                "symbol" => "BATUSDT",
                "image" => "bat.png"
            ],
            [
                "name" => "ETC/USDT",
                "percentage" => "86%",
                "assetType" => "coin",
                "symbol" => "ETCUSDT",
                "image" => "etc.png"
            ],
            [
                "name" => "ZEC/USDT",
                "percentage" => "94%",
                "assetType" => "coin",
                "symbol" => "ZECUSDT",
                "image" => "zec.png"
            ],
            [
                "name" => "ONT/USDT",
                "percentage" => "96%",
                "assetType" => "coin",
                "symbol" => "ONTUSDT",
                "image" => "ont.png"
            ],
            [
                "name" => "STX/USDT",
                "percentage" => "96%",
                "assetType" => "coin",
                "symbol" => "STXUSDT",
                "image" => "stx.png"
            ],
            [
                "name" => "MKR/USDT",
                "percentage" => "95%",
                "assetType" => "coin",
                "symbol" => "MKRUSDT",
                "image" => "mkr.png"
            ],
            [
                "name" => "AAVE/USDT",
                "percentage" => "90%",
                "assetType" => "coin",
                "symbol" => "AAVEUSDT",
                "image" => "aave.png"
            ],
            [
                "name" => "XMR/USDT",
                "percentage" => "99%",
                "assetType" => "coin",
                "symbol" => "XMRUSDT",
                "image" => "xmr.png"
            ],
            [
                "name" => "YFI/USDT",
                "percentage" => "95%",
                "assetType" => "coin",
                "symbol" => "YFIUSDT",
                "image" => "yfi.png"
            ]
        ];

        $forexTradingPair = [
            [
                "name" => "EUR/USD",
                "percentage" => "99%",
                "assetType" => "currency",
                "symbol" => "EURUSD",
                "image" => "EURUSD_OTC.svg"
            ],
            [
                "name" => "AUD/CAD",
                "percentage" => "96%",
                "assetType" => "currency",
                "symbol" => "AUDCAD",
                "image" => "AUDCAD.svg"
            ],
            [
                "name" => "GBP/USD",
                "percentage" => "85%",
                "assetType" => "currency",
                "symbol" => "GBPUSD",
                "image" => "GBPUSD_OTC.svg"
            ],
            [
                "name" => "GBP/NZD",
                "percentage" => "89%",
                "assetType" => "currency",
                "symbol" => "GBPNZD",
                "image" => "GBPNZD.svg"
            ],
            [
                "name" => "USD/JPY",
                "percentage" => "97%",
                "assetType" => "currency",
                "symbol" => "USDJPY",
                "image" => "USDJPY_OTC.svg"
            ],
            [
                "name" => "EUR/GBP",
                "percentage" => "95%",
                "assetType" => "currency",
                "symbol" => "EURGBP",
                "image" => "EURGBP.svg"
            ],
            [
                "name" => "GBP/CHF",
                "percentage" => "90%",
                "assetType" => "currency",
                "symbol" => "GBPCHF",
                "image" => "GBPCHF.svg"
            ],
            [
                "name" => "GBP/CAD",
                "percentage" => "88%",
                "assetType" => "currency",
                "symbol" => "GBPCAD",
                "image" => "GBPCAD.svg"
            ],
            [
                "name" => "NASDAQ",
                "percentage" => "92%",
                "assetType" => "currency",
                "symbol" => "NQ",
                "image" => "NQ.svg"
            ],
            [
                "name" => "CAC 40",
                "percentage" => "94%",
                "assetType" => "currency",
                "symbol" => "CAC40",
                "image" => "FCE.svg"
            ],
            [
                "name" => "FTSE 100",
                "percentage" => "96%",
                "assetType" => "currency",
                "symbol" => "FTSE",
                "image" => "Z.svg"
            ],
            [
                "name" => "AUD/JPY",
                "percentage" => "93%",
                "assetType" => "currency",
                "symbol" => "AUDJPY",
                "image" => "AUDJPY.svg"
            ],
            [
                "name" => "CAD/CHF",
                "percentage" => "77%",
                "assetType" => "currency",
                "symbol" => "CADCHF",
                "image" => "CADCHF.svg"
            ],
            [
                "name" => "CAD/JPY",
                "percentage" => "85%",
                "assetType" => "currency",
                "symbol" => "CADJPY",
                "image" => "CADJPY.svg"
            ],
            [
                "name" => "EUR/AUD",
                "percentage" => "97%",
                "assetType" => "currency",
                "symbol" => "EURAUD",
                "image" => "EURAUD.svg"
            ],
            [
                "name" => "EUR/JPY",
                "percentage" => "91%",
                "assetType" => "currency",
                "symbol" => "EURJPY",
                "image" => "EURJPY.svg"
            ],
            [
                "name" => "EUR/CAD",
                "percentage" => "99%",
                "assetType" => "currency",
                "symbol" => "EURCAD",
                "image" => "EURCAD.svg"
            ],
            [
                "name" => "GPB/JPY",
                "percentage" => "83%",
                "assetType" => "currency",
                "symbol" => "GBPJPY",
                "image" => "GBPJPY.svg"
            ],
            [
                "name" => "NZD/CAD",
                "percentage" => "90%",
                "assetType" => "currency",
                "symbol" => "NZDCAD",
                "image" => "NZDCAD.svg"
            ],
            [
                "name" => "NZD/CHF",
                "percentage" => "98%",
                "assetType" => "currency",
                "symbol" => "NZDCHF",
                "image" => "NZDCHF.svg"
            ],
            [
                "name" => "NZD/JPY",
                "percentage" => "95%",
                "assetType" => "currency",
                "symbol" => "NZDJPY",
                "image" => "NZDJPY.svg"
            ],
            [
                "name" => "USD/MXN",
                "percentage" => "95%",
                "assetType" => "currency",
                "symbol" => "USDMXN",
                "image" => "USDMXN.svg"
            ],
            [
                "name" => "USD/SGD",
                "percentage" => "98%",
                "assetType" => "currency",
                "symbol" => "USDSGD",
                "image" => "USDSGD.svg"
            ],
            [
                "name" => "NZD/USD",
                "percentage" => "96%",
                "assetType" => "currency",
                "symbol" => "NZDUSD",
                "image" => "NZDUSD_OTC.svg"
            ],
            [
                "name" => "USD/CHF",
                "percentage" => "91%",
                "assetType" => "currency",
                "symbol" => "USDCHF",
                "image" => "USDCHF_OTC.svg"
            ],
            [
                "name" => "AUD/CHF",
                "percentage" => "96%",
                "assetType" => "currency",
                "symbol" => "AUDCHF",
                "image" => "AUDCHF.svg"
            ],
            [
                "name" => "CHF/JPY",
                "percentage" => "99%",
                "assetType" => "currency",
                "symbol" => "CHFJPY",
                "image" => "CHFJPY.svg"
            ]
        ];

        $maxProfitPossible = (intval($max_roi) / 100) * floatval($amount);
        $randomlyGeneratedProfitValues = $this->generateRandomFloatsWithSumConstrained(288, $maxProfitPossible)['normalized_number'];
        $total_amount_earned = $this->generateRandomFloatsWithSumConstrained(288, $maxProfitPossible)['total_amount_earned'];

        $tradesArray = [];
        $timerEndsAt = 0;
        $previousTimestamp = 0;

        for($i = 0; $i < count($randomlyGeneratedProfitValues); $i++) {
            if ($i === 0) {
                $timerEndsAt = Carbon::now()->addMinutes(intval($duration))->addSeconds(8)->valueOf();
                $previousTimestamp = $timerEndsAt;
            }

            if ($i > 0) {
                $timerEndsAt = Carbon::createFromTimestampMs($previousTimestamp)->addMinutes(intval($duration))->addSeconds(8)->getPreciseTimestamp(3);
                $previousTimestamp = $timerEndsAt;
            }

            $action = '';
            $randomActionValue = mt_rand(1, 20);

            if ($randomActionValue % 2 === 0) {
                $action = 'BUY';
            } else {
                $action = 'SELL';
            }

            if (Carbon::now()->isWeekday()) {
                $randomval = mt_rand(0, 2);
                if ($randomval === 0) {
                    $randomCryptoAsset = rand(0, count($cryptoTradingPair) - 1);
                    array_push($tradesArray, [
                        'asset_name' => $cryptoTradingPair[$randomCryptoAsset]['symbol'],
                        'asset_display_name' => $cryptoTradingPair[$randomCryptoAsset]['name'],
                        'percentage' => $cryptoTradingPair[$randomCryptoAsset]['percentage'],
                        'image_url' => "/images/coins/" . $cryptoTradingPair[$randomCryptoAsset]['image'],
                        'profit' => $randomlyGeneratedProfitValues[$i],
                        'type' => 'coin',
                        'action' => $action,
                        'timer_ends_at' => $timerEndsAt,
                        'trade_position' => $i,
                        'previous_timestamp' => $timerEndsAt
                    ]);
                } else {
                    $randomForexAsset = rand(0, count($forexTradingPair) - 1);
                    array_push($tradesArray, [
                        'asset_name' => $forexTradingPair[$randomForexAsset]['symbol'],
                        'asset_display_name' => $forexTradingPair[$randomForexAsset]['name'],
                        'percentage' => $forexTradingPair[$randomForexAsset]['percentage'],
                        'image_url' => "https://olympbot.com/icons/assets/" . $forexTradingPair[$randomForexAsset]['image'],
                        'profit' => $randomlyGeneratedProfitValues[$i],
                        'type' => 'currency',
                        'action' => $action,
                        'timer_ends_at' => $timerEndsAt,
                        'trade_position' => $i,
                        'previous_timestamp' => $timerEndsAt
                    ]);
                }
            } else {
                $randomCryptoAsset = rand(0, count($cryptoTradingPair) - 1);
                array_push($tradesArray, [
                    'asset_name' => $cryptoTradingPair[$randomCryptoAsset]['symbol'],
                    'asset_display_name' => $cryptoTradingPair[$randomCryptoAsset]['name'],
                    'percentage' => $cryptoTradingPair[$randomCryptoAsset]['percentage'],
                    'image_url' => "/images/coins/" . $cryptoTradingPair[$randomCryptoAsset]['image'],
                    'profit' => $randomlyGeneratedProfitValues[$i],
                    'type' => 'coin',
                    'action' => $action,
                    'timer_ends_at' => $timerEndsAt,
                    'trade_position' => $i,
                    'previous_timestamp' => $timerEndsAt
                ]);
            }
        }

        return [
            'tradesArray' => $tradesArray,
            'total_amount_earned' => $total_amount_earned
        ];
    }

    public function fetchCurrentBotTrade()
    {
        $tradingbot = tradingbot::where([
            'user_id' => auth()->user()->id,
            'status' => 1
        ])->get()->toArray();

        if (empty($tradingbot)) {
            return [];
        }

        $tradeEntry = Trade::where('bot_id', $tradingbot[0]['id'])->get()->toArray();
        return [
            'user_id' => $tradeEntry[0]['user_id'],
            'bot_id' => $tradeEntry[0]['bot_id'],
            'trades' => json_decode($tradeEntry[0]['trades'])
        ];
    }

    public function fetchExactTradeFromCurrentBotTrade()
    {
        $currentBotTrade = $this->fetchCurrentBotTrade();
        if(empty($currentBotTrade)) {
            return [];
        }
        for ($i = 0; $i < count($currentBotTrade['trades']); $i++) {
            $timerEndsAt = $currentBotTrade['trades'][$i]->timer_ends_at;
            $now = Carbon::now()->valueOf();
            if ($now <= $timerEndsAt) {
                return [
                    'trade' => $currentBotTrade['trades'][$i],
                    'position' => $i
                ];
            }
            continue;
        }
    }

    public function selectAccount($accounttype = null)
    {
        Session::put('account_type', $accounttype);
        return Redirect::back();
    }

    public function dashboard(Request $request)
    {
        $this->getUserDetails();
        $tradeEntry = $this->fetchCurrentBotTrade();

        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => '1',
            ])
            ->get()->toArray();

        $currentRobotModal = Session::get('active_robot_modal');

        if ($currentRobotModal === 'robotsettings') {
            Session::put('display_robot_modal', 'robotsettings');
        }

        if (empty($tradingbots)) {
            Session::put('display_robot_modal', 'robotsettings');
            Session::put('active_robot_modal', 'robotsettings');
        }

        if (!empty($tradingbots)) {
            Session::put('display_robot_modal', 'activebottrade');
        }

        if (Session::get('has_robot_modal_displayed') && empty(Session::get('redirect_to_active_bot_trade'))) {
            Session::put('display_robot_modal', 'disabled');
        }

        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();

        //page session
        $robotModal = Session::get('active_robot_modal');

        if (empty($robotModal)) {
            Session::put('active_robot_modal', 'robotsettings');
        }

        if (count($tradingbots) > 0 && $tradingbots[0]['status'] === '1') {
            Session::put('active_robot_modal', 'activebottrade');
        }

        return view('user.dashboard')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
    }

    public function chart(Request $request)
    {
        $this->getUserDetails();
        $tradeEntry = $this->fetchCurrentBotTrade();
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => 1,
            ])
            ->get()->toArray();
        return view('user.chart')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
    }

    public function faq()
    {
        $this->getUserDetails();
        if (Session::get('has_robot_modal_displayed') && empty(Session::get('redirect_to_active_bot_trade'))) {
            Session::put('display_robot_modal', 'disabled');
        }
        $tradeEntry = $this->fetchCurrentBotTrade();
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => 1,
            ])
            ->get()->toArray();
        return view('user.faq')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
    }

    public function changeassetpair(Request $request)
    {
        Session::put('selected_asset', $request->query('tvwidgetsymbol'));
        return redirect()->route('dashboard.view', ['tvwidgetsymbol' => $request->query('tvwidgetsymbol')]);
    }

    public function viewassettrade(Request $request)
    {
        if (Session::get('has_robot_modal_displayed')) {
            Session::put('display_robot_modal', 'disabled');
        }
        return redirect()->route('chart.view', ['tvwidgetsymbol' => $request->query('tvwidgetsymbol')]);
    }

    public function robot(Request $request)
    {
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();

        $tradeEntry = $this->fetchCurrentBotTrade();

        $data = $request->all();

        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => '1',
            ])
            ->get()->toArray();

        if ($request->isMethod('POST')) {
            $plan = plans::where('id', $data['strategy_id'])->first()->toArray();
            $duration_start = date("d-m-Y H:i:s");
            $d = strtotime('+' . $plan['plan_duration'] . ' Hours');
            $duration_end = date("d-m-Y H:i:s", $d);
            $randomval = rand(0, 2);

            if ($randomval == 1) {
                $randomval = "yes";
            } elseif ($randomval == 0) {
                $randomval = "no";
            } else {
                $randomval = "no";
            }

            $tradingbotdetails = [
                'user_id' => Auth::User()->id,
                'amount' => $data['amount'],
                'amount_earned' => '0',
                'duration' => $data['duration'],
                'duration_start' => $duration_start,
                'duration_end' => $duration_end,
                'strategy_id' => $data['strategy_id'],
                'profit_limit_exceed' => $randomval,
                'account_type' => $data['account'],
                'status' => '1',
            ];

            $tradeArray = $this->generateTrades($data['duration'], $data['amount'], $plan['max_roi_percentage'])['tradesArray'];
            $total_amount_earned = $this->generateTrades($data['duration'], $data['amount'], $plan['max_roi_percentage'])['total_amount_earned'];

            $useractive = User::where('id', Auth::User()->id)->where('status', 1)->exists();

            // check for active trades and set them to expired
            $stillRunningTrade = tradingbot::where(['user_id' => auth()->user()->id, 'status' => '1'])->get();
            if($stillRunningTrade) {
                tradingbot::where(['user_id' => auth()->user()->id, 'status' => '1'])->update(['status' => '0']);
            }

            //checking if demo balance is greater than amount inputed
            if ($data['account'] == "demo" && Auth::User()->demo_balance >= $data['amount'] && $data['amount'] >= $plan['min_amount']) {
                if ($useractive) {
                    Session::put('active_robot_modal', 'activebottrade');
                    Session::put('redirect_to_active_bot_trade', 'redirect');

                    //update user demo balance
                    $new_demobalance = floatval(Auth::User()->demo_balance) - floatval($data['amount']);
                    $demobalance_updated = User::where('id', Auth::User()->id)->update(['demo_balance' => strval($new_demobalance)]);

                    $trading = tradingbot::create($tradingbotdetails);

                    $tradeEntry = Trade::create([
                        'user_id' => auth()->user()->id,
                        'bot_id' => $trading->id,
                        'total_amount_earned' => $total_amount_earned,
                        'trades' => json_encode($tradeArray)
                    ]);

                    session()->flash('success_message', 'Robot started successfully!');
                    return redirect()->intended('user/dashboard')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
                } else {
                    Session::put('active_robot_modal', 'robotsettings');
                    session()->flash('error_message', 'You are unable to trade at the moment. Please contact support to learn more.');
                    return redirect()->intended('user/dashboard')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
                }
            }

            if ($data['account'] == "live" && Auth::User()->balance >= $data['amount'] && $data['amount'] >= $plan['min_amount']) {
                if ($useractive) {
                    Session::put('active_robot_modal', 'activebottrade');
                    Session::put('redirect_to_active_bot_trade', 'redirect');
                    //update userbalance
                    $new_balance = floatval(Auth::User()->balance) - floatval($data['amount']);
                    $balance_updated = User::where('id', Auth::User()->id)->update(['balance' => strval($new_balance)]);
                    $trading = tradingbot::create($tradingbotdetails);

                    $tradeEntry = Trade::create([
                        'user_id' => auth()->user()->id,
                        'bot_id' => $trading->id,
                        'total_amount_earned' => $total_amount_earned,
                        'trades' => json_encode($tradeArray)
                    ]);

                    session()->flash('success_message', 'Robot started successfully!');
                    return redirect()->intended('user/dashboard')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
                } else {
                    Session::put('active_robot_modal', 'robotsettings');
                    session()->flash('error_message', 'You are unable to trade at the moment. Please contact support to learn more.');
                    return redirect()->intended('user/dashboard')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
                }
            }
        }

        return redirect()->intended('user/dashboard')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with(compact('tradeEntry'));
    }

    public function calculateCompanyCommission($profit)
    {
        $amountEarned = floatval($profit);
        $roundedAmountEarned = round($amountEarned, 2);
        $onePercent = 0.01 * $roundedAmountEarned;
        return round(floatval($onePercent), 2);
    }

    public function stoprobot(Request $request)
    {
        $userTradingBotId = $request->input('tradingbot_id');
        $robotStoppedAt = $request->input('robot_stopped_at');

        if (empty($userTradingBotId) || $robotStoppedAt === "") {
            session()->flash('error_message', 'Network error! Please try again.');
            return redirect()->back();
        }
        
        $this->getUserDetails();

        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();

        $tradeEntry = $this->fetchCurrentBotTrade();

        if ($request->isMethod('POST')) {
            $tradingbot = tradingbot::where('id', intval($userTradingBotId))->first()->toArray();
            $companyCommission = $this->calculateCompanyCommission($tradingbot['amount_earned']);
            if ($tradingbot['account_type'] === "live" && $tradingbot['status'] === '1') {
                try {
                    $newuserbalance = floatval(auth()->user()->balance) + round(floatval($tradingbot['amount_earned']), 2)  + floatval($tradingbot['amount']) - floatval($companyCommission);
                    Log::info('$newuserbalance');
                    DB::transaction(function () use ($newuserbalance, $userTradingBotId, $robotStoppedAt) {
                        tradingbot::where('id', intval($userTradingBotId))->update(['status' => '0']);
                        Trade::where('bot_id', intval($userTradingBotId))->update(['stopped_robot_at_position' => intval($robotStoppedAt)]);
                        $userRecord = User::where('id', auth()->user()->id)->lockForUpdate()->first();
                        if ($userRecord) {
                            $userRecord->balance = strval($newuserbalance);
                            $userRecord->save();
                        }
                    });
                } catch (\Exception $e) {
                    session()->flash('error_message', 'Network error! Please try again.');

                    if (Session::get('has_robot_modal_displayed')) {
                        Session::put('display_robot_modal', 'disabled');
                    }
                    
                    Session::put('active_robot_modal', 'robotsettings');

                    $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
                        ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
                        ->where([
                            'tradingbots.user_id' => Auth::User()->id,
                            'tradingbots.status' => '1',
                        ])
                        ->get()->toArray();

                    $tradingbotshistory = tradingbot::join('trades', 'tradingbots.id', '=', 'trades.bot_id')->select('tradingbots.*', 'trades.*')->orderBy('tradingbots.id', 'desc')->where(['tradingbots.user_id' => Auth::User()->id])->paginate(10)->toArray();
            
                    $transformedTradingBotsHistory = array_map(function ($bot) {
                        return [
                            "id" => $bot["id"],
                            "user_id" => $bot["user_id"],
                            "amount" => $bot["amount"],
                            "amount" => $bot["amount"],
                            "amount_earned" => $bot["amount_earned"],
                            "duration" => $bot["duration"],
                            "duration_start" => $bot["duration_start"],
                            "duration_end" => $bot["duration_end"],
                            "strategy_id" => $bot["strategy_id"],
                            "features" => $bot["features"],
                            "profit_limit_exceed" => $bot["profit_limit_exceed"],
                            "account_type" => $bot["account_type"],
                            "status" => $bot["status"],
                            "created_at" => $bot["created_at"],
                            "updated_at" => $bot["updated_at"],
                            "bot_id" => $bot["bot_id"],
                            "trades" => $bot["trades"],
                            "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
                        ];
                    }, $tradingbotshistory['data']);
            
                    $transformedTradingBotsHistory = array_map(function ($bot) {
                        $amountEarned = 0;
                        for ($i = 0; $i < $bot['stopped_robot_at_position']; $i++) {
                            $decodedTrades = json_decode($bot["trades"]);
                            $profit = $decodedTrades[$i]->profit;
                            $amountEarned += $profit;
                        }
                        $companyCommission = $amountEarned * 0.01;
                        $amountEarned -= $companyCommission;
                        return [
                            "id" => $bot["id"],
                            "user_id" => $bot["user_id"],
                            "amount" => $bot["amount"],
                            "amount" => $bot["amount"],
                            "amount_earned" => $bot["amount_earned"],
                            "duration" => $bot["duration"],
                            "duration_start" => $bot["duration_start"],
                            "duration_end" => $bot["duration_end"],
                            "strategy_id" => $bot["strategy_id"],
                            "features" => $bot["features"],
                            "profit_limit_exceed" => $bot["profit_limit_exceed"],
                            "account_type" => $bot["account_type"],
                            "status" => $bot["status"],
                            "created_at" => $bot["created_at"],
                            "updated_at" => $bot["updated_at"],
                            "bot_id" => $bot["bot_id"],
                            "trades" => $bot["trades"],
                            "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
                            "display_profit" => $amountEarned
                        ];
                    }, $tradingbotshistory['data']);

                    return view('user.tradingbot')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data'], 'next_page_url' => $tradingbotshistory['next_page_url'], 'prev_page_url' => $tradingbotshistory['prev_page_url']])->with(compact('tradingbots', 'tradingbotshistory', 'transformedTradingBotsHistory'))->with(compact('tradeEntry'));
                }
            } elseif ($tradingbot['account_type'] === "demo" && $tradingbot['status'] === '1') {
                try {
                    $newuserdemo_balance = floatval(auth()->user()->demo_balance) + round(floatval($tradingbot['amount_earned']), 2) + floatval($tradingbot['amount']) - floatval($companyCommission);
                    Log::info($newuserdemo_balance);
                    DB::transaction(function () use ($newuserdemo_balance, $userTradingBotId, $robotStoppedAt) {
                        tradingbot::where('id', intval($userTradingBotId))->update(['status' => 0]);
                        Trade::where('bot_id', intval($userTradingBotId))->update(['stopped_robot_at_position' => intval($robotStoppedAt)]);
                        $userRecord = User::where('id', auth()->user()->id)->lockForUpdate()->first();
                        if ($userRecord) {
                            $userRecord->demo_balance = strval($newuserdemo_balance);
                            $userRecord->save();
                        }
                    });
                } catch (\Exception $e) {
                    session()->flash('error_message', 'Network error! Please try again.');

                    if (Session::get('has_robot_modal_displayed')) {
                        Session::put('display_robot_modal', 'disabled');
                    }
                    
                    Session::put('active_robot_modal', 'robotsettings');
            
                    $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
                        ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
                        ->where([
                            'tradingbots.user_id' => Auth::User()->id,
                            'tradingbots.status' => '1',
                        ])
                        ->get()->toArray();

                    $tradingbotshistory = tradingbot::join('trades', 'tradingbots.id', '=', 'trades.bot_id')->select('tradingbots.*', 'trades.*')->orderBy('tradingbots.id', 'desc')->where(['tradingbots.user_id' => Auth::User()->id])->get()->toArray();
            
                    $transformedTradingBotsHistory = array_map(function ($bot) {
                        return [
                            "id" => $bot["id"],
                            "user_id" => $bot["user_id"],
                            "amount" => $bot["amount"],
                            "amount" => $bot["amount"],
                            "amount_earned" => $bot["amount_earned"],
                            "duration" => $bot["duration"],
                            "duration_start" => $bot["duration_start"],
                            "duration_end" => $bot["duration_end"],
                            "strategy_id" => $bot["strategy_id"],
                            "features" => $bot["features"],
                            "profit_limit_exceed" => $bot["profit_limit_exceed"],
                            "account_type" => $bot["account_type"],
                            "status" => $bot["status"],
                            "created_at" => $bot["created_at"],
                            "updated_at" => $bot["updated_at"],
                            "bot_id" => $bot["bot_id"],
                            "trades" => $bot["trades"],
                            "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
                        ];
                    }, $tradingbotshistory);
            
                    $transformedTradingBotsHistory = array_map(function ($bot) {
                        $amountEarned = 0;
                        for ($i = 0; $i < $bot['stopped_robot_at_position']; $i++) {
                            $decodedTrades = json_decode($bot["trades"]);
                            $profit = $decodedTrades[$i]->profit;
                            $amountEarned += $profit;
                        }
                        $companyCommission = $amountEarned * 0.01;
                        $amountEarned -= $companyCommission;
                        return [
                            "id" => $bot["id"],
                            "user_id" => $bot["user_id"],
                            "amount" => $bot["amount"],
                            "amount" => $bot["amount"],
                            "amount_earned" => $bot["amount_earned"],
                            "duration" => $bot["duration"],
                            "duration_start" => $bot["duration_start"],
                            "duration_end" => $bot["duration_end"],
                            "strategy_id" => $bot["strategy_id"],
                            "features" => $bot["features"],
                            "profit_limit_exceed" => $bot["profit_limit_exceed"],
                            "account_type" => $bot["account_type"],
                            "status" => $bot["status"],
                            "created_at" => $bot["created_at"],
                            "updated_at" => $bot["updated_at"],
                            "bot_id" => $bot["bot_id"],
                            "trades" => $bot["trades"],
                            "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
                            "display_profit" => $amountEarned
                        ];
                    }, $tradingbotshistory);
            
                    return view('user.tradingbot')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots', 'tradingbotshistory', 'transformedTradingBotsHistory'))->with(compact('tradeEntry'));
                }
            }
        }

        if (Session::get('has_robot_modal_displayed')) {
            Session::put('display_robot_modal', 'disabled');
        }
        
        Session::put('active_robot_modal', 'robotsettings');
        session()->flash('success_message', 'Robot has stopped trading!');

        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => 1,
            ])
            ->get()->toArray();
        $tradingbotshistory = tradingbot::join('trades', 'tradingbots.id', '=', 'trades.bot_id')->select('tradingbots.*', 'trades.*')->orderBy('tradingbots.id', 'desc')->where(['tradingbots.user_id' => Auth::User()->id])->paginate(10)->toArray();

        $transformedTradingBotsHistory = array_map(function ($bot) {
            return [
                "id" => $bot["id"],
                "user_id" => $bot["user_id"],
                "amount" => $bot["amount"],
                "amount" => $bot["amount"],
                "amount_earned" => $bot["amount_earned"],
                "duration" => $bot["duration"],
                "duration_start" => $bot["duration_start"],
                "duration_end" => $bot["duration_end"],
                "strategy_id" => $bot["strategy_id"],
                "features" => $bot["features"],
                "profit_limit_exceed" => $bot["profit_limit_exceed"],
                "account_type" => $bot["account_type"],
                "status" => $bot["status"],
                "created_at" => $bot["created_at"],
                "updated_at" => $bot["updated_at"],
                "bot_id" => $bot["bot_id"],
                "trades" => $bot["trades"],
                "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
            ];
        }, $tradingbotshistory['data']);

        $transformedTradingBotsHistory = array_map(function ($bot) {
            $amountEarned = 0;
            for ($i = 0; $i < $bot['stopped_robot_at_position']; $i++) {
                $decodedTrades = json_decode($bot["trades"]);
                $profit = $decodedTrades[$i]->profit;
                $amountEarned += $profit;
            }
            $companyCommission = $amountEarned * 0.01;
            $amountEarned -= $companyCommission;
            return [
                "id" => $bot["id"],
                "user_id" => $bot["user_id"],
                "amount" => $bot["amount"],
                "amount" => $bot["amount"],
                "amount_earned" => $bot["amount_earned"],
                "duration" => $bot["duration"],
                "duration_start" => $bot["duration_start"],
                "duration_end" => $bot["duration_end"],
                "strategy_id" => $bot["strategy_id"],
                "features" => $bot["features"],
                "profit_limit_exceed" => $bot["profit_limit_exceed"],
                "account_type" => $bot["account_type"],
                "status" => $bot["status"],
                "created_at" => $bot["created_at"],
                "updated_at" => $bot["updated_at"],
                "bot_id" => $bot["bot_id"],
                "trades" => $bot["trades"],
                "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
                "display_profit" => $amountEarned
            ];
        }, $tradingbotshistory['data']);

        return view('user.tradingbot')->with($this->getUserDetails())->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data'], 'next_page_url' => $tradingbotshistory['next_page_url'], 'prev_page_url' => $tradingbotshistory['prev_page_url']])->with(compact('tradingbots', 'tradingbotshistory', 'transformedTradingBotsHistory'))->with(compact('tradeEntry'));
    }

    public function getCurrentEarned(Request $request)
    {
        $this->getUserDetails();
        $data = $request->all();
        $tradingbot = tradingbot::where('id', $data['tradingbot_id'])->first()->toArray();
        return $tradingbot['amount_earned'];
    }

    public function disableDisplayRobotOnLoad()
    {
        Session::put('has_robot_modal_displayed', true);
        Session::put('redirect_to_active_bot_trade', '');
        return ['status' => 'success'];
    }

    public function account(Request $request)
    {
        if (Session::get('has_robot_modal_displayed') && empty(Session::get('redirect_to_active_bot_trade'))) {
            Session::put('display_robot_modal', 'disabled');
        }
        
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => 1,
            ])
            ->get()->toArray();
        $tradeEntry = $this->fetchCurrentBotTrade();
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();
        return view('user.account')->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with($this->getUserDetails())->with(compact('tradeEntry'));
    }

    public function deposit()
    {
        //page session
        Session::put('page', 'deposit');
        $details = $this->getUserDetails();
        return view('user.deposit')->with($details);
    }

    public function withdraw()
    {
        //page session
        Session::put('page', 'withdraw');
        return view('user.withdraw')->with($this->getUserDetails());
    }

    public function tradingbot(Request $request)
    {
        $tradeEntry = $this->fetchCurrentBotTrade();
        if (Session::get('has_robot_modal_displayed')) {
            Session::put('display_robot_modal', 'disabled');
        }
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => '1',
            ])
            ->get()->toArray();

        $tradingbotshistory = tradingbot::join('trades', 'tradingbots.id', '=', 'trades.bot_id')->select('tradingbots.*', 'trades.*')->orderBy('tradingbots.id', 'desc')->where(['tradingbots.user_id' => Auth::User()->id])->paginate(10)->toArray();

        $transformedTradingBotsHistory = array_map(function ($bot) {
            return [
                "id" => $bot["bot_id"],
                "user_id" => $bot["user_id"],
                "amount" => $bot["amount"],
                "amount_earned" => $bot["amount_earned"],
                "duration" => $bot["duration"],
                "duration_start" => $bot["duration_start"],
                "duration_end" => $bot["duration_end"],
                "strategy_id" => $bot["strategy_id"],
                "features" => $bot["features"],
                "profit_limit_exceed" => $bot["profit_limit_exceed"],
                "account_type" => $bot["account_type"],
                "status" => $bot["status"],
                "created_at" => $bot["created_at"],
                "updated_at" => $bot["updated_at"],
                "bot_id" => $bot["id"],
                "trades" => $bot["trades"],
                "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
            ];
        }, $tradingbotshistory['data']);

        $transformedTradingBotsHistory = array_map(function ($bot) {
            $amountEarned = 0;
            $decodedTrades = json_decode($bot["trades"]);
            for ($i = 0; $i < $bot['stopped_robot_at_position']; $i++) {
                $profit = $decodedTrades[$i]->profit;
                $amountEarned += $profit;
            }

            $companyCommission = $amountEarned * 0.01;
            $amountEarned -= $companyCommission;
            
            return [
                "id" => $bot["bot_id"],
                "user_id" => $bot["user_id"],
                "amount" => floatval($bot["amount"]),
                "amount_earned" => $bot["amount_earned"],
                "duration" => $bot["duration"],
                "duration_start" => $bot["duration_start"],
                "duration_end" => $bot["duration_end"],
                "strategy_id" => $bot["strategy_id"],
                "features" => $bot["features"],
                "profit_limit_exceed" => $bot["profit_limit_exceed"],
                "account_type" => $bot["account_type"],
                "status" => $bot["status"],
                "created_at" => $bot["created_at"],
                "updated_at" => $bot["updated_at"],
                "bot_id" => $bot["id"],
                "trades" => $bot["trades"],
                "stopped_robot_at_position" => $bot["stopped_robot_at_position"] === null ? 0 : $bot["stopped_robot_at_position"],
                "display_profit" => floatval($amountEarned)
            ];
        }, $tradingbotshistory['data']);
        
        return view('user.tradingbot')->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data'], 'next_page_url' => $tradingbotshistory['next_page_url'], 'prev_page_url' => $tradingbotshistory['prev_page_url']])->with($this->getUserDetails())->with(compact('tradingbots', 'transformedTradingBotsHistory'))->with(compact('tradeEntry'));
    }

    public function fetchBotTradeForBotId($id)
    {
        $tradingbot = tradingbot::where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ])->get()->toArray();

        if (empty($tradingbot)) {
            return [];
        }

        $tradeEntry = Trade::where('bot_id', $tradingbot[0]['id'])->get()->toArray();
        return [
            'user_id' => $tradeEntry[0]['user_id'],
            'bot_id' => $tradeEntry[0]['bot_id'],
            'trades' => json_decode($tradeEntry[0]['trades']),
            'stopped_robot_at_position' => $tradeEntry[0]['stopped_robot_at_position'],
        ];
    }

    public function fetchAllTradesUpTillCurrentPosition($id)
    {
        $currentBotTrade = $this->fetchBotTradeForBotId($id);
        $tradesArray = [];

        if(empty($currentBotTrade)) {
            return [];
        }

        if ($currentBotTrade['stopped_robot_at_position']) {
            for ($i = 0; $i < $currentBotTrade['stopped_robot_at_position']; $i++) {
                $tradesArray[] = $currentBotTrade['trades'][$i];
            }
        }

        if (is_null($currentBotTrade['stopped_robot_at_position'])) {
            for ($i = 0; $i < count($currentBotTrade['trades']); $i++) {
                $timerEndsAt = $currentBotTrade['trades'][$i]->timer_ends_at;
                $tradesArray[] = $currentBotTrade['trades'][$i];
                $now = Carbon::now()->valueOf();
                if ($now <= $timerEndsAt) {
                    array_pop($tradesArray);
                    break;
                }
                continue;
            }
        }

        return $tradesArray;
    }

    public function showTradingBotDetails($id) {
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => 1,
            ])
            ->get()->toArray();
        $selectedBotAccountType = tradingbot::where('id', $id)->pluck('account_type');
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();
        $tradeEntry = $this->fetchCurrentBotTrade();
        $trades = $this->fetchAllTradesUpTillCurrentPosition(intval($id));
        $reversedTradesArray = array_reverse($trades);
        $details = $this->getUserDetails();
        return view('user.history')->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots'))->with($details)->with(['trades' => $reversedTradesArray])->with(compact('tradeEntry'))->with(compact('selectedBotAccountType'));
    }
}
