@extends('user.layout.layout')


@section('content')
    <!-- Trading history(mobile & tablet) -->
    <div
        class="flex items-center container md:max-w-full mx-auto mt-4 px-4 md:px-8 h-16 bg-[#242533] border-b-2 border-b-[#2A2B39] lg:hidden">
        <h1 class="text-[#FFFFFF] text-xl font-bold">Orders History</h1>
    </div>
    <div id="history__container" class="bg-[#242533] w-full lg:hidden">
        <div class="container mx-auto px-4 py-2">
            @forelse ($trades as $trade)
                <div class="bg-[#2e3040] p-3 w-full rounded-md mb-3">
                    <div class="flex w-full text-[#98a4b3] text-xs mb-4 items-center">
                        <div class="flex-1">
                            <span
                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#48495a] text-[#FFFFFF]">Robot</span>
                        </div>
                        <div class="flex-none">{{ ucfirst($selectedBotAccountType[0]) }} Account</div>
                    </div>
                    <div class="mb-1">
                        <p class="text-sm font-medium text-[#FFFFFF]">Traded</p>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-1 text-md font-bold text-[#FFFFFF]">
                            @if ($trade->type === 'currency')
                                <img class="inline" src="{{ $trade->image_url }}">
                            @else
                                <img class="inline" width="24" height="24" src="{{ $trade->image_url }}">
                            @endif
                            <span>{{ $trade->asset_display_name }} </span>
                            @if ($trade->action === 'BUY')
                                <span class="text-xs font-bold text-[#16C784]"> BUY</span>
                            @else
                                <span class="text-xs font-bold text-[#ea3943]"> SELL</span>
                            @endif
                        </div>
                        <div class="flex-none text-[#20c075] text-sm font-bold">+@money(floatval($trade->profit))</div>
                    </div>
                </div>
            @empty
                <div class="bg-[#2e3040] p-3 w-full rounded-md mb-3 text-center">
                    <p class="text-xs text-[#98a4b3]">No history available</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Trading history(desktop) -->
    <div
        class="hidden lg:flex items-center container md:max-w-full mx-auto mt-4 px-4 pl-28 h-16 bg-[#242533] border-b-2 border-b-[#2A2B39]">
        <h1 class="text-[#FFFFFF] text-xl lg:text-2xl font-bold">Orders History</h1>
    </div>
    <div id="history__container__lg" class="bg-[#242533] w-full hidden lg:block">
        <div class="container mx-auto px-4 py-2 pl-28">
            @forelse ($trades as $trade)
                <div class="bg-[#2e3040] py-3 px-6 w-full rounded-md mb-3">
                    <div class="flex w-full text-[#98a4b3] text-xs mb-2 items-center">
                        <div class="flex-1">
                            <span
                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold bg-[#48495a] text-[#FFFFFF]">Robot</span>
                        </div>
                        <div class="flex-none">{{ ucfirst($selectedBotAccountType[0]) }} Account</div>
                    </div>
                    <div class="mb-1">
                        <p class="text-sm font-medium text-[#FFFFFF]">Traded</p>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-1 text-md font-bold text-[#FFFFFF]">
                            @if ($trade->type === 'currency')
                                <img class="inline" src="{{ $trade->image_url }}">
                            @else
                                <img class="inline" width="24" height="24" src="{{ $trade->image_url }}">
                            @endif
                            <span>{{ $trade->asset_display_name }} </span>
                            @if ($trade->action === 'BUY')
                                <span class="text-xs font-bold text-[#16C784]"> BUY</span>
                            @else
                                <span class="text-xs font-bold text-[#ea3943]"> SELL</span>
                            @endif
                        </div>
                        <div class="flex-none text-[#20c075] text-sm font-bold">+@money(floatval($trade->profit))</div>
                    </div>
                </div>
            @empty
                <div class="bg-[#2e3040] p-3 w-full rounded-md mb-3 text-center">
                    <p class="text-xs text-[#98a4b3]">No history available</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
