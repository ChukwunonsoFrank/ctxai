@extends('user.layout.layout')

@section('content')

    @forelse ($tradingbots as $tradingbot)
        <section class="robot-trading mx-3">
            <div class="container bg-custom rounded-4 px-4 py-4">
                <div class="row ">
                    <div class="col-12 my-3">
                        <h1 class="text-white fs-3">Active Robot</h1>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12 d-flex flex-column">
                        <div class="robot-details-top d-flex flex-row justify-content-between text-white align-items-center">
                            <div class="robot-details-top__left">
                                <h2 id="total_amount"></h2>
                                <p id="profit"></p>
                            </div>
                            <div class="robot-details-top__right">
                                <h3 class="text-secondary fs-5">{{ ucfirst($tradingbot['account_type']) }} Account</h3>
                            </div>
                        </div>
                        <div class="robot-timer">
                            <div id="timer_loading" class="spinner d-flex flex-row align-items-center my-2">
                                <div class="loading_timer">
                                    <img src="/homeassets/img/loader.gif" width="100%" alt="">
                                </div>
                                <div class="d-flex flex-column px-2">
                                    <h6 class="text-secondary">Robot is now</h6>
                                    <h6 class="text-secondary"><i class="bi bi-search"></i> <span
                                            class="text-white">Searching for a signal...</span></h6>
                                </div>
                            </div>

                            <div id="timer_counter" class="timer_cover d-flex flex-row align-items-center my-2">
                                <div class="timer_counter">
                                    <div class="timer">
                                        <div class="donat outer-circle">
                                            <p class="clock-time clock-timer mb-0"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column px-2">
                                    <h6 class="text-secondary">Robot is now trading</h6>
                                    <h6 class="text-secondary"><img id="trading_image" width="25px"
                                            src="https://olympbot.com/icons/assets/EURUSD_OTC.svg" alt=""> <span
                                            class="text-white" id="trading_asset">Asia Composite In...</span><span
                                            id="trading_percentage" class="text-primary">93%</span></h6>
                                </div>
                            </div>

                        </div>
                        <div class="robot-details-bottom d-flex flex-column text-white">
                            <div class="robot-details-bottom__item d-flex flex-row justify-content-between">
                                <h5><i class="bi bi-arrow-down-right-square-fill"></i> Amount</h5>
                                <h5>@money($tradingbot['amount'])</h5>
                            </div>
                            <hr class="mx-0">
                            <div class="robot-details-bottom__item d-flex flex-row justify-content-between ">
                                <h5><i class="bi bi-robot"></i> strategy</h5>
                                <h5>{{ $tradingbot['name'] }}</h5>
                            </div>
                            <hr>
                            <div class="robot-details-bottom__item d-flex flex-row justify-content-between ">
                                <h5><i class="bi bi-sign-stop"></i> Profit Limit</h5>
                                <h5>{{ $tradingbot['max_roi_percentage'] }}%</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="tradingbot_id" id="tradingbot_id" value="{{ $tradingbot['id'] }}">
                    <div class="col-lg-6 py-3">
                        <input type="submit" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                            class="form-control form-control-lg px-0 btn btn-primary btn-lg" value="Stop Robot" required
                            aria-label="amount">
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered text-white">
                <div class="modal-content bg-custom">
                    <div class="modal-header border-bottom-0">

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <i class="bi bi-robot fs-1"></i>
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure you want to stop robot at
                                <span id="stop_profit">@money($tradingbot['amount_earned'])</span> Profit</h1>
                        </center>


                        <form method="post" action="{{ url('/user/stoprobot') }}">
                            @CSrf
                            <input type="hidden" name="tradingbot_id" value="{{ $tradingbot['id'] }}">
                            <div class="col-lg-12 py-3">
                                <input type="submit"
                                    style="background-color:#DC3444!important;"class="btn btn-danger form-control form-control-lg px-0  btn-lg"
                                    value="Stop Robot" required aria-label="amount">
                        </form>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn w-100 btn-primary btn-lg my-2">Continue </button>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <section class="robot-form bg-form">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-white fs-3">Robot Setup</h1>
                    </div>
                </div>
                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom:0px!important;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('robot_error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('robot_error') }}
                        </div>
                    @endif
                    <div class="col-lg-8">
                        <form action="{{ url('/user/robot') }}" method="post" class="text-white">@CSrf
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label for="amount" class="form-label">Trade Amount</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                        <input type="number" pattern="[0-9]*" inputmode="numeric" name="amount"
                                            class="form-control form-control-lg px-0" placeholder="Amount" required
                                            aria-label="amount">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="amount" class="form-label">Profit Accumulated
                                        <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="Robot makes profit every 5 minutes"></i></label>
                                    <select class="form-select form-select-lg mb-3" name="duration"
                                        aria-label="Large select example">
                                        <!-- <option value="1">1 Min</option> -->
                                        <option value="5">Every 5 Min</option>
                                    </select>
                                </div>
                                <!-- <div class="col-12">
                                <h4>Risk Management</h4>
                            </div> -->
                                <div class="col-lg-6 col-12">
                                    <input type="hidden" name="strategy_id" id="strategy">
                                    <label for="amount" class="form-label">Select Strategy</label>
                                    <div class="strategy-card d-flex flex-row gap-3 rounded p-2 align-items-center"
                                        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight2"
                                        aria-controls="offcanvasRight">
                                        <img id="strategy-image" class="rounded " id="strategy_image" src=""
                                            alt="">
                                        <div class="strategy-card__content">
                                            <h4><span id="strategy_name"></span> <i
                                                    class="bi bi-chevron-down float-end"></i></h4>
                                            <h6><i class="bi bi-arrows"></i> <span id="strategy_risk_type"></span></h6>
                                            <h6 class="mb-0"><i class="bi bi-cash-coin"></i> Min Amount: at least <span
                                                    id="strategy_min"></span></h6>
                                        </div>
                                    </div>

                                    <div class="account offcanvas offcanvas-end bg-custom-dark" tabindex="-1"
                                        id="offcanvasRight2" aria-labelledby="offcanvasRightLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title text-white" id="offcanvasRightLabel">Select
                                                Strategy</h5>
                                            <button type="button" class="btn-close bg-text-white"
                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="account offcanvas-body bg-custom-dark">
                                            <div class="row gy-3">
                                                @php($i = 0)
                                                @forelse ($plans as $plan)
                                                    @php($i++)
                                                    <div class="col-12 text-white" role="button"
                                                        id="strategy_btn0{{ $i }}"
                                                        strategy_data="{{ $i }}">
                                                        <div
                                                            class="strategy-card d-flex flex-row gap-3 rounded p-2 align-items-center">
                                                            <img id="strategy-image" class="rounded "
                                                                src="/images/plans/{{ $plan['image'] }}" alt="">
                                                            <div class="strategy-card__content">
                                                                <h4>{{ $plan['name'] }} <i
                                                                        class="bi bi-chevron-right float-end"></i></h4>
                                                                <h6><i class="bi bi-arrows"></i> Profit range:
                                                                    {{ $plan['min_roi_percentage'] }}% to
                                                                    {{ $plan['max_roi_percentage'] }}% in
                                                                    {{ $plan['plan_duration'] }} hours</h6>

                                                                <h6 class="mb-0"><i class="bi bi-cash-coin"></i> Min
                                                                    Amount: at least <span
                                                                        id="strategy_min">@money($plan['min_amount'])</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @empty
                                                    <div class="alert alert-danger" role="alert"> No data found</div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="amount" class="form-label">Profit Return </label>
                                    <div class="strategy-card d-flex flex-row gap-3 rounded p-2 align-items-center">
                                        <img id="strategy-image" class="rounded " id="strategy_image"
                                            src="/homeassets/img/timerimage.png" alt="">
                                        <div class="strategy-card__content">
                                            <h4>Profit Accumulated</h4>
                                            <h6><i class="bi bi-alarm"></i> Every 5 minutes </h6>
                                            <h6><i class="bi bi-wallet-fill"></i> Capital Returned After Trade - Yes</h6>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 py-3">
                                    <input type="submit"
                                        class="form-control form-control-lg px-0 btn btn-primary btn-lg single-submit"
                                        value="Start Robot" required aria-label="amount">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3 pb-5 gy-2">
                    <div class="col-lg-6 col-12 pb-5">
                        <a href="#" class="text-decoration-none" type="button" data-bs-toggle="modal"
                            data-bs-target="#Notice">
                            <div
                                class="funds-details d-flex flex-row gap-3 py-3 align-items-center justify-content-between text-bg-danger rounded text-white px-3 fs-6">
                                <div class="funds-details__left d-flex flex-row align-items-center gap-2">
                                    <i class="bi bi-info-circle"></i>
                                    <h6 class="mb-0">How it works?</h6>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
        </section>
    @endforelse

    <div class="modal fade" id="Notice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered text-white">
            <div class="modal-content bg-custom">
                <div class="modal-header border-bottom-0">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <i class="bi bi-info-circle fs-1"></i>
                        <h1 class="modal-title fs-1" id="staticBackdropLabel"><b>How it works?</b> </h1>
                    </center>

                    <br>

                    <h6>Below are steps on how you can use the Ctxai robot and make profits.</h6>

                    <h2><b>How to start the robot?</b></h4>
                        <p>
                            Step 1: Input a trade amount.</br>
                            Step 2: Select a strategy, strategy depends on your trade amount, select the strategy that
                            matches your trade amount.</br>
                            Step 3: You’re set! Click on start robot, the robot trades for you and accumulates profits every
                            5 minutes.

                        </p>

                        <h2><b>Important things to take note!</b></h2>

                        <p>
                            1.⁠ ⁠Your capital is always returned after every trade.</br>
                            2.⁠ ⁠You can choose to stop the robot anytime.</br>
                            3.⁠ ⁠The robot accumulates profits every 5 minutes.</br>
                            4.⁠ ⁠You don’t have to do anything after starting the robot,the robot automatically trades and
                            generates profits for you every 5 minutes until it reach its profit limit.</br>
                            5.⁠ ⁠There is Live and Demo accounts, if you are ready to make real profits you can make
                            deposits to your live account and use the robot.</br>
                            </br>
                            You can always contact us if you need further assistance using the Ctxai bot.

                        </p>


                </div>

            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        var tradingbot_id = $("#tradingbot_id").val();
        var dollarUSLocale = Intl.NumberFormat('en-US');

        function getamount_earned() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/user/check-current-earned',
                data: {
                    tradingbot_id: tradingbot_id
                },
                success: function(resp) {
                    $("#profit").html("Profit made:<span class='text-success'> $" + dollarUSLocale.format(
                        Number(resp)) + "</span>");
                    $("#stop_profit").html("$" + dollarUSLocale.format(Number(resp)));
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        }
    </script>

    <script src="/homeassets/js/timer.js"></script>

    <!-- tradding assets data -->
    <script>
        //getting random numbers
        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
        }

        const tradingpairweekend = [{
                "name": "ETH/USDT",
                "percentage": "95%",
                "image": "eth.png"
            },
            {
                "name": "BTC/USDT",
                "percentage": "91%",
                "image": "btc.png"
            },
            {
                "name": "LTC/USDT",
                "percentage": "95%",
                "image": "ltc.png"
            },
            {
                "name": "SOL/USDT",
                "percentage": "98%",
                "image": "sol.png"
            },
            {
                "name": "XRP/USDT",
                "percentage": "93%",
                "image": "xrp.png"
            },
            {
                "name": "DOGE/USDT",
                "percentage": "83%",
                "image": "doge.png"
            },
            {
                "name": "BCH/USDT",
                "percentage": "89%",
                "image": "bch.png"
            },
            {
                "name": "DAI/USDT",
                "percentage": "97%",
                "image": "dai.png"
            },
            {
                "name": "BNB/USDT",
                "percentage": "87%",
                "image": "bnb.png"
            },
            {
                "name": "ADA/USDT",
                "percentage": "93%",
                "image": "ada.png"
            },
            {
                "name": "AVAX/USDT",
                "percentage": "99%",
                "image": "avax.png"
            },
            {
                "name": "TRX/USDT",
                "percentage": "90%",
                "image": "trx.png"
            },
            {
                "name": "MATIC/USDT",
                "percentage": "91%",
                "image": "matic.png"
            },
            {
                "name": "ATOM/USDT",
                "percentage": "96%",
                "image": "atom.png"
            },
            {
                "name": "LINK/USDT",
                "percentage": "87%",
                "image": "link.png"
            },
            {
                "name": "DASH/USDT",
                "percentage": "87%",
                "image": "dash.png"
            },
            {
                "name": "XLM/USDT",
                "percentage": "93%",
                "image": "xlm.png"
            },
            {
                "name": "NEO/USDT",
                "percentage": "93%",
                "image": "neo.png"
            },
            {
                "name": "Basic Altcoin index",
                "percentage": "88%",
                "image": "ALTCOIN.svg"
            },
            {
                "name": "BAT/USDT",
                "percentage": "83%",
                "image": "bat.png"
            },
            {
                "name": "ETC/USDT",
                "percentage": "98%",
                "image": "etc.png"
            },
            {
                "name": "ETC/USDT",
                "percentage": "86%",
                "image": "etc.png"
            },
            {
                "name": "ZEC/USDT",
                "percentage": "94%",
                "image": "zec.png"
            },
            {
                "name": "ONT/USDT",
                "percentage": "96%",
                "image": "ont.png"
            },
            {
                "name": "STX/USDT",
                "percentage": "96%",
                "image": "stx.png"
            },
            {
                "name": "MKR/USDT",
                "percentage": "95%",
                "image": "mkr.png"
            },
            {
                "name": "AAVE/USDT",
                "percentage": "90%",
                "image": "aave.png"
            },
            {
                "name": "AAVE/USDT",
                "percentage": "90%",
                "image": "aave.png"
            },
            {
                "name": "XMR/USDT",
                "percentage": "99%",
                "image": "xmr.png"
            },
            {
                "name": "YFI/USDT",
                "percentage": "95%",
                "image": "yfi.png"
            }
        ];

        const tradingpair = [{
                "name": "Asia Composit Index",
                "percentage": "93%",
                "image": "ASIA_X.svg"
            },
            {
                "name": "Europe Composite Index",
                "percentage": "92%",
                "image": "EUROPE_X.svg"
            },
            {
                "name": "Commodity Composite Index",
                "percentage": "91%",
                "image": "ASIA_X.svg"
            },
            {
                "name": "Gold",
                "percentage": "89%",
                "image": "XAUUSD.svg"
            },
            {
                "name": "EUR/USD",
                "percentage": "99%",
                "image": "EURUSD_OTC.svg"
            },
            {
                "name": "AUD/CAD",
                "percentage": "96%",
                "image": "AUDCAD.svg"
            },
            {
                "name": "RUSSELL 2000",
                "percentage": "89%",
                "image": "TF.svg"
            },
            {
                "name": "GBP/USD",
                "percentage": "85%",
                "image": "GBPUSD_OTC.svg"
            },
            {
                "name": "GBP/NZD",
                "percentage": "89%",
                "image": "GBPNZD.svg"
            },
            {
                "name": "USD/JPY",
                "percentage": "97%",
                "image": "USDJPY_OTC.svg"
            },
            {
                "name": "EUR/GBP",
                "percentage": "95%",
                "image": "EURGBP.svg"
            },
            {
                "name": "GBP/CHF",
                "percentage": "90%",
                "image": "GBPCHF.svg"
            },
            {
                "name": "GBP/CAD",
                "percentage": "88%",
                "image": "GBPCAD.svg"
            },
            {
                "name": "NASDAQ",
                "percentage": "92%",
                "image": "NQ.svg"
            },
            {
                "name": "CAC 40",
                "percentage": "94%",
                "image": "FCE.svg"
            },
            {
                "name": "Copper",
                "percentage": "86%",
                "image": "HG.svg"
            },
            {
                "name": "FTSE 100",
                "percentage": "96%",
                "image": "Z.svg"
            },
            {
                "name": "AUD/JPY",
                "percentage": "93%",
                "image": "AUDJPY.svg"
            },
            {
                "name": "CAD/CHF",
                "percentage": "77%",
                "image": "CADCHF.svg"
            },
            {
                "name": "CAD/JPY",
                "percentage": "85%",
                "image": "CADJPY.svg"
            },
            {
                "name": "EUR/AUD",
                "percentage": "97%",
                "image": "EURAUD.svg"
            },
            {
                "name": "EUR/JPY",
                "percentage": "91%",
                "image": "EURJPY.svg"
            },
            {
                "name": "EUR/CAD",
                "percentage": "99%",
                "image": "EURCAD.svg"
            },
            {
                "name": "GPB/JPY",
                "percentage": "83%",
                "image": "GBPJPY.svg"
            },
            {
                "name": "NZD/CAD",
                "percentage": "90%",
                "image": "NZDCAD.svg"
            },
            {
                "name": "NZD/CHF",
                "percentage": "98%",
                "image": "NZDCHF.svg"
            },
            {
                "name": "NZD/JPY",
                "percentage": "95%",
                "image": "NZDJPY.svg"
            },
            {
                "name": "USD/MXN",
                "percentage": "95%",
                "image": "USDMXN.svg"
            },
            {
                "name": "USD/SGD",
                "percentage": "98%",
                "image": "USDSGD.svg"
            },
            {
                "name": "NZD/USD",
                "percentage": "96%",
                "image": "NZDUSD_OTC.svg"
            },
            {
                "name": "USD/CHF",
                "percentage": "91%",
                "image": "USDCHF_OTC.svg"
            },
            {
                "name": "USD/CHF",
                "percentage": "96%",
                "image": "USDCHF_OTC.svg"
            },
            {
                "name": "AUD/CHF",
                "percentage": "96%",
                "image": "AUDCHF.svg"
            },
            {
                "name": "CHF/JPY",
                "percentage": "99%",
                "image": "CHFJPY.svg"
            }

        ];
        const count = tradingpair.length; // 6
        const countweekend = tradingpairweekend.length; // 6

        const is_Weekday = (d = new Date()) => d.getDay() % 6 !== 0;


        if (is_Weekday()) {
            var randomval = getRandomInt(0, 2);
            console.log(randomval);
            if (randomval == 0) {
                var randomasset = getRandomInt(0, count);
                var trading_img_url = "https://olympbot.com/icons/assets/" + tradingpair[randomasset].image;
                var trading_name = tradingpair[randomasset].name;
                var trading_percentage = tradingpair[randomasset].percentage;

            } else {
                var randomasset = getRandomInt(0, countweekend);
                var trading_img_url = "/images/coins/" + tradingpairweekend[randomasset].image;
                var trading_name = tradingpairweekend[randomasset].name;
                var trading_percentage = tradingpairweekend[randomasset].percentage;
            }

        } else {
            var randomasset = getRandomInt(0, countweekend);
            var trading_img_url = "/images/coins/" + tradingpairweekend[randomasset].image;
            var trading_name = tradingpairweekend[randomasset].name;
            var trading_percentage = tradingpairweekend[randomasset].percentage;
        }
    </script>f

    <script>
        //Trading magic
        @forelse ($tradingbots as $tradingbot)
            var tradingbot = @json($tradingbot);
            var timerval = Number(tradingbot.duration);

            //set details for timer
            var distance_minutes = timerval,
                distance,
                time_left,
                animation_id = null;

            //create profit and loss rang
            var returns = [];
            var profits = Array((Number(tradingbot.max_roi_percentage)) + 1).fill().map((element, index) => index + 0);

            function sequence(len, max) {
                return Array.from({
                    length: len
                }, (v, k) => (k * max / (len - 1)).toFixed(2));
            }

            var profitsequence = sequence(15, 0.99);
            var profitsequencecount = profitsequence.length;
            var profitscount = profits.length;

            function setdefaultbalance() {
                var dollarUSLocale = Intl.NumberFormat('en-US');
                $("#total_amount").html("$" + dollarUSLocale.format(Number(tradingbot.amount)));

                amount_earned = parseFloat(tradingbot.amount_earned).toFixed(2);
                $("#profit").html("Profit made:<span class='text-success'> $" + dollarUSLocale.format(amount_earned) +
                    "</span>");
            }

            //
            function balancemagic() {
                var dollarUSLocale = Intl.NumberFormat('en-US');
                //generate random profit
                var randomprofit = getRandomInt(0, profitscount);
                var randomroi = getRandomInt(0, 2);
                var randomsequence = getRandomInt(0, profitsequencecount);
                // console.log(randomroi);

                //magic to update the trade value
                // if(randomroi == 1){
                //     //send profit and display
                //     var profitpercent = Number(profits[randomprofit]);
                //     profitpercent = Number(profitpercent) + Number(profitsequence[randomsequence]);
                //     if(profitpercent > tradingbot.max_roi_percentage){
                //         profitpercent = tradingbot.max_roi_percentage;
                //     }
                //     // console.log(profitpercent);
                //     var amountearned = ((profitpercent / 100)*Number(tradingbot.amount)) ;
                //     var totalamount = amountearned  + Number(tradingbot.amount);
                //     $("#total_amount").html("$"+ dollarUSLocale.format(Number(totalamount)));
                //     $("#profit").html("<span class='text-success'> $"+ dollarUSLocale.format(Number(amountearned)) + "</span>");
                // }else{
                //     //send loss and display
                //     //send profit and display
                //     var profitpercent = Number(profits[randomprofit]);
                //     profitpercent = Number(profitpercent) + Number(profitsequence[randomsequence]);
                //     if(profitpercent > tradingbot.max_roi_percentage){
                //         profitpercent = tradingbot.max_roi_percentage;
                //     }
                //     // console.log(profitpercent);
                //     var amountearned = ((profitpercent / 100)*Number(tradingbot.amount)) ;
                //     var totalamount = Number(tradingbot.amount) - amountearned;
                //     $("#total_amount").html("$"+ dollarUSLocale.format(Number(totalamount)));
                //     $("#profit").html("<span class='text-danger'> $"+ dollarUSLocale.format(Number(amountearned))+ "</span>");
                // }
            }

            var counterstatus = 0;

            function startcounting() {
                var randomsec = getRandomInt(8, 20) * 1000;
                var myInterval;
                setTimeout(function() {
                    $("#timer_loading").toggleClass("d-none");
                    $("#timer_counter").toggleClass("d-none");

                    $("#trading_image").attr("src", trading_img_url);
                    $("#trading_asset").html(trading_name);
                    $("#trading_percentage").html(trading_percentage);
                    var dt = new Date();
                    distance = dt.setMinutes(dt.getMinutes() + distance_minutes);
                    process_timer(distance);

                    counterstatus = 1;
                    //start performing counter magic
                    myInterval = setInterval(balancemagic, 1800);
                }, randomsec);

                //start performing counter magic

                setInterval(function() {
                    if (counterstatus == 0) {
                        clearInterval(myInterval);
                    }
                }, 1000);
            }

            $("#timer_counter").toggleClass("d-none");
            //ondocument ready
            $(document).ready(function() {
                //hide all at first 
                setdefaultbalance();
                startcounting();
            });
        @empty
        @endforelse

        const bsOffcanvas = new bootstrap.Offcanvas('#offcanvasRight2');
        var plans = @json($plans);
        $img_url = "/images/plans/" + plans[0].image;
        $("#strategy").val(plans[0].id);

        //filling the strategy first card seen
        $("#strategy-image").attr("src", $img_url);
        $("#strategy_name").html(plans[0].name);
        $("#strategy_risk_type").html("Profit range: " + plans[0].min_roi_percentage + "% to " + plans[0]
            .max_roi_percentage + "% in " + plans[0].plan_duration + " hours");
        $("#strategy_min").html("$" + plans[0].min_amount);

        $("[id^=strategy_btn]").each(function() {
            $(this).click(function() {
                newindex = $(this).attr('strategy_data') - 1;
                $img_url = "/images/plans/" + plans[newindex].image;
                $("#strategy").val(plans[newindex].id);
                $("#strategy-image").attr("src", $img_url);
                $("#strategy_name").html(plans[newindex].name);
                $("#strategy_risk_type").html("Profit range: " + plans[newindex].min_roi_percentage +
                    "% to " + plans[newindex].max_roi_percentage + "% in " + plans[newindex]
                    .plan_duration + " hours");
                $("#strategy_min").html("$" + plans[newindex].min_amount);
                // alert($(this).attr('strategy_data'));
                $("#offcanvasRight2").toggleClass("show");
                bsOffcanvas.hide();
            });
        });
    </script>

    <!-- get amount earned from database -->
    <!-- get amount earned from database -->
    @if (Session::has('signup_success'))
        <script>
            const myModal = new bootstrap.Modal('#Notice', {
                keyboard: false
            })
            myModal.show();
        </script>
    @endif
@endsection
