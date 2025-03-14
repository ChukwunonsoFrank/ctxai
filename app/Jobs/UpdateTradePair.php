<?php

namespace App\Jobs;

use App\Models\Trade;
use App\Models\tradingbot;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTradePair implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function generateTrades() {
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

        $tradesArray = [];

        if (Carbon::now()->isWeekday()) {
            $randomval = mt_rand(0, 2);
            if ($randomval === 0) {
                $randomCryptoAsset = rand(0, count($cryptoTradingPair) - 1);
                array_push($tradesArray, [
                    'asset_name' => $cryptoTradingPair[$randomCryptoAsset]['symbol'],
                    'asset_display_name' => $cryptoTradingPair[$randomCryptoAsset]['name'],
                    'percentage' => $cryptoTradingPair[$randomCryptoAsset]['percentage'],
                    'image_url' => "/images/coins/" . $cryptoTradingPair[$randomCryptoAsset]['image'],
                    'type' => 'coin'
                ]);
            } else {
                $randomForexAsset = rand(0, count($forexTradingPair) - 1);
                array_push($tradesArray, [
                    'asset_name' => $forexTradingPair[$randomForexAsset]['symbol'],
                    'asset_display_name' => $forexTradingPair[$randomForexAsset]['name'],
                    'percentage' => $forexTradingPair[$randomForexAsset]['percentage'],
                    'image_url' => "/images/coins/" . $forexTradingPair[$randomForexAsset]['image'],
                    'type' => 'currency'
                ]);
            }
        } else {
            $randomCryptoAsset = rand(0, count($cryptoTradingPair) - 1);
            array_push($tradesArray, [
                'asset_name' => $cryptoTradingPair[$randomCryptoAsset]['symbol'],
                'asset_display_name' => $cryptoTradingPair[$randomCryptoAsset]['name'],
                'percentage' => $cryptoTradingPair[$randomCryptoAsset]['percentage'],
                'image_url' => "/images/coins/" . $cryptoTradingPair[$randomCryptoAsset]['image'],
                'type' => 'coin'
            ]);
        }
        return $tradesArray;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $activeBots = tradingbot::where(['status' => '1'])->get()->toArray();
        foreach($activeBots as $bot) {
            $trade = Trade::where('bot_id', $bot['id'])->get()->toArray();
            $decodedTrade = json_decode($trade[0]['trades']);
            foreach ($decodedTrade as $dcd) {
                $updatedTrades = $this->generateTrades();
                $dcd->asset_name = $updatedTrades[0]['asset_name'];
                $dcd->asset_display_name = $updatedTrades[0]['asset_display_name'];
                $dcd->percentage = $updatedTrades[0]['percentage'];
                $dcd->image_url = $updatedTrades[0]['image_url'];
                $dcd->type = $updatedTrades[0]['type'];
            }
            $encodedTrade = json_encode($decodedTrade);
            Trade::where('bot_id', $bot['id'])->update(['trades' => $encodedTrade]);
        }
    }
}
