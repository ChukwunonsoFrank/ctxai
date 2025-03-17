@extends('user.layout.layout')


@section('content')
    <!-- Trading history(mobile & tablet) -->
    <div class="flex items-center container md:max-w-full mx-auto mt-4 px-4 md:px-8 h-16 bg-[#242533] border-b-2 border-b-[#2A2B39] lg:hidden">
        <h1 class="text-[#FFFFFF] text-xl font-bold">Trades</h1>
    </div>
    <div id="tradingbots__container" class="bg-[#242533] w-full lg:hidden">
        <div class="container mx-auto px-4 py-2">
            @forelse ($transformedTradingBotsHistory as $tradingbot)
                <div class="bg-[#2e3040] p-3 w-full rounded-md mb-3">
                    <div class="flex w-full text-[#98a4b3] text-xs mb-2 items-center">
                        <div class="flex-1">
                            @if ($tradingbot['status'] == 1)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#bce7e0] text-[#105754]">Active</span>
                            @elseif ($tradingbot['status'] == 0)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#fecaca] text-[#941a1b]">Expired</span>
                            @else
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#f1edbb] text-[#844c0e]">Profit
                                    Exceeded</span>
                            @endif
                        </div>
                        <div class="flex-none">{{ ucfirst($tradingbot['account_type']) }} Account</div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-1 text-md font-bold text-[#FFFFFF]">@money(floatval($tradingbot['amount']))</div>
                        <div class="flex-none text-[#20c075] text-sm font-bold">
                            @if($tradingbot['status'] == 1)
                                <span id="active_trade_profit"></span>
                            @else
                                <div class="flex-none text-[#20c075] text-sm font-bold">+@money(floatval($tradingbot['display_profit']))</div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center mt-2">
                        <div class="flex-1 text-md font-bold text-[#FFFFFF]"></div>
                        <div class="flex-none text-[#FFFFFF] text-[10px] font-bold underline">
                            <a href="/user/tradingbot/{{ $tradingbot['id'] }}">
                                <button id="__check_trade_lg" type="submit" class="border-2 border-[#40ffdd] rounded-lg py-1 px-2 mt-2">
                                    <span class="text-[#FFFFFF] text-xs font-bold">Check Orders &raquo;</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
            <div class="bg-[#2e3040] p-3 w-full rounded-md mb-3 text-center">
                <p class="text-xs text-[#98a4b3]">You have no trades on this account</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Trading history(desktop) -->
    <div class="hidden lg:flex items-center container md:max-w-full mx-auto mt-4 px-4 pl-28 h-16 bg-[#242533] border-b-2 border-b-[#2A2B39]">
        <h1 class="text-[#FFFFFF] text-xl lg:text-2xl font-bold">Trades</h1>
    </div>
    <div id="tradingbots__container__lg" class="bg-[#242533] w-full hidden lg:block">
        <div class="container mx-auto px-4 py-2 pl-28">
            @forelse ($transformedTradingBotsHistory as $tradingbot)
                <div class="bg-[#2e3040] py-3 px-6 w-full rounded-md mb-3">
                    <div class="flex w-full text-[#98a4b3] text-xs mb-2 items-center">
                        <div class="flex-1">
                            @if ($tradingbot['status'] == 1)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#bce7e0] text-[#105754]">Active</span>
                            @elseif ($tradingbot['status'] == 0)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#fecaca] text-[#941a1b]">Expired</span>
                            @else
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#f1edbb] text-[#844c0e]">Profit
                                    Exceeded</span>
                            @endif
                        </div>
                        <div class="flex-none">{{ ucfirst($tradingbot['account_type']) }} Account</div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-1 text-md font-bold text-[#FFFFFF]">@money(floatval($tradingbot['amount']))</div>
                        <div class="flex-none text-[#20c075] text-sm font-bold">
                            @if($tradingbot['status'] == 1)
                                <span id="active_trade_profit_2"></span>
                            @else
                                <div class="flex-none text-[#20c075] text-sm font-bold">+@money(floatval($tradingbot['display_profit']))</div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center mt-2">
                        <div class="flex-1 text-md font-bold text-[#FFFFFF]"></div>
                        <div class="flex-none text-[#FFFFFF] text-[10px] font-bold underline">
                            <a href="/user/tradingbot/{{ $tradingbot['id'] }}">
                                <button id="__check_trade_lg" type="submit" class="border-2 border-[#40ffdd] rounded-lg py-1 px-2 mt-2">
                                    <span class="text-[#FFFFFF] text-xs font-bold">Check Orders &raquo;</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
            <div class="bg-[#2e3040] p-3 w-full rounded-md mb-3 text-center">
                <p class="text-xs text-[#98a4b3]">You have no trades on this account</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection

