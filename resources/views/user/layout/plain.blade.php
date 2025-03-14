<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ctxai - Ai Trading Bot</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="/userassets/js/qrcode.min.js"></script>

    <script>
        function copyWalletAddress() {
            // Get the text field
            var copyText = document.getElementById("wallet_address");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);
        }

        function makeCode(walletAddress) {
            var qrcode = new QRCode("qrcode");
            qrcode.makeCode(walletAddress);
        }

        function makeQrCode() {
            let depositAmount = document.getElementById("deposit_amount");
            let paymentMethod = document.getElementById("payment_method");
            let wallets = @json($wallets);
            let wallet = wallets.filter(wallet => wallet.coin_code === paymentMethod.value);
            makeCode(wallet[0].coin_wallet);
            document.getElementById('wallet_address').value = wallet[0].coin_wallet;
            document.getElementById('amount_to_send').innerText = `$${depositAmount.value} in ${wallet[0].coin_code}`;
        }

        function submitDepositData() {
            let depositAmount = document.getElementById("deposit_amount").value;
            let paymentMethod = document.getElementById("payment_method").value;
            document.getElementById("deposit__amount__submit").value = depositAmount;
            document.getElementById("payment__method__submit").value = paymentMethod;
            document.getElementById("deposit__data__form").submit();
        }
    </script>
 
    <link rel="icon" type="image/png" href="/homeassets/img/Ctxailogo.png">
    <link rel="stylesheet" href="/homeassets/dashboard/account.css">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('header')

    {{-- <script src="//code.jivosite.com/widget/MkAidNLQxk" async></script> --}}

</head>

