@extends('user.layout.layout')


@section('content')
     <!-- Withdraw history(mobile & tablet) -->
     <div class="bg-[#242533] w-full h-screen fixed top-[84px] lg:hidden">
        <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 h-16 border-b-2 border-b-[#2A2B39]">
            <h1 class="text-[#FFFFFF] text-xl font-bold">Withdrawal history</h1>
        </div>
        <div class="container mx-auto px-4 mt-6">
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto h-96">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="border-2 border-[#2A2B39] overflow-hidden">
                            <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39]">
                                <thead class="bg-[#1E1F2A]">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Amount</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Crypto</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Wallet</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Status</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Created</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y-2 divide-[#2A2B39]">
                                    @forelse ($withdraws as $withdraw)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-[#FFFFFF]">
                                                @money($withdraw['amount'])</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @if($withdraw['gateway'] === "BTC")
                                                    Bitcoin
                                                @endif
                                                @if($withdraw['gateway'] === "ETH")
                                                    Ethereum
                                                @endif
                                                @if($withdraw['gateway'] === "USDT ERC20")
                                                    USDT (ERC20)
                                                @endif
                                                @if($withdraw['gateway'] === "USDT TRC20")
                                                    USDT (TRC20)
                                                @endif
                                                @if($withdraw['gateway'] === "USDT BEP20")
                                                    USDT (BEP20)
                                                @endif
                                                @if($withdraw['gateway'] === "LTC")
                                                    Litecoin
                                                @endif
                                                @if($withdraw['gateway'] === "BNB")
                                                    BNB
                                                @endif
                                                @if($withdraw['gateway'] === "SOL")
                                                    Solana
                                                @endif
                                                @if($withdraw['gateway'] === "TRX")
                                                    Tron
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">{{ $withdraw['userwallet_id']}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @if ($withdraw['withdraw_status'] == 1)
                                                    <span
                                                        class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#bce7e0] text-[#105754]">Confirmed</span>
                                                @elseif($withdraw['withdraw_status'] == 0)
                                                    <span
                                                        class="inline-flex items-center gap-x-1.5 py-1 px-4 rounded-2xl text-xs font-bold bg-[#fecaca] text-[#941a1b]">Pending</span>
                                                @elseif($withdraw['withdraw_status'] == 3)
                                                    <span
                                                        class="inline-flex items-center gap-x-1.5 py-1 px-4 rounded-2xl text-xs font-bold bg-[#f1edbb] text-[#844c0e]">Declined</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                {{ date('d-m-Y', strtotime($withdraw['created_at'])) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-[#FFFFFF]"
                                                colspan="4">
                                                No data found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdraw history(desktop) -->
    <div class="bg-[#242533] w-full h-screen mt-4 hidden lg:block">
        <div class="flex items-center container md:max-w-full mx-auto px-4 pl-28 h-16 border-b-2 border-b-[#2A2B39]">
            <h1 class="text-[#FFFFFF] text-xl lg:text-2xl font-bold">Withdrawal history</h1>
        </div>
        <div class="container mx-auto px-4 pl-28 mt-6">
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto h-96 lg:h-[32rem]">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="border-2 border-[#2A2B39] overflow-hidden">
                            <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39]">
                                <thead class="bg-[#1E1F2A]">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Amount</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Crypto</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Wallet</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Status</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-[#FFFFFF]">
                                            Created</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y-2 divide-[#2A2B39]">
                                    @forelse ($withdraws as $withdraw)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-[#FFFFFF]">
                                            @money($withdraw['amount'])</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                            @if($withdraw['gateway'] === "BTC")
                                                Bitcoin
                                            @endif
                                            @if($withdraw['gateway'] === "ETH")
                                                Ethereum
                                            @endif
                                            @if($withdraw['gateway'] === "USDT ERC20")
                                                USDT (ERC20)
                                            @endif
                                            @if($withdraw['gateway'] === "USDT TRC20")
                                                USDT (TRC20)
                                            @endif
                                            @if($withdraw['gateway'] === "USDT BEP20")
                                                USDT (BEP20)
                                            @endif
                                            @if($withdraw['gateway'] === "LTC")
                                                Litecoin
                                            @endif
                                            @if($withdraw['gateway'] === "BNB")
                                                BNB
                                            @endif
                                            @if($withdraw['gateway'] === "SOL")
                                                Solana
                                            @endif
                                            @if($withdraw['gateway'] === "TRX")
                                                Tron
                                            @endif
                                            @if($withdraw['gateway'] === "XRP")
                                                XRP
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">{{ $withdraw['userwallet_id']}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                            @if ($withdraw['withdraw_status'] == 1)
                                                <span
                                                    class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#bce7e0] text-[#105754]">Confirmed</span>
                                            @elseif($withdraw['withdraw_status'] == 0)
                                                <span
                                                    class="inline-flex items-center gap-x-1.5 py-1 px-4 rounded-2xl text-xs font-bold bg-[#fecaca] text-[#941a1b]">Pending</span>
                                            @elseif($withdraw['withdraw_status'] == 3)
                                                <span
                                                    class="inline-flex items-center gap-x-1.5 py-1 px-4 rounded-2xl text-xs font-bold bg-[#f1edbb] text-[#844c0e]">Declined</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                            {{ date('d-m-Y', strtotime($withdraw['created_at'])) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-[#FFFFFF]"
                                            colspan="4">
                                            No data found
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection