@extends('user.layout.layout')

@section('content')
    <div class="container mx-auto px-4 lg:pl-24 mt-2" x-data="{ isAssetDropdownOpen: false, toggleAssetDropdown() { this.isAssetDropdownOpen = !this.isAssetDropdownOpen } }">
        <div class="relative lg:hidden">
            <div class="flex items-center space-x-2">
                <div class="flex-1 w-3/4">
                    <button class="bg-[#1E1F2A] rounded-lg py-3 px-4 my-2 text-left w-full">
                        <div class="flex items-center space-x-3">
                            <div class="flex-none text-end">
                                @if ($selected_asset_data[0]['assetType'] === 'currency')
                                    <img src="https://olympbot.com/icons/assets/{{ $selected_asset_data[0]['image'] }}">
                                @else
                                    <img width="24" height="24"
                                        src="/images/coins/{{ $selected_asset_data[0]['image'] }}">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#FFFFFF]">
                                    {{ strlen($selected_asset_data[0]['name']) > 17 ? substr($selected_asset_data[0]['name'], 0, 15) . '...' : $selected_asset_data[0]['name'] }}
                                </p>
                            </div>
                            <div class="flex-none text-end">
                                <div
                                    class="w-12 h-6 bg-[#28BD66] border-2 border-[#146234] text-xs rounded-lg content-center text-center text-[#FFFFFF]">
                                    {{ $selected_asset_data[0]['percentage'] }}
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
                <div class="flex-none w-32">
                    @if (count($tradingbots) > 0)
                        <button id="__check_trade_sm" @click="toggleRobotModal('{{ Session::get('active_robot_modal') }}')"
                            type="submit" class="bg-[#171b26] border-2 border-[#40ffdd] rounded-lg py-2 px-2 my-2">
                            <img class="inline" src="{{ asset('userassets/icons/trade-chart-icon-white.svg') }}" /><span
                                class="text-[#FFFFFF] text-xs font-bold"> Check Trade</span>
                        </button>
                    @endif
                </div>
            </div>
            <div x-cloak x-show="isAssetDropdownOpen" @click.outside="isAssetDropdownOpen = false"
                class="bg-[#1F202B] absolute top-4 border-2 rounded-lg border-[#2A2B39] w-full h-64 overflow-scroll p-4">
                @foreach ($trading_pair_data as $pair)
                    <a href="{{ route('change_asset_pair', ['tvwidgetsymbol' => $pair['symbol']]) }}">
                        <div
                            class="flex items-center text-[#FFFFFF] mb-2 hover:bg-[#38394f] {{ $selected_asset_data[0]['name'] === $pair['name'] ? 'bg-[#38394f]' : '' }} p-3 rounded-lg space-x-3">
                            <div class="flex-none text-end">
                                @if ($pair['assetType'] === 'currency')
                                    <img src="https://olympbot.com/icons/assets/{{ $pair['image'] }}">
                                @else
                                    <img width="24" height="24" src="/images/coins/{{ $pair['image'] }}">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold">{{ $pair['name'] }}</p>
                            </div>
                            <div class="flex-none text-end">
                                <div
                                    class="w-12 h-6 bg-[#28BD66] border-2 border-[#146234] text-xs rounded-lg content-center text-center">
                                    {{ $pair['percentage'] }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="fixed -top-1 left-22 hidden lg:block">
            <div class="relative">
                <div class="flex items-center space-x-2">
                    <div class="flex-1 w-3/4">
                        <button
                            class="bg-[#1E1F2A] rounded-lg py-3 px-4 my-6 text-left w-full">
                            <div class="flex items-center space-x-3">
                                <div class="flex-none text-end">
                                    @if ($selected_asset_data[0]['assetType'] === 'currency')
                                        <img
                                            src="https://olympbot.com/icons/assets/{{ $selected_asset_data[0]['image'] }}">
                                    @else
                                        <img width="24" height="24"
                                            src="/images/coins/{{ $selected_asset_data[0]['image'] }}">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-[#FFFFFF]">
                                        {{ strlen($selected_asset_data[0]['name']) > 17 ? substr($selected_asset_data[0]['name'], 0, 15) . '...' : $selected_asset_data[0]['name'] }}
                                    </p>
                                </div>
                                <div class="flex-none text-end">
                                    <div
                                        class="w-12 h-6 bg-[#28BD66] border-2 border-[#146234] text-xs rounded-lg content-center text-center text-[#FFFFFF]">
                                        {{ $selected_asset_data[0]['percentage'] }}
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="flex-none w-36">
                        @if (count($tradingbots) > 0)
                            <button id="__check_trade_lg"
                                @click="toggleRobotModal('{{ Session::get('active_robot_modal') }}')" type="submit"
                                class="bg-[#171b26] border-2 border-[#40ffdd] rounded-lg py-2 px-4 my-2">
                                <img class="inline"
                                    src="{{ asset('userassets/icons/trade-chart-icon-white.svg') }}" /><span
                                    class="text-[#FFFFFF] text-xs font-bold"> Check Trade</span>
                            </button>
                        @endif
                    </div>
                </div>
                <div x-cloak x-show="isAssetDropdownOpen" @click.outside="isAssetDropdownOpen = false"
                    class="bg-[#1F202B] absolute top-20 border-2 rounded-lg border-[#2A2B39] w-full h-64 overflow-scroll z-10 p-4">
                    @foreach ($trading_pair_data as $pair)
                        <a href="{{ route('change_asset_pair', ['tvwidgetsymbol' => $pair['symbol']]) }}">
                            <div
                                class="flex items-center text-[#FFFFFF] mb-2 hover:bg-[#38394f] {{ $selected_asset_data[0]['name'] === $pair['name'] ? 'bg-[#38394f]' : '' }} p-3 rounded-lg space-x-3">
                                <div class="flex-none text-end">
                                    @if ($pair['assetType'] === 'currency')
                                        <img src="https://olympbot.com/icons/assets/{{ $pair['image'] }}">
                                    @else
                                        <img width="24" height="24" src="/images/coins/{{ $pair['image'] }}">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm">{{ $pair['name'] }}</p>
                                </div>
                                <div class="flex-none text-end">
                                    <div
                                        class="w-12 h-6 bg-[#28BD66] border-2 border-[#146234] text-xs rounded-lg content-center text-center">
                                        {{ $pair['percentage'] }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container mb-2 md:hidden" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "height": "500",
                    "symbol": "{{ Session::get('selected_asset') }}",
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
        </div>
        <!-- TradingView Widget END -->

        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container mb-2 hidden md:block lg:hidden" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "height": "820",
                    "symbol": "{{ Session::get('selected_asset') }}",
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
        </div>
        <!-- TradingView Widget END -->

        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container mb-2 hidden lg:block" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "height": "700",
                    "symbol": "{{ Session::get('selected_asset') }}",
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
        </div>
        <!-- TradingView Widget END -->
    </div>
@endsection