<body class="bg-dashboard font-sans" x-data="{ isDepositModalOpen: false, isQRCodeDepositModalOpen: false, toggleDepositModal() { this.isDepositModalOpen = !this.isDepositModalOpen }, proceedToQRCodeModal() { this.isDepositModalOpen = false; this.isQRCodeDepositModalOpen = true }, goBackDeposit() { this.isQRCodeDepositModalOpen = false; this.isDepositModalOpen = true } }">
    <div class="container mx-auto px-4" x-data="{ isSelectAccountDropdownOpen: false, toggleSelectAccountDropdown() { this.isSelectAccountDropdownOpen = !this.isSelectAccountDropdownOpen } }">
        <header class="pt-4">
            <div class="flex items-center gap-x-2">
                <div class="flex-none w-14 md:flex-1">
                    <img src="{{ env('APP_SITE_LOGO') }}" alt="Logo" width="40px"
                        class="d-inline-block align-text-top rounded lg:hidden">
                </div>
                <div class="flex-1 md:flex-none relative">
                    <div @click="toggleSelectAccountDropdown()" class="hover:bg-[#1F202B] py-1 px-1 md:px-4 rounded-lg">
                        <div class="text-center md:text-end">
                            <h6 class="mb-0 text-[#FFFFFF] font-semibold">
                                @if (Session::has('account_balance'))
                                    @if (Session::get('account_type') == 'demo')
                                        @money($user['demo_balance'])
                                    @else
                                        @money($user['balance'])
                                    @endif
                                @endif

                            </h6>
                        </div>
                        <div class="text-center md:text-end">
                            <h4 id="account-type" class="account-type mb-0 text-[#FFFFFF] text-xs">
                                @if (Session::has('account_type'))
                                    @if (Session::get('account_type') == 'demo')
                                        Demo Account
                                    @else
                                        Live Account
                                    @endif
                                @endif
                                <img class="inline" src="{{ asset('userassets/icons/chevron-down-mobile.svg') }}">
                            </h4>
                        </div>
                    </div>
                    <div x-show="isSelectAccountDropdownOpen" @click.outside="isSelectAccountDropdownOpen = false"
                        class="bg-[#1F202B] absolute left-4 top-14 border-2 rounded-lg border-[#2A2B39] w-60 z-30 p-4">
                        <a href="/user/selectaccount/demo" class="text-decoration-none">
                            <div
                                class="flex items-center text-[#FFFFFF] mb-2 hover:bg-[#38394f] {{ Session::get('account_type') == 'demo' ? 'bg-[#38394f]' : '' }} p-3 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm">Demo account</p>
                                    <p class="font-semibold text-sm">@money($user['demo_balance'])</p>
                                </div>
                                <div class="flex-none w-8 text-end">
                                    @if (Session::get('account_type') == 'demo')
                                        <img class="inline"
                                            src="{{ asset('userassets/icons/check-circle-mobile.svg') }}">
                                    @endif
                                </div>
                            </div>
                        </a>
                        <a href="/user/selectaccount/live" class="text-decoration-none">
                            <div
                                class="flex items-center text-[#FFFFFF] mb-2 hover:bg-[#38394f] {{ Session::get('account_type') != 'demo' ? 'bg-[#38394f]' : '' }} p-3 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm">Live account</p>
                                    <p class="font-semibold text-sm">@money($user['balance'])</p>
                                </div>
                                <div class="flex-none w-8 text-end">
                                    @if (Session::get('account_type') != 'demo')
                                        <img class="inline"
                                            src="{{ asset('userassets/icons/check-circle-mobile.svg') }}">
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="flex-1 md:flex-none w-48">
                    <button @click="toggleDepositModal()"
                        class="bg-[#1F202B] border-2 rounded-lg border-[#2A2B39] py-3 px-2 w-full">
                        <img class="inline" src="{{ asset('userassets/icons/credit-card-mobile.svg') }}"> <span
                            class="text-[#FFFFFF] text-sm font-semibold">Deposit</span>
                    </button>
                </div>
            </div>
        </header>
    </div>

    {{-- Navbar on mobile/tablet mode --}}
    <div class="container md:max-w-full mx-auto px-4 md:px-32 lg:hidden bg-[#1E1F2A] h-16 fixed bottom-0 z-30">
        <div class="flex items-center h-full justify-between">
            <div class="text-center">
                <a href="{{ route('dashboard.view') }}">
                    <div class="w-full flex justify-center">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.33337 5.41659C4.33337 4.81828 4.8184 4.33325 5.41671 4.33325H20.5834C21.1817 4.33325 21.6667 4.81828 21.6667 5.41659V7.58325C21.6667 8.18156 21.1817 8.66658 20.5834 8.66658H5.41671C4.8184 8.66658 4.33337 8.18156 4.33337 7.58325V5.41659Z"
                                stroke="{{ Session::get('page') === 'dashboard' ? '#FFFFFF' : '#5D606B' }}"
                                stroke-width="2.16667" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M4.33337 14.0833C4.33337 13.4849 4.8184 12.9999 5.41671 12.9999H11.9167C12.515 12.9999 13 13.4849 13 14.0833V20.5833C13 21.1816 12.515 21.6666 11.9167 21.6666H5.41671C4.8184 21.6666 4.33337 21.1816 4.33337 20.5833V14.0833Z"
                                stroke="{{ Session::get('page') === 'dashboard' ? '#FFFFFF' : '#5D606B' }}"
                                stroke-width="2.16667" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M17.3334 14.0833C17.3334 13.4849 17.8184 12.9999 18.4167 12.9999H20.5834C21.1817 12.9999 21.6667 13.4849 21.6667 14.0833V20.5833C21.6667 21.1816 21.1817 21.6666 20.5834 21.6666H18.4167C17.8184 21.6666 17.3334 21.1816 17.3334 20.5833V14.0833Z"
                                stroke="{{ Session::get('page') === 'dashboard' ? '#FFFFFF' : '#5D606B' }}"
                                stroke-width="2.16667" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <p
                        class="{{ Session::get('page') === 'dashboard' ? 'text-[#FFFFFF]' : 'text-inactive' }} text-[10px] font-semibold">
                        Dashboard</p>
                </a>
            </div>
            <div class="text-center">
                <img class="inline" src="{{ asset('userassets/icons/support-icon-mobile.svg') }}">
                <p class="text-inactive text-[10px] font-semibold">Support</p>
            </div>
            <div class="text-center">
                <img class="inline" src="{{ asset('userassets/icons/robot-icon-mobile.svg') }}">
            </div>
            <div class="text-center">
                <img class="inline" src="{{ asset('userassets/icons/withdraw-icon-mobile.svg') }}">
                <p class="text-inactive text-[10px] font-semibold">Withdraw</p>
            </div>
            <div class="text-center">
                <img class="inline" src="{{ asset('userassets/icons/account-icon-mobile.svg') }}">
                <p class="text-inactive text-[10px] font-semibold">Account</p>
            </div>
        </div>
    </div>

    {{-- Navbar on desktop mode --}}
    <div class="fixed hidden lg:block left-0 top-0 bg-[#1E1F2A] h-full px-4">
        <div class="text-center mt-4 mb-8">
            <img src="{{ env('APP_SITE_LOGO') }}" alt="Logo" width="40px"
                class="inline align-text-top rounded">
        </div>
        <div class="text-center mb-8">
            <a href="{{ route('dashboard.view') }}">
                <div class="w-full flex justify-center">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.33337 5.41659C4.33337 4.81828 4.8184 4.33325 5.41671 4.33325H20.5834C21.1817 4.33325 21.6667 4.81828 21.6667 5.41659V7.58325C21.6667 8.18156 21.1817 8.66658 20.5834 8.66658H5.41671C4.8184 8.66658 4.33337 8.18156 4.33337 7.58325V5.41659Z"
                            stroke="{{ Session::get('page') === 'dashboard' ? '#FFFFFF' : '#5D606B' }}"
                            stroke-width="2.16667" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M4.33337 14.0833C4.33337 13.4849 4.8184 12.9999 5.41671 12.9999H11.9167C12.515 12.9999 13 13.4849 13 14.0833V20.5833C13 21.1816 12.515 21.6666 11.9167 21.6666H5.41671C4.8184 21.6666 4.33337 21.1816 4.33337 20.5833V14.0833Z"
                            stroke="{{ Session::get('page') === 'dashboard' ? '#FFFFFF' : '#5D606B' }}"
                            stroke-width="2.16667" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M17.3334 14.0833C17.3334 13.4849 17.8184 12.9999 18.4167 12.9999H20.5834C21.1817 12.9999 21.6667 13.4849 21.6667 14.0833V20.5833C21.6667 21.1816 21.1817 21.6666 20.5834 21.6666H18.4167C17.8184 21.6666 17.3334 21.1816 17.3334 20.5833V14.0833Z"
                            stroke="{{ Session::get('page') === 'dashboard' ? '#FFFFFF' : '#5D606B' }}"
                            stroke-width="2.16667" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p
                    class="{{ Session::get('page') === 'dashboard' ? 'text-[#FFFFFF]' : 'text-inactive' }} text-[10px] font-semibold">
                    Dashboard</p>
            </a>
        </div>
        <div class="text-center mb-8">
            <img class="inline" src="{{ asset('userassets/icons/support-icon-mobile.svg') }}">
            <p class="text-[#FFFFFF] text-[10px] font-semibold">Support</p>
        </div>
        <div class="text-center mb-8">
            <img class="inline" src="{{ asset('userassets/icons/robot-icon-mobile.svg') }}">
        </div>
        <div class="text-center mb-8">
            <img class="inline" src="{{ asset('userassets/icons/withdraw-icon-mobile.svg') }}">
            <p class="text-[#FFFFFF] text-[10px] font-semibold">Withdraw</p>
        </div>
        <div class="text-center mb-8">
            <img class="inline" src="{{ asset('userassets/icons/account-icon-mobile.svg') }}">
            <p class="text-[#FFFFFF] text-[10px] font-semibold">Account</p>
        </div>
        <div class="text-center mt-64">
            <img class="inline" src="{{ asset('userassets/icons/logout-icon-mobile.svg') }}">
            <p class="text-[#FF5765] text-[10px] font-semibold">Logout</p>
        </div>
    </div>

    <!-- Deposit modal -->
    <div x-show="isDepositModalOpen" @click.outside="isDepositModalOpen = false" class="bg-[#242533] w-full h-screen fixed top-[84px] z-20 lg:top-0 lg:w-96 lg:right-0">
        <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 h-16 border-b-2 border-b-[#2A2B39]">
            <h1 class="text-[#FFFFFF] text-xl font-bold">Deposit to Live Account</h1>
        </div>
        <div class="container mx-auto px-4">
            <div class="mt-6">
                <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Deposit
                    Amount</label>
                <input id="deposit_amount" type="text"
                    class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" required>
            </div>

            <div class="mt-6">
                <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Payment
                    Method</label>
                <select id="payment_method" name="payment_method" required
                    class="w-full border-2 border-[#2A2B39] px-4 py-3 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]">
                    <option value="BTC">Bitcoin</option>
                    <option value="ETH">Ethereum</option>
                    <option value="USDT">USDT</option>
                </select>
            </div>

            <div class="mt-56 md:mt-[30rem] lg:mt-80 text-center">
                <img class="inline" src="{{ asset('userassets/icons/lock-closed.svg') }}">
                <p class="text-[#FFFFFF] text-xs my-6">Your data is encrypted using 256-bit SSL certificates, providing
                    you with the strongest security available</p>
                <button @click="proceedToQRCodeModal()" onclick="makeQrCode()"
                    class="bg-gradient-to-r from-[#209895] to-[#A556F8] rounded-lg py-3 px-2 w-full">
                    <span class="text-[#FFFFFF] text-sm font-bold">Make a deposit</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Deposit(QR code/copy address) modal -->
    <div x-show="isQRCodeDepositModalOpen" @click.outside="isQRCodeDepositModalOpen = false" class="bg-[#242533] w-full h-screen fixed top-[84px] z-20 lg:top-0 lg:w-96 lg:right-0">
        <form id="deposit__data__form" action="{{ url('/user/deposit') }}" method="post">
            @csrf
            <input type="hidden" value="" id="deposit__amount__submit" name="amount">
            <input type="hidden" value="" id="payment__method__submit" name="wallet">
        </form>

        <div class="flex space-x-1 items-center container md:max-w-full mx-auto px-4 h-16 border-b-2 border-b-[#2A2B39]">
            <a @click="goBackDeposit()"><img src="{{ asset('userassets/icons/chevron-left.svg') }}"></a>
            <h1 class="text-[#FFFFFF] text-xl font-bold">Deposit to Live Account</h1>
        </div>
        <div class="container mx-auto px-4">
            <div class="text-center mt-4 md:mt-24">
                <p class="text-[#FFFFFF] text-xs my-6">Scan QR code or copy wallet address below</p>
            </div>
            <div class="my-8 text-center flex items-center justify-center">
                <div class="w-24 h-24" id="qrcode"></div>
            </div>
            <div class="text-center">
                <p class="text-[#FFFFFF] text-sm font-semibold my-6">Send <span id="amount_to_send"></span> to the wallet address provided below</p>
            </div>

            <div class="flex mt-6 border-2 border-[#2A2B39] rounded-md focus:outline-0">
                <div class="flex-1"><input class="w-full text-xs rounded-md rounded-tr-none rounded-br-none px-4 py-3 bg-[#1F202B] text-[#FFFFFF]"
                    id="wallet_address" type="text" readonly></div>
                <div onclick="copyWalletAddress()" class="flex-none w-12 rounded-tr-md rounded-br-md bg-[#1F202B] flex items-center justify-center"><img src="{{ asset('userassets/icons/duplicate.svg') }}"></div>
            </div>

            <div class="mt-24 md:mt-80 lg:mt-32 text-center">
                <img class="inline" src="{{ asset('userassets/icons/lock-closed.svg') }}">
                <p class="text-[#FFFFFF] text-xs my-6">Your data is encrypted using 256-bit SSL certificates, providing
                    you with the strongest security available</p>
                <button onclick="submitDepositData()" class="bg-gradient-to-r from-[#209895] to-[#A556F8] rounded-lg py-3 px-2 w-full">
                    <span class="text-[#FFFFFF] text-sm font-bold">Yes I have paid</span>
                </button>
            </div>
        </div>
    </div>

    @yield('content')

</body>

</html>
