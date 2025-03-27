@extends('user.layout.layout')


@section('content')
        <!-- Deposit history(mobile & tablet) -->
        <div class="bg-[#242533] w-full h-screen fixed top-[84px] lg:hidden">
            <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 h-16 border-b-2 border-b-[#2A2B39]">
                <h1 class="text-[#FFFFFF] text-xl font-bold">Referrals</h1>
            </div>
            <div class="container mx-auto px-4 mt-6 pb-40 h-[70vh] overflow-scroll">
                <div class="mb-4">
                    <h3 class="text-[#FFFFFF] text-xs font-bold">TOTAL COMMISSIONS: <span class="text-xl font-bold">@money(floor($totalCommissionEarnings * 100) / 100)</span></h3>
                </div>
                <div class="text-[#FFFFFF] font-bold my-2 mt-6">Referral link</div>
                <div class="flex border-2 border-[#2A2B39] rounded-md focus:outline-0 mb-8">
                    <div class="flex-1"><input id="userref" value="https://nxcai.com/user/register/{{ $user['refcode'] }}" class="w-full text-xs rounded-md rounded-tr-none rounded-br-none px-4 py-4 bg-[#1F202B] text-[#98A4B3]" type="text" readonly></div>
                    <div onclick="copyref()" class="flex-none w-12 rounded-tr-md rounded-br-md bg-[#1F202B] flex items-center justify-center"><img src="{{ asset('userassets/icons/duplicate.svg') }}"></div>
                </div>
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto h-96">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="border-2 border-[#2A2B39] overflow-hidden">
                                <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39]">
                                    <thead class="bg-[#1E1F2A]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-md font-black text-[#FFFFFF]">
                                                Level 1 <span class="text-xs font-bold">(5% on deposits)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-[#2A2B39]">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @foreach ($firstLevelDownlines as $fld)
                                                <span
                                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs border-2 border-[#40ffdd] text-[#FFFFFF]">{{ $fld }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39]">
                                    <thead class="bg-[#1E1F2A]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-md font-black text-[#FFFFFF]">
                                                Level 2 <span class="text-xs font-bold">(3% on deposits)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-[#2A2B39]">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @foreach ($secondLevelDownlines as $sld)
                                                <span
                                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs border-2 border-[#40ffdd] text-[#FFFFFF]">{{ $sld }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39]">
                                    <thead class="bg-[#1E1F2A]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-md font-black text-[#FFFFFF]">
                                                Level 3 <span class="text-xs font-bold">(1% on deposits)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-[#2A2B39]">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @foreach ($thirdLevelDownlines as $tld)
                                                <span
                                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs border-2 border-[#40ffdd] text-[#FFFFFF]">{{ $tld }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Deposit history(desktop) -->
        <div class="bg-[#242533] w-full h-screen mt-4 hidden lg:block">
            <div class="flex items-center container md:max-w-full mx-auto px-4 pl-28 h-16 border-b-2 border-b-[#2A2B39]">
                <h1 class="text-[#FFFFFF] text-xl lg:text-2xl font-bold">Referrals</h1>
            </div>
            <div class="container mx-auto px-4 pl-28 mt-6">
                <div class="mb-4">
                    <h3 class="text-[#FFFFFF] text-xs font-bold">TOTAL COMMISSIONS: <span class="text-xl font-bold">@money(floor($totalCommissionEarnings * 100) / 100)</span></h3>
                </div>
                <div class="text-[#FFFFFF] font-bold my-2 mt-6">Referral link</div>
                <div class="flex border-2 border-[#2A2B39] rounded-md focus:outline-0 mb-8">
                    <div class="flex-1"><input id="userref" value="https://nxcai.com/user/register/{{ $user['refcode'] }}" class="w-full text-xs rounded-md rounded-tr-none rounded-br-none px-4 py-4 bg-[#1F202B] text-[#98A4B3]" type="text" readonly></div>
                    <div onclick="copyref()" class="flex-none w-12 rounded-tr-md rounded-br-md bg-[#1F202B] flex items-center justify-center"><img src="{{ asset('userassets/icons/duplicate.svg') }}"></div>
                </div>
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto h-96 lg:h-[32rem]">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="border-2 border-[#2A2B39] overflow-hidden">
                                <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39]">
                                    <thead class="bg-[#1E1F2A]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-md font-bold text-[#FFFFFF]">
                                                Level 1 <span class="text-xs font-bold">(5% on deposits)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-[#2A2B39]">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @foreach ($firstLevelDownlines as $fld)
                                                <span
                                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold border-2 border-[#40ffdd] text-[#FFFFFF]">{{ $fld }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39] my-8">
                                    <thead class="bg-[#1E1F2A]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-md font-bold text-[#FFFFFF]">
                                                Level 2 <span class="text-xs font-bold">(3% on deposits)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-[#2A2B39]">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @foreach ($secondLevelDownlines as $sld)
                                                <span
                                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold border-2 border-[#40ffdd] text-[#FFFFFF]">{{ $sld }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="min-w-full overflow-y-scroll divide-y-2 divide-[#2A2B39]">
                                    <thead class="bg-[#1E1F2A]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-md font-bold text-[#FFFFFF]">
                                                Level 3 <span class="text-xs font-bold">(1% on deposits)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-[#2A2B39]">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#FFFFFF]">
                                                @foreach ($thirdLevelDownlines as $tld)
                                                <span
                                                class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-2xl text-xs font-bold border-2 border-[#40ffdd] text-[#FFFFFF]">{{ $tld }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection