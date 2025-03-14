@extends('user.layout.layout')

@section('content')
    <div class="container mx-auto px-4 lg:pl-24 mt-4">
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container mb-2 md:hidden" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "height": "500",
                    "symbol": "BTCUSDT",
                    "interval": "1",
                    "timezone": "Etc/UTC",
                    "theme": "dark",
                    "style": "3",
                    "locale": "en",
                    "allow_symbol_change": true,
                    "backgroundColor": "rgba(23, 27, 38, 1)",
                    "calendar": false,
                    "hide_top_toolbar": true,
                    "hide_volume": true,
                    "support_host": "https://www.tradingview.com"
                }
            </script>
            <div class="flex justify-center">
                <div>
                    @if (count($tradingbots) > 0)
                        <button id="__check_trade_md"
                            @click="toggleRobotModal('{{ Session::get('active_robot_modal') }}')" type="submit"
                            class="bg-[#171b26] border-2 border-[#40ffdd] rounded-lg py-2 px-4 my-2">
                            <img class="inline"
                                src="{{ asset('userassets/icons/trade-chart-icon-white.svg') }}" /><span
                                class="text-[#FFFFFF] text-xs font-bold"> Back to Robot</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <!-- TradingView Widget END -->

        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container mb-2 hidden md:block lg:hidden" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "height": "820",
                    "symbol": "BTCUSDT",
                    "interval": "1",
                    "timezone": "Etc/UTC",
                    "theme": "dark",
                    "style": "3",
                    "locale": "en",
                    "allow_symbol_change": true,
                    "backgroundColor": "rgba(23, 27, 38, 1)",
                    "calendar": false,
                    "hide_top_toolbar": true,
                    "hide_volume": true,
                    "support_host": "https://www.tradingview.com"
                }
            </script>
            <div class="flex justify-center">
                <div>
                    @if (count($tradingbots) > 0)
                        <button id="__check_trade_md"
                            @click="toggleRobotModal('{{ Session::get('active_robot_modal') }}')" type="submit"
                            class="bg-[#171b26] border-2 border-[#40ffdd] rounded-lg py-2 px-4 my-2">
                            <img class="inline"
                                src="{{ asset('userassets/icons/trade-chart-icon-white.svg') }}" /><span
                                class="text-[#FFFFFF] text-xs font-bold"> Back to Robot</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <!-- TradingView Widget END -->

        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container mb-2 hidden lg:block" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "height": "600",
                    "symbol": "BTCUSDT",
                    "interval": "1",
                    "timezone": "Etc/UTC",
                    "theme": "dark",
                    "style": "3",
                    "locale": "en",
                    "allow_symbol_change": true,
                    "backgroundColor": "rgba(23, 27, 38, 1)",
                    "calendar": false,
                    "hide_top_toolbar": true,
                    "hide_volume": true,
                    "support_host": "https://www.tradingview.com"
                }
            </script>
            <div class="flex justify-center">
                <div>
                    @if (count($tradingbots) > 0)
                        <button id="__check_trade_lg"
                            @click="toggleRobotModal('{{ Session::get('active_robot_modal') }}')" type="submit"
                            class="bg-[#171b26] border-2 border-[#40ffdd] rounded-lg py-2 px-4 mt-4">
                            <img class="inline"
                                src="{{ asset('userassets/icons/trade-chart-icon-white.svg') }}" /><span
                                class="text-[#FFFFFF] text-xs font-bold"> Back to Robot</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <!-- TradingView Widget END -->
@endsection
