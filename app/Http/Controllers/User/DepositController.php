<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\deposit;
use App\Models\Coins;
use App\Models\User;
use App\Models\tradingbot;
use App\Models\plans;

use App\Mail\DepositMail;
use App\Models\Trade;
use Illuminate\Support\Facades\Mail;


class DepositController extends Controller
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
                    for ($i = 0; $i < $botTrade[0]['stopped_robot_at_position']; $i++) {
                        $decodedTrades = json_decode($botTrade[0]['trades']);
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
                    // generate a random profit number from 
                    $profitrange = range($min_roi, $max_roi, 0.15);
                    $randomprofit = $profitrange[array_rand($profitrange)];
                    $random_amount_earned = ($randomprofit / 100) * $amount;
                    $companyCommission = $this->calculateCompanyCommission($random_amount_earned);

                    // update amount earned in the trading bot
                    $demobalance_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => $random_amount_earned, 'status' => 0]);
                    $trade_updated = Trade::where('bot_id', $tradingbot_id)->update(['stopped_robot_at_position' => 287]);
                    if ($trading_type == "live") {
                        $newuser_balance = Auth::User()->balance + (round($random_amount_earned, 2) - $companyCommission) + $amount;
                        $balance_updated = User::where('id', Auth::User()->id)->update(['balance' => $newuser_balance]);
                    } else {
                        $newuserdemo_balance = Auth::User()->demo_balance + (round($random_amount_earned, 2) - $companyCommission) + $amount;
                        $demobalance_updated = User::where('id', Auth::User()->id)->update(['demo_balance' => $newuserdemo_balance]);
                    }
                } else {
                    // update amount earned in the trading bot
                    //get max roi amount 
                    $max_amount_earned = ($max_roi / 100) * $amount;
                    $final_amount_earned =  $amount_earned;

                    if ($final_amount_earned > $max_amount_earned) {
                        //update tradingbot with max amount earnable
                        $tradingbot_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => $max_amount_earned, 'status' => 2]);
                        $companyCommission = $this->calculateCompanyCommission($max_amount_earned);
                        if ($trading_type == "live") {
                            $newuser_balance = Auth::User()->balance + (round($max_amount_earned, 2) - $companyCommission) + $amount;
                            $balance_updated = User::where('id', Auth::User()->id)->update(['balance' => $newuser_balance]);
                        } else {
                            $newuserdemo_balance = Auth::User()->demo_balance + (round($max_amount_earned, 2) - $companyCommission) + $amount;
                            $demobalance_updated = User::where('id', Auth::User()->id)->update(['demo_balance' => $newuserdemo_balance]);
                        }
                    } else {
                        //if amount earned not exceeded just update the trading bots 
                        $tradingbot_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => $final_amount_earned]);
                    }
                }
            } else {
                //profit will not exceed
                $amount_earned = 0;

                $botTrade = Trade::where('bot_id', $tradingbot_id)->get()->toArray();

                if($botTrade[0]['stopped_robot_at_position']) {
                    for ($i = 0; $i < $botTrade[0]['stopped_robot_at_position']; $i++) {
                        $decodedTrades = json_decode($botTrade[0]['trades']);
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
                    //generate a random profit number from 
                    $profitrange = range($min_roi, $max_roi, 0.15);
                    $randomprofit = $profitrange[array_rand($profitrange)];
                    $random_amount_earned = ($randomprofit / 100) * $amount;
                    $companyCommission = $this->calculateCompanyCommission($random_amount_earned);

                    //update amount earned in the trading bot
                    $demobalance_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => $random_amount_earned, 'status' => 0]);
                    $trade_updated = Trade::where('bot_id', $tradingbot_id)->update(['stopped_robot_at_position' => 287]);
                    if ($trading_type == "live") {
                        $newuser_balance = Auth::User()->balance + (round($random_amount_earned, 2) - $companyCommission) + $amount;
                        $balance_updated = User::where('id', Auth::User()->id)->update(['balance' => $newuser_balance]);
                    } else {
                        $newuserdemo_balance = Auth::User()->demo_balance + (round($random_amount_earned, 2) - $companyCommission) + $amount;
                        $demobalance_updated = User::where('id', Auth::User()->id)->update(['demo_balance' => $newuserdemo_balance]);
                    }
                } else {
                    //update amount earned in the trading bot

                    //get max roi amount 
                    $max_amount_earned = ($max_roi / 100) * $amount;
                    $final_amount_earned =  $amount_earned;

                    if ($final_amount_earned > $max_amount_earned) {

                        //update tradingbot with max amount earnable
                        $tradingbot_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => $max_amount_earned, 'status' => 2]);
                        $companyCommission = $this->calculateCompanyCommission($max_amount_earned);
                        if ($trading_type == "live") {

                            $newuser_balance = Auth::User()->balance + (round($max_amount_earned, 2) - $companyCommission) + $amount;
                            $balance_updated = User::where('id', Auth::User()->id)->update(['balance' => $newuser_balance]);
                        } else {
                            $newuserdemo_balance = Auth::User()->demo_balance + (round($max_amount_earned, 2) - $companyCommission) + $amount;
                            $demobalance_updated = User::where('id', Auth::User()->id)->update(['demo_balance' => $newuserdemo_balance]);
                        }
                    } else {

                        //if amount earned not exceeded just update the trading bots 
                        $tradingbot_updated = tradingbot::where('id', $tradingbot_id)->update(['amount_earned' => $final_amount_earned]);
                    }
                }
            }
        }

        $user = User::where('id', Auth::User()->id)->first()->toArray();

        return compact('user', 'wallets', 'plans');
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
                "symbol" => "NASDAQ"
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

    public function deposit(Request $request){
        $data = $request->all();
        $details = $this->getUserDetails();
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();
        $plans = plans::query()->orderBy('order', 'asc')->get()->toArray();
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => '1',
            ])
            ->get()->toArray();

        if($request->isMethod('POST')){      
            $datecreated =  date("d-m-Y");
            $depositdetails = [
                'user_id'=> Auth::User()->id,
                'gateway'=> $data['wallet'],
                'amount'=> $data['amount'],
                'deposit_status'=> '0',
            ];
            $deposited = deposit::create($depositdetails);

            if($deposited){
                //mail user 
                //email subscription user
                $mailData = [
                    'title' => 'Deposit Request',
                    'body' => '
                    <div style="text-align: center; margin-bottom: 8px;">
                        <h1 style="color: #19282b; font-size: 20px; line-height: 28.8px;">Transaction Notification</h1>
                    </div>
                    <div style="text-align: left;">
                        <p>Your Deposit of <b>$'.$data['amount'].'</b> has been recieved and will be confirmed shortly</p>
                        <p><strong>Note</strong></p>
                    <ul>
                        <li>Make sure you have sent the said amount to the wallet provided in the dashboard.</li>
                        <li>Wait to confirm your deposit has been confirmed in the blockchain.</li>
                    </ul>
                    </div>
                    ',
                    'username'=> Auth::User()->username
                ];
                Mail::to(Auth::User()->email)->send(new DepositMail($mailData));

                //email admin
                $mailData = [
                    'title' => 'New Deposit Request',
                    'body' => '
                    <div style="text-align: center; margin-bottom: 8px;">
                        <h1 style="color: #19282b; font-size: 20px; line-height: 28.8px;">Admin Notification</h1>
                    </div>
                    <div style="text-align: left;">
                        <p>'.Auth::User()->username.' has made a deposit of  <b>$'.$data['amount'].'</b>. Login to the dashboard to confirm this action. </p>
                    </div>
                    ',
                    'username'=> "Admin"
                ];
                Mail::to(env('ADMIN_EMAIL'))->send(new DepositMail($mailData));
                session()->flash('success_message', 'Your Deposit Request has been made successfully, Your Live account will be updated when payment is confirmed.');

                return redirect()->intended('user/deposits')->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('tradingbots', 'plans'));
            }
            
        }
        $user = User::where('id', Auth::User()->id)->first()->toArray();
        
        $wallets = Coins::query()->get()->toArray();

        $deposits = deposit::where('user_id',Auth::User()->id)->orderBy('id','desc')->get()->toArray();
        return view('user.deposit')->with(compact('deposits'))->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('user','wallets','tradingbots','plans'));
    }

    public function deposits(){
        $details = $this->getUserDetails();
        $trading_and_selected_asset_data = $this->getTradingAndSelectedAssetData();
        $plans = plans::query()->orderBy('order', 'asc')->get()->toArray();
        $user = User::where('id', Auth::User()->id)->first()->toArray();

        if (Session::get('has_robot_modal_displayed') && empty(Session::get('redirect_to_active_bot_trade'))) {
            Session::put('display_robot_modal', 'disabled');
        }
        
        $tradingbots = tradingbot::join('plans', 'tradingbots.strategy_id', '=', 'plans.id')
            ->select('plans.*', 'tradingbots.*')->orderBy('tradingbots.id', 'desc')
            ->where([
                'tradingbots.user_id' => Auth::User()->id,
                'tradingbots.status' => '1',
            ])
            ->get()->toArray();
        
        $wallets = Coins::query()->get()->toArray();
        $tradeEntry = $this->fetchCurrentBotTrade();
        $deposits = deposit::where('user_id', Auth::User()->id)->where('gateway', '!=', 'Bonus')->where('gateway', '!=', 'ReferralBonus')->orderBy('id','desc')->get()->toArray();
        return view('user.deposit')->with(compact('deposits'))->with(['trading_pair_data' => $trading_and_selected_asset_data['trading_pair_data'], 'selected_asset_data' => $trading_and_selected_asset_data['selected_asset_data']])->with(compact('user', 'wallets', 'tradingbots', 'plans'))->with(compact('tradeEntry'));
    }

    public function getwallet(Request $request){

        $data = $request->all();
        
        if($wallet = Coins::where('coin_name',$data['wallet'])->first()->toArray()){
            return $wallet;
            // return Response::json($wallet);
        }


    }
}
