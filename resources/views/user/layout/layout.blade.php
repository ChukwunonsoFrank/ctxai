<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Nxcai - Ai Trading Bot</title>
    @vite('resources/css/app.css')
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    {{-- <script type="module" src="https://unpkg.com/@lottiefiles/dotlottie-wc@latest/dist/dotlottie-wc.js"></script> --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="/userassets/js/qrcode.min.js"></script>
    <script src="/homeassets/js/jquery-3.7.1.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <script defer>
        $.ajax({
            type: 'GET',
            url: '/user/disabledisplayrobotonload',
            success: function(resp) {
                console.log(resp)
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });
    </script>

    <script>
        function copyref() {
            // Get the text field
            var copyTextRef = document.getElementById("userref");

            // Select the text field
            copyTextRef.select();
            copyTextRef.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyTextRef.value);
            $('#success_notification').text('Copied');
            $('#success_notification').show();
            setInterval(function() {
                $('#success_notification').hide()
            }, 4000);
        }
    </script>

    <script>
        function copyWalletAddress() {
            // Get the text field
            var copyText = document.getElementById("wallet_address");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);
            $('#success_notification').text('Copied');
            $('#success_notification').show();
            setInterval(function() {
                $('#success_notification').hide()
            }, 4000);
        }

        function makeCode(walletAddress) {
            var qrcode = new QRCode("qrcode");
            qrcode.makeCode(walletAddress);
        }

        // function checkAmountField(id) {
        //     let amount = document.getElementById(id).value;

        //     if(!amount) {
        //         $('#error_notification').text('Please input an amount');
        //         $('#error_notification').show();
        //         setInterval(function() {
        //             $('#error_notification').hide()
        //         }, 4000);
        //     }

        //     if (amount && id === "deposit_amount" && Number(amount) < 100) {
        //         $('#error_notification').text('Minimum deposit amount is $100');
        //         $('#error_notification').show();
        //         setInterval(function() {
        //             $('#error_notification').hide()
        //         }, 4000);
        //     }

        

        //     if (amount && id === "withdraw_amount" && Number(amount) < 10) {
        //         $('#error_notification').text('Minimum withdrawal amount is $10');
        //         $('#error_notification').show();
        //         setInterval(function() {
        //             $('#error_notification').hide()
        //         }, 4000);
        //     }
        // }

        function makeQrCode() {
            let depositAmount = document.getElementById("deposit_amount");
            let depositPaymentMethod = document.getElementById("deposit_payment_method");
            let wallets = @json($wallets);
            let wallet = wallets.filter(wallet => wallet.coin_code === depositPaymentMethod.value);
            makeCode(wallet[0].coin_wallet);
            document.getElementById('wallet_address').value = wallet[0].coin_wallet;
            document.getElementById('amount_to_send').innerText = `$${depositAmount.value} in ${wallet[0].coin_name}`;
            document.getElementById('amount_to_send_btn').innerText = `$${depositAmount.value}`;
        }

        // function cancelRobotRequest() {
        //     document.getElementById("stop__robot__form").submit();
        // }
    </script>

    <script>
        //withdrawal otp
        function checkFieldsAndSendOtp(userStatus) {
            let withdrawAmount = document.getElementById("withdraw_amount").value;
            let withdrawPayoutAddress = document.getElementById("withdraw_payout_address").value;
            if(Number(userStatus) === 0) {
                $('#error_notification').text('You are unable to trade at the moment. Please contact support to learn more.');
                $('#error_notification').show();
                setInterval(function() {
                    $('#error_notification').hide()
                }, 4000);
            } else if(!withdrawAmount) {
                $('#error_notification').text('Please input an amount');
                $('#error_notification').show();
                setInterval(function() {
                    $('#error_notification').hide()
                }, 4000);
            } else if(!withdrawPayoutAddress) {
                $('#error_notification').text('Please input a payout address');
                $('#error_notification').show();
                setInterval(function() {
                    $('#error_notification').hide()
                }, 4000);
            } else {
                document.getElementById("withdraw__otp__modal").classList.remove("hidden")
                document.getElementById("withdraw__modal").classList.add("hidden")
                sendotp()
            }
        }

        function sendotp() {
            var withdrawamount = $('#withdraw_amount').val();
            var livebalance = $('#livebalance').val();
            var walletaddress = $('#withdraw_payout_address').val();
            var walletname = $('#withdraw_payment_method').val();

            if (parseInt(livebalance) >= parseInt(withdrawamount)) {
                if (withdrawamount >= 10 || withdrawamount == "") {
                    if (walletname != "" & walletaddress != "") {
                        //send otp
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/user/sendwithdrawotp',
                            data: {
                                withdrawamount: withdrawamount,
                                walletname: walletname,
                                walletaddress: walletaddress
                            },
                            success: function(resp) {
                                if (resp != "") {
                                    console.log('otp sent')
                                } else if (resp == "") {

                                }
                            },
                            error: function() {
                                $('#error_notification').text("Error occured while sending OTP. Please try again.")
                                $('#error_notification').show()
                                setInterval(function() {
                                    $('#error_notification').hide()
                                 }, 3000);
                            }
                        });


                        $("#withdrawform").hide();
                        $("#withdrawotpform").show();
                        $("#withdrawotperror").hide();
                        $("#withdrawerror").hide();
                        if (withdrawamount == "") {
                            $("#withdrawbutton").hide();
                            $("#otpinput").hide();
                        } else {
                            $("#withdrawbutton").show();
                            $("#otpinput").show();
                        }
                    } else {
                        console.log(walletname);
                        console.log(walletaddress);
                    }

                } else {
                    $("#withdrawbutton").hide();
                    $("#otpinput").hide();
                    $("#withdrawerror").show();
                }
            } else {
                console.log(livebalance);
                console.log(withdrawamount);
                $("#withdrawotperror").show();
            }
        }

        function resendotp() {
            var withdrawamount = $('#withdraw_amount').val();
            var walletaddress = $('#withdraw_payout_address').val();
            var walletname = $('#withdraw_payment_method').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/user/sendwithdrawotp',
                data: {
                    withdrawamount: withdrawamount,
                    walletname: walletname,
                    walletaddress: walletaddress
                },
                success: function(resp) {
                    if (resp != "") {
                        $('#success_notification').text("OTP sent successfully.")
                        $('#success_notification').show()
                        setInterval(function() {
                            $('#success_notification').hide()
                        }, 3000);
                        console.log('otp sent')
                    } else if (resp == "") {
                        $('#coinwallet').val("No wallet")
                    }
                },
                error: function() {
                    $('#error_notification').text("Error occured while sending OTP. Please try again.")
                    $('#error_notification').show()
                    setInterval(function() {
                        $('#error_notification').hide()
                    }, 3000);
                }
            });
        }
    </script>

    <script>
        function goToQRCodeModal() {
            let depositAmount = document.getElementById("deposit_amount").value;
            if(!depositAmount) {
                $('#error_notification').text('Please input an amount');
                $('#error_notification').show();
                setInterval(function() {
                    $('#error_notification').hide()
                }, 4000);
            } else if (depositAmount && Number(depositAmount) < 100) { 
                $('#error_notification').text('Minimum deposit amount is $100');
                $('#error_notification').show(); 
                setInterval(function() { $('#error_notification').hide() }, 4000); }
             else {
                setTimeout(() => {
                    document.getElementById("deposit__qrcode__modal").classList.remove("hidden")
                    document.getElementById("deposit__modal").classList.add("hidden")
                    document.getElementById('deposit__modal').classList.remove('hidden');
                    makeQrCode();
                }, 50);
            }
        }

        function unhideDepositModal() {
            document.getElementById("deposit__modal").classList.remove("hidden");
        }

        function closeQRCodeModal() {
            document.getElementById("deposit__qrcode__modal").classList.add("hidden");
        }

        function closeWithdrawalOTPModal() {
            document.getElementById("withdraw__otp__modal").classList.add("hidden");
            document.getElementById("withdraw__modal").classList.remove("hidden");
        }
    </script>

    <script>
        setInterval(function() {
            $('#session_error_notification').hide()
            $('#session_success_notification').hide()
        }, 4000);
    </script>

    {{-- <link rel="stylesheet" href="/homeassets/dashboard/dashboard.css"> --}}
    {{-- <link rel="stylesheet" href="/homeassets/dashboard/robot.css"> --}}
    <!--Bootstrap icons-->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css"> --}}
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->

    <link rel="icon" type="image/png" href="/homeassets/img/Ctxailogo.png">
    <link rel="stylesheet" href="/homeassets/dashboard/account.css">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('header')

    <style>
        #proceed {
            align-items: center;
        }

        #qrcode canvas {
            width: 100% !important;
        }

        #qrcode img {
            width: 100% !important;
        }
    </style>

    <link rel="stylesheet" href="/homeassets/css/timer.css">
    {{-- <script src="//code.jivosite.com/widget/MkAidNLQxk" async></script> --}}

</head>

<body id="body_component" class="bg-dashboard font-sans" x-data="{ isSubmitDepositDataButtonDisabled: false, isSubmitWithdrawalDataButtonDisabled: false, isStartTradeButtonDisabled: false, depositStep: 1, withdrawStep: 1, showDepositAmountInput: false, showWithdrawAmountInput: false, selectedAccountBoolean: false, durationTitle: '', depositPaymentMethodTitle: '', withdrawPaymentMethodTitle: '', depositPaymentMethod: '', withdrawPaymentMethod: '', currentNavbarIcon: 'dashboard', isCancelModalOpen: false, isHowToUseModalOpen: false, isDepositModalOpen: false, isWithdrawModalOpen: false, isWithdrawOTPModalOpen: false, isRobotModalOpen: false, isAccountModalOpen: false, isSupportPortalOpen: false, isActiveBotTradeModalOpen: false, isQRCodeDepositModalOpen: false, isStrategyDropdownOpen: false, isAccountDropdownOpen: false, isDurationDropdownOpen: false, isDepositPaymentMethodDropdownOpen: false, isWithdrawPaymentMethodDropdownOpen: false, selectedStrategy: { id: '', name: '', minProfitRange: '', maxProfitRange: '', totalDuration: '', minAmount: '', image: '', accumulatedDuration: 1, tradeAmount: '', account: '' }, submitWithdrawalData() { let withdrawAmount = document.getElementById('withdraw_amount').value; let withdrawPaymentMethod = document.getElementById('withdraw_payment_method').value; let withdrawPayoutAddress = document.getElementById('withdraw_payout_address').value; let withdrawOTP = document.getElementById('withdraw_otp').value; document.getElementById('withdraw__amount').value = withdrawAmount; document.getElementById('withdraw__payment__method').value = withdrawPaymentMethod; document.getElementById('withdraw__payout__address').value = withdrawPayoutAddress; document.getElementById('withdraw__otp').value = withdrawOTP; try { document.getElementById('withdraw__data__form').submit(); } catch (error) { this.isSubmitWithdrawalDataButtonDisabled = true; console.log(error); } }, submitDepositData() { let depositAmount = document.getElementById('deposit_amount').value; let paymentMethod = document.getElementById('deposit_payment_method').value; document.getElementById('deposit__amount__submit').value = depositAmount; document.getElementById('payment__method__submit').value = paymentMethod; try { document.getElementById('deposit__data__form').submit(); } catch (error) { this.isSubmitDepositDataButtonDisabled = false; console.log(error) } }, submitTradeRequest(liveBalance, demoBalance, userStatus) { let tradeAmount = document.getElementById('strategy_trade_amount').value; let minAmount = document.getElementById('strategy_min_amount').value; let tradeAccount = document.getElementById('strategy_trade_account').value; if(Number(userStatus) === 0) { this.isStartTradeButtonDisabled = false; $('#error_notification').text('You are unable to trade at the moment. Please contact support to learn more.'); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide(); }, 4000); } else if(Number(tradeAmount) < Number(minAmount)) { this.isStartTradeButtonDisabled = false; $('#error_notification').text(`Minimum amount is $${minAmount}`); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide(); }, 4000); } else if(tradeAccount === 'demo' && Number(tradeAmount) > Number(demoBalance)) { this.isStartTradeButtonDisabled = false; $('#error_notification').text('Insufficient trading capital'); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide() }, 4000); } else if(tradeAccount === 'live' && Number(tradeAmount) > Number(liveBalance)) { this.isStartTradeButtonDisabled = false; $('#error_notification').text('Insufficient trading capital. Please fund your wallet to start trading'); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide() }, 4000); } else { document.getElementById('execute__trade__form').submit(); }}, checkInputFields(id, balance) { let amount = document.getElementById(id).value; if(!amount) { $('#error_notification').text('Please input an amount'); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide() }, 4000); } if (amount && id === 'deposit_amount' && Number(amount) < 100) { $('#error_notification').text('Minimum deposit amount is $100'); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide() }, 4000); } if (amount && id === 'deposit_amount' && Number(amount) >= 100) { this.depositStep++ } if (amount && id === 'withdraw_amount' && Number(amount) < 10) { $('#error_notification').text('Minimum withdrawal amount is $10'); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide() }, 4000); } if (amount && id === 'withdraw_amount' && Number(amount) > balance) { $('#error_notification').text('Insufficient withdrawal balance.'); $('#error_notification').show(); setInterval(function() { $('#error_notification').hide() }, 4000); } if (amount && id === 'withdraw_amount' && Number(amount) >= 10 && Number(amount) <= balance) { this.withdrawStep++ } }, toggleCancelModal() { this.isCancelModalOpen = !this.isCancelModalOpen }, toggleAccountModal() { this.isAccountModalOpen = !this.isAccountModalOpen }, toggleSupportPortal() { this.isSupportPortalOpen = !this.isSupportPortalOpen; this.isRobotModalOpen = false; this.isActiveBotTradeModalOpen = false; }, toggleDepositModal() { document.getElementById('deposit_amount').value = ''; this.depositStep = 1; this.depositPaymentTitle = ''; this.depositPaymentMethod = ''; this.isDepositModalOpen = !this.isDepositModalOpen; this.isRobotModalOpen = false; this.isActiveBotTradeModalOpen = false; }, toggleWithdrawModal() { this.isWithdrawModalOpen = !this.isWithdrawModalOpen; this.isRobotModalOpen = false; this.isActiveBotTradeModalOpen = false; }, toggleRobotModal(robotModal) { this.isDepositModalOpen = false; if (robotModal === 'robotsettings') { this.isRobotModalOpen = !this.isRobotModalOpen; } else if (robotModal === 'activebottrade') { this.isActiveBotTradeModalOpen = !this.isActiveBotTradeModalOpen; } else { this.isRobotModalOpen = !this.isRobotModalOpen; } }, toggleAccountDropdown() { this.isAccountDropdownOpen = !this.isAccountDropdownOpen }, toggleDurationDropdown() { this.isDurationDropdownOpen = !this.isDurationDropdownOpen }, toggleDepositPaymentMethodDropdown() { this.isDepositPaymentMethodDropdownOpen = !this.isDepositPaymentMethodDropdownOpen }, toggleWithdrawPaymentMethodDropdown() { this.isWithdrawPaymentMethodDropdownOpen = !this.isWithdrawPaymentMethodDropdownOpen }, toggleStrategyDropdown() { this.isStrategyDropdownOpen = !this.isStrategyDropdownOpen }, selectTradingAccount(accountBoolean) { if (accountBoolean === true) { this.selectedStrategy.account = 'live'; this.selectedAccountBoolean = true; this.isAccountDropdownOpen = false } else { this.selectedStrategy.account = 'demo'; this.selectedAccountBoolean = false; this.isAccountDropdownOpen = false } }, selectTradingAccountOnLoad(liveBalance) { if(Number(liveBalance) > 0) { this.selectedStrategy.account = 'live'; this.selectedAccountBoolean = true; } else { this.selectedStrategy.account = 'demo'; this.selectedAccountBoolean = false; } }, selectTradingDuration(duration, title) { this.selectedStrategy.accumulatedDuration = duration; this.durationTitle = title; this.isDurationDropdownOpen = false }, selectDepositPaymentMethod(method, title) { this.depositPaymentMethod = method; this.depositPaymentMethodTitle = title; this.isDepositPaymentMethodDropdownOpen = false; this.depositStep = 3; }, selectWithdrawPaymentMethod(method, title) { this.withdrawPaymentMethod = method; this.withdrawPaymentMethodTitle = title; this.isWithdrawPaymentMethodDropdownOpen = false; this.withdrawStep = 3; }, selectStrategy(id, name, minRoi, maxRoi, totalDuration, minAmount, image) { this.selectedStrategy.id = id; this.selectedStrategy.name = name; this.selectedStrategy.minRoi = minRoi; this.selectedStrategy.maxRoi = maxRoi; this.selectedStrategy.totalDuration = totalDuration; this.selectedStrategy.minAmount = minAmount; document.getElementById('strategy_min_amount').value = minAmount; this.selectedStrategy.image = image; this.isStrategyDropdownOpen = false }, showHowToUseModalOnJustRegistered(justRegistered) { if(justRegistered === true) { this.isHowToUseModalOpen = true } }, showRobotModalOnLoad(robotModal) { if (robotModal === 'robotsettings') { this.isRobotModalOpen = true } else if (robotModal === 'activebottrade') { this.isActiveBotTradeModalOpen = true } else if (robotModal === 'disabled') { this.isRobotModalOpen = false; this.isActiveBotTradeModalOpen = false; } }, proceedToQRCodeModal() { this.isDepositModalOpen = false; this.isQRCodeDepositModalOpen = true }, proceedToOTPModal() { this.isWithdrawModalOpen = false; this.isWithdrawOTPModalOpen = true }, goBackDeposit() { document.getElementById('deposit__qrcode__modal').classList.add('hidden'); $('#qrcode').empty(); } }">
    <div class="flex fixed top-2 w-full justify-center z-50">
        <!-- AJAX invoked notifications -->
        <div id="error_notification" class="bg-[#fecaca] hidden text-[#941a1b] w-80 py-3 px-4 rounded-lg text-xs text-center font-semibold"></div>
        <div id="success_notification" class="bg-[#bce7e0] hidden text-[#105754] w-80 py-3 px-4 rounded-lg text-xs text-center font-semibold"></div>
        @if(Session::has('error_message'))
            <div id="session_error_notification" class="bg-[#fecaca] text-[#941a1b] w-80 py-3 px-4 rounded-lg text-xs text-center font-semibold">{{ Session::get('error_message') }}</div>
        @endif
        @if(Session::has('success_message'))
            <div id="session_success_notification" class="bg-[#bce7e0] text-[#105754] w-80 py-3 px-4 rounded-lg text-xs text-center font-semibold">{{ Session::get('success_message') }}</div>
        @endif
    </div>
    <div class="container mx-auto px-2" x-data="{ isSelectAccountDropdownOpen: false, toggleSelectAccountDropdown() { this.isSelectAccountDropdownOpen = !this.isSelectAccountDropdownOpen } }">
        <header class="pt-4">
            <div class="flex items-center md:justify-end">
                {{-- <div class="flex-none w-14 md:flex-1">
                    <img src="{{ env('APP_SITE_LOGO') }}" alt="Logo" width="40px"
                        class="d-inline-block align-text-top rounded lg:hidden">
                </div> --}}
                <div class="flex-1 md:flex-none md:w-96 flex gap-x-1 rounded-lg px-1 md:px-2">
                    <div class="relative flex-1 items-center text-[#FFFFFF] p-2 md:pl-4 rounded-lg border-2 border-[#2A2B39]">
                        {{-- <div class="absolute inline-block h-4 w-4 rounded-full bg-[#40ffdd] animate-ping opacity-75">
                            <div class="relative inline-flex size-[11px] rounded-full bg-[#40ffdd]"></div>
                        </div> --}}
                        @if (count($tradingbots) > 0 && $tradingbots[0]['account_type'] === 'live')
                        <div class="absolute right-1.5 top-3">
                            <span class="flex size-[8px]">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#40ffdd] opacity-75"></span>
                                <span class="relative inline-flex size-[8px] rounded-full bg-[#40ffdd]"></span>
                            </span>
                        </div>
                        @endif
                        <div class="text-center">
                            <p class="text-xs md:text-sm font-extrabold">Live account</p>
                            <p class="text-xs md:text-sm">@money($user['balance'])</p>
                        </div>
                    </div>
                    <div class="relative flex-1 items-center text-[#FFFFFF] p-2 md:pl-4 rounded-lg border-2 border-[#2A2B39]">
                        @if (count($tradingbots) > 0 && $tradingbots[0]['account_type'] === 'demo')
                        <div class="absolute right-2 top-3">
                            <span class="flex size-[8px]">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#40ffdd] opacity-75"></span>
                                <span class="relative inline-flex size-[8px] rounded-full bg-[#40ffdd]"></span>
                            </span>
                        </div>
                        @endif
                        <div class="text-center">
                            <p class="text-xs md:text-sm font-extrabold">Demo account</p>
                            <p class="text-xs md:text-sm">@money($user['demo_balance'])</p>
                        </div>
                    </div>
                </div>
                {{-- <div class="flex-none md:flex-none relative"> --}}
                    {{-- <div @click="toggleSelectAccountDropdown()" class="hover:bg-[#1F202B] py-1 px-1 md:px-4 rounded-lg">
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
                                <img class="inline w-4" src="{{ asset('userassets/icons/chevron-down-mobile.svg') }}">
                            </h4>
                        </div>
                    </div> --}}
                    {{-- <div x-cloak x-show="isSelectAccountDropdownOpen" @click.outside="isSelectAccountDropdownOpen = false"
                        class="bg-[#1F202B] absolute left-4 top-14 border-2 rounded-lg border-[#2A2B39] p-2 w-60 h-auto z-30">
                        <a href="/user/selectaccount/demo" class="text-decoration-none">
                            {{ Session::get('account_type') == 'demo' ? 'bg-[#38394f]' : '' }}
                            <div
                                class="flex items-center text-[#FFFFFF] mb-2 hover:bg-[#38394f] p-3 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-bold">Demo account</p>
                                    <p class="text-sm">@money($user['demo_balance'])</p>
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
                                class="flex items-center text-[#FFFFFF] hover:bg-[#38394f] p-3 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-bold">Live account</p>
                                    <p class="text-sm">@money($user['balance'])</p>
                                </div>
                                <div class="flex-none w-8 text-end">
                                    @if (Session::get('account_type') != 'demo')
                                        <img class="inline"
                                            src="{{ asset('userassets/icons/check-circle-mobile.svg') }}">
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div> --}}
                {{-- </div> --}}
                <div class="flex-none w-28 md:flex-none md:w-64">
                    <button @click="toggleDepositModal(); showDepositAmountInput = true; $nextTick(() => { $refs.depositAmountInput.scrollIntoView({ behavior: 'smooth', block: 'center' }); setTimeout(() => $refs.depositAmountInput.focus(), 100) });" 
                        class="bg-[#40ffdd] rounded-lg py-3 md:py-4 px-2 w-full">
                        <img class="inline" src="{{ asset('userassets/icons/credit-card-mobile.svg') }}"> <span
                            class="text-[#000000] text-xs md:text-sm font-semibold">Deposit</span>
                    </button>
                </div>
            </div>
        </header>
    </div>

    {{-- Navbar on mobile/tablet mode --}}
    <div id="mobile__navbar" class="container md:max-w-full mx-auto px-4 md:px-32 lg:hidden bg-[#1E1F2A] h-16 fixed bottom-0 z-30">
        <div class="flex items-center h-full justify-between">
            <div class="text-center cursor-pointer">
                <a href="/user/dashboard">
                    <img class="inline w-5" src="{{ asset('userassets/icons/dashboard-icon-mobile.svg') }}">
                    <p
                        class="text-[#FFFFFF] text-[10px] font-semibold">
                        Chart</p>
                </a>
            </div>
            <div class="text-center cursor-pointer">
                <a href="/user/tradingbot">
                    <img class="inline w-8" src="{{ asset('userassets/icons/deals-icon-mobile.svg') }}">
                    <p class="text-[#FFFFFF] text-[10px] font-semibold">Deals</p>
                </a>
            </div>
            <div class="text-center cursor-pointer" onclick="closeQRCodeModal(); closeWithdrawalOTPModal();" @click="toggleRobotModal('{{Session::get('active_robot_modal')}}');">
                <img class="inline w-8" src="{{ asset('userassets/icons/robot-icon-mobile.svg') }}">
                <p class="text-[#FFFFFF] text-[10px] font-semibold">Robot</p>
            </div>
            <div class="text-center cursor-pointer" @click="toggleSupportPortal()">
                <img class="inline-block my-1" src="{{ asset('userassets/icons/support-icon-mobile.svg') }}">
                <p class="text-[#FFFFFF] text-[10px] font-semibold">Support</p>
            </div>
            <div class="text-center cursor-pointer" @click="toggleAccountModal()">
                <img class="inline w-8" src="{{ asset('userassets/icons/account-icon-mobile.svg') }}">
                <p class="text-[#FFFFFF] text-[10px] font-semibold">Account</p>
            </div>
        </div>
    </div>

    {{-- Navbar on desktop mode --}}
    <div class="fixed hidden lg:block left-0 top-0 bg-[#1E1F2A] h-full px-4">
        {{-- <div class="text-center mt-4 mb-8">
            <img src="{{ env('APP_SITE_LOGO') }}" alt="Logo" width="40px"
                class="inline align-text-top rounded">
        </div> --}}
        <div class="text-center mt-6 mb-8 cursor-pointer">
            <a href="/user/dashboard">
                <img class="inline w-5" src="{{ asset('userassets/icons/dashboard-icon-mobile.svg') }}">
                <p
                    class="text-[#FFFFFF] text-[10px] font-semibold">
                    Chart</p>
            </a>
        </div>
        <div class="text-center mb-8 cursor-pointer">
            <a href="/user/tradingbot">
                <img class="inline" src="{{ asset('userassets/icons/deals-icon-mobile.svg') }}">
                <p class="text-[#FFFFFF] text-[10px] font-semibold">Deals</p>
            </a>
        </div>
        <div class="text-center mb-8 cursor-pointer" onclick="closeQRCodeModal(); closeWithdrawalOTPModal();" @click="toggleRobotModal('{{Session::get('active_robot_modal')}}')">
            <img class="inline" src="{{ asset('userassets/icons/robot-icon-mobile.svg') }}">
            <p class="text-[#FFFFFF] text-[10px] font-semibold">Robot</p>
        </div>
        <div class="text-center mb-8 cursor-pointer" @click="toggleSupportPortal()">
            <img class="inline" src="{{ asset('userassets/icons/support-icon-mobile.svg') }}">
            <p class="text-[#FFFFFF] text-[10px] font-semibold">Support</p>
        </div>
        <div class="text-center mb-8 cursor-pointer" @click="toggleAccountModal()">
            <img class="inline" src="{{ asset('userassets/icons/account-icon-mobile.svg') }}">
            <p class="text-[#FFFFFF] text-[10px] font-semibold">Account</p>
        </div>
        <a href="/user/logout">
            <div class="text-center mt-64 cursor-pointer">
                <img class="inline" src="{{ asset('userassets/icons/logout-icon-mobile.svg') }}">
                <p class="text-[#FF5765] text-[10px] font-semibold">Logout</p>
            </div>
        </a>
    </div>

    <!-- Deposit modal -->
    <div id="deposit__modal" x-cloak x-show="isDepositModalOpen" class="bg-[#242533] w-full h-screen fixed top-0 z-20 lg:top-0 lg:w-96 lg:right-0">
        <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
            <div class="flex-1">
                <h1 class="text-[#FFFFFF] text-xl font-bold">Deposit to Live Account</h1>
            </div>
            <div class="flex-none">
                <a @click="isDepositModalOpen = false; depositStep = 1;" style="color: #ffffff;">&#x2715;</a>
            </div>
        </div>
        <div class="container mx-auto px-4">
            <div class="mt-6">
                <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Deposit
                    Amount</label>
                    <div class="flex items-center border-2 border-[#2A2B39] px-4 bg-[#1F202B] rounded-md">
                        <div class="flex-none w-6">
                            <span class="text-[#FFFFFF] font-bold">$</span>
                        </div>
                        <div class="flex-1">
                            <input id="deposit_amount" type="text" x-show="showDepositAmountInput" x-ref="depositAmountInput" class="w-full bg-[#1F202B] py-2 rounded-md text-[#FFFFFF] focus:outline focus:outline-0">
                        </div>
                    </div>
            </div>

            {{-- <template x-if="depositStep === 2">
                <div class="mt-6">
                    <label for="deposit_payment_method" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Payment Method</label>
                    <input x-model="depositPaymentMethod" type="hidden" id="deposit_payment_method">
                    <div class="flex-1 md:flex-none relative">
                        <div @click="toggleDepositPaymentMethodDropdown()" class="flex items-center space-x-3 border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <template x-if="depositPaymentMethodTitle === 'Bitcoin'">
                                    <img class="inline" src="{{ asset('userassets/icons/btc-icon.svg') }}" alt="" srcset=""> 
                                </template>
                                <template x-if="depositPaymentMethodTitle === 'Ethereum'">
                                    <img class="inline" src="{{ asset('userassets/icons/eth-icon.svg') }}" alt="" srcset=""> 
                                </template>
                                <template x-if="depositPaymentMethodTitle === 'USDT'">
                                    <img class="inline" src="{{ asset('userassets/icons/usdt-icon.svg') }}" alt="" srcset=""> 
                                </template>
                                <p class="inline" x-text="depositPaymentMethodTitle"></p>
                            </div>
                            <div class="flex-none justify-self-end">
                                <img class="inline" src="{{ asset('userassets/icons/chevron-down-lg.svg') }}" alt="">
                            </div>
                        </div>
                        <div x-cloak x-show="isDepositPaymentMethodDropdownOpen" @click.outside="isDepositPaymentMethodDropdownOpen = false" class="bg-[#1F202B] absolute border-2 rounded-lg border-[#2A2B39] w-full h-28 overflow-scroll z-10 p-2 mt-1">
                            @foreach ($wallets as $wallet)
                                <div x-init="selectDepositPaymentMethod('{{ $wallets[0]['coin_code'] }}', '{{ $wallets[0]['coin_name'] }}')"></div>
                                <div @click="selectDepositPaymentMethod('{{ $wallet['coin_code'] }}', '{{ $wallet['coin_name'] }}')" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-2 rounded-md text-[#FFFFFF]">
                                    <div class="flex-1">
                                        @if ($wallet['coin_code'] === 'BTC')
                                            <img class="inline" src="{{ asset('userassets/icons/btc-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'ETH')
                                            <img class="inline" src="{{ asset('userassets/icons/eth-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'USDT')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-icon.svg') }}" alt="" srcset=""> 
                                        @endif
                                        <p class="inline"> {{ $wallet['coin_name'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </template> --}}

            <template x-if="depositStep >= 2">
                <div class="mt-6">
                    <label for="deposit_payment_method" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Payment Method</label>
                    <input x-model="depositPaymentMethod" type="hidden" id="deposit_payment_method">
                    <div class="flex-1 md:flex-none relative">
                        <div class="bg-[#1F202B] absolute border-2 rounded-lg border-[#2A2B39] w-full h-auto z-10 p-2 mt-1">
                            @foreach ($wallets as $wallet)
                                <div @click="selectDepositPaymentMethod('{{ $wallet['coin_code'] }}', '{{ $wallet['coin_name'] }}')" onclick="goToQRCodeModal();" class="hover:bg-[#38394f] flex items-center space-x-3 px-2 py-2 rounded-md text-[#FFFFFF]">
                                    <div class="flex-1 flex items-center space-x-2">
                                        @if ($wallet['coin_code'] === 'BTC')
                                            <img class="inline" src="{{ asset('userassets/icons/btc-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'ETH')
                                            <img class="inline" src="{{ asset('userassets/icons/eth-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'USDT TRC20')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-trc20-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'USDT ERC20')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-erc20-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'USDT BEP20')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-bep20-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'SOL')
                                            <img class="inline" src="{{ asset('userassets/icons/sol-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'BNB')
                                            <img class="inline" src="{{ asset('userassets/icons/bnb-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'TRX')
                                            <img class="inline" src="{{ asset('userassets/icons/tron-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'LTC')
                                            <img class="inline" src="{{ asset('userassets/icons/ltc-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'XRP')
                                            <img class="inline" src="{{ asset('userassets/icons/xrp-icon.svg') }}" alt="" srcset=""> 
                                        @endif
                                        <p class="inline"> {{ $wallet['coin_name'] }}</p>
                                    </div>
                                    <div class="flex-none w-8 text-end">
                                        <template x-if="depositPaymentMethod === '{{ $wallet['coin_code'] }}'">
                                            <img class="inline" src="{{ asset('userassets/icons/check-circle-mobile.svg') }}">
                                        </template>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </template>

            <div class="mt-6 text-center">
                <template x-if="depositStep === 1">
                    <button @click="checkInputFields('deposit_amount', '');" class="bg-[#40ffdd] rounded-lg py-3 px-2 w-full">
                        <span class="text-[#000000] text-sm font-bold">Next</span>
                    </button>
                </template>
            </div>
            {{-- <div class="text-center mt-20">
                <template x-if="depositStep === 3">
                    <button onclick="goToQRCodeModal();"
                        class="bg-[#40ffdd] rounded-lg py-3 mt-36 px-2 w-full">
                        <span class="text-[#000000] text-sm font-bold">Make a deposit</span>
                    </button>
                </template>
            </div> --}}
        </div>
    </div>

    <!-- Deposit(QR code/copy address) modal -->
    <div id="deposit__qrcode__modal" class="bg-[#242533] hidden w-full h-screen fixed top-0 z-20 lg:top-0 lg:w-96 lg:right-0">
        <form id="deposit__data__form" action="{{ url('/user/deposit') }}" method="post">
            @csrf
            <input type="hidden" value="" id="deposit__amount__submit" name="amount">
            <input type="hidden" value="" id="payment__method__submit" name="wallet">
        </form>

        <div class="flex items-center space-x-6 container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
            <a @click="goBackDeposit()"><img src="{{ asset('userassets/icons/chevron-left.svg') }}"></a>
            <h1 class="text-[#FFFFFF] text-xl font-bold">Deposit to Live Account</h1>
        </div>
        
        <div class="container mx-auto px-4">
            <div class="text-center mt-4 md:mt-24 lg:mt-4">
                <p class="text-[#FFFFFF] text-xs my-6">Scan QR code or copy wallet address below</p>
            </div>
            <div class="my-8 text-center flex items-center justify-center">
                <div class="w-24 h-24 bg-[#FFFFFF] p-2 flex rounded-md">
                    <div class="w-36 h-36" id="qrcode"></div>
                </div>
            </div>
            <div class="text-center">
                <p class="text-[#FFFFFF] text-sm font-semibold my-6">Send <span id="amount_to_send"></span> to the wallet address provided below</p>
            </div>

            <div class="flex mt-6 border-2 border-[#2A2B39] rounded-md focus:outline-0">
                <div class="flex-1"><input class="w-full text-xs rounded-md rounded-tr-none rounded-br-none px-4 py-3 bg-[#1F202B] text-[#FFFFFF]"
                    id="wallet_address" type="text" readonly></div>
                <div onclick="copyWalletAddress()" class="flex-none w-12 rounded-tr-md rounded-br-md bg-[#1F202B] flex items-center justify-center"><img src="{{ asset('userassets/icons/duplicate.svg') }}"></div>
            </div>

            <div class="border border-[#40ffdd] text-[#FFFFFF] rounded-lg p-4 mt-6" role="alert" tabindex="-1" aria-labelledby="hs-actions-label">
                <div class="flex">
                  <div class="shrink-0">
                    <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#40ffdd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10"></circle>
                      <path d="M12 16v-4"></path>
                      <path d="M12 8h.01"></path>
                    </svg>
                  </div>
                  <div class="ms-2">
                    <div class="text-xs text-gray-600 dark:text-neutral-400">
                      <span class="font-bold">NB</span>: If you have made the payment to the wallet specified, please click on the "Yes I have paid" button below to confirm the payment.
                    </div>
                  </div>
                </div>
              </div>

            <div class="mt-6 md:mt-80 lg:mt-6 text-center">
                {{-- <img class="inline" src="{{ asset('userassets/icons/lock-closed.svg') }}">
                <p class="text-[#FFFFFF] text-xs my-6">Your data is encrypted using 256-bit SSL certificates, providing
                    you with the strongest security available</p> --}}
                <button :disabled="isSubmitDepositDataButtonDisabled" @click="isSubmitDepositDataButtonDisabled = true; submitDepositData();" class="rounded-lg py-3 px-2 w-full" :class="isSubmitDepositDataButtonDisabled ? 'bg-[#2c917e] cursor-not-allowed' : 'bg-[#40ffdd] cursor-pointer'">
                    <span class="text-[#000000] text-sm font-bold">Yes I have paid</span> <span id="amount_to_send_btn" class="text-[#000000] text-sm font-bold"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Withdrawal modal -->
    <div id="withdraw__modal" x-cloak x-show="isWithdrawModalOpen" @click.outside="isWithdrawModalOpen = false" class="bg-[#242533] w-full h-screen fixed top-0 z-20 lg:top-0 lg:w-96 lg:right-0">
        <input type="hidden" id="livebalance" value="{{ $user['balance'] }}">
        <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
            <div class="flex-1">
                <h1 class="text-[#FFFFFF] text-xl font-bold">Withdraw</h1>
            </div>
            <div class="flex-none">
                <a @click="isWithdrawModalOpen = false; withdrawStep = 1;" style="color: #ffffff;">&#x2715;</a>
            </div>
        </div>
        <div class="container mx-auto px-4">
            <div class="flex mt-6">
                <div class="flex-1 text-sm text-[#FFFFFF]">
                    Balance
                </div>
                <div class="flex-1 font-bold text-[#FFFFFF] text-end">@money($user['balance'])</div>
            </div>
            <div class="mt-6">
                <label for="" class="text-[#FFFFFF] text-xs block mb-3 font-normal">
                    Amount</label>
                <div class="flex items-center border-2 border-[#2A2B39] px-4 bg-[#1F202B] rounded-md">
                    <div class="flex-none w-6">
                        <span class="text-[#FFFFFF] font-bold">$</span>
                    </div>
                    <div class="flex-1">
                        <input id="withdraw_amount" type="text" x-show="showWithdrawAmountInput" x-ref="withdrawAmountInput" class="w-full bg-[#1F202B] py-2 rounded-md text-[#FFFFFF] focus:outline focus:outline-0">
                    </div>
                </div>
                {{-- <input id="withdraw_amount" type="text" x-show="showWithdrawAmountInput" x-ref="withdrawAmountInput"
                    class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" required> --}}
            </div>

            <template x-if="withdrawStep >= 2">
                <div class="mt-6">
                    <label for="withdraw_payment_method" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Payment Method</label>
                    <input x-model="withdrawPaymentMethod" type="hidden" id="withdraw_payment_method">
                    <div class="flex-1 md:flex-none relative">
                        <div x-cloak class="bg-[#1F202B] absolute border-2 rounded-lg border-[#2A2B39] w-full h-48 overflow-scroll z-10 p-2 mt-1">
                            @foreach ($wallets as $wallet)
                                <div @click="selectWithdrawPaymentMethod('{{ $wallet['coin_code'] }}', '{{ $wallet['coin_name'] }}')" class="hover:bg-[#38394f] flex items-center space-x-3 px-2 py-2 rounded-md text-[#FFFFFF]">
                                    <div class="flex-1 flex items-center space-x-2">
                                        @if ($wallet['coin_code'] === 'BTC')
                                            <img class="inline" src="{{ asset('userassets/icons/btc-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'ETH')
                                            <img class="inline" src="{{ asset('userassets/icons/eth-icon.svg') }}" alt="" srcset=""> 
                                            @elseif ($wallet['coin_code'] === 'USDT TRC20')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-trc20-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'USDT ERC20')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-erc20-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'USDT BEP20')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-bep20-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'SOL')
                                            <img class="inline" src="{{ asset('userassets/icons/sol-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'BNB')
                                            <img class="inline" src="{{ asset('userassets/icons/bnb-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'TRX')
                                            <img class="inline" src="{{ asset('userassets/icons/tron-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'LTC')
                                            <img class="inline" src="{{ asset('userassets/icons/ltc-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'XRP')
                                            <img class="inline" src="{{ asset('userassets/icons/xrp-icon.svg') }}" alt="" srcset=""> 
                                        @endif
                                        <p class="inline"> {{ $wallet['coin_name'] }}</p>
                                    </div>
                                    <div class="flex-none w-8 text-end">
                                        <template x-if="withdrawPaymentMethod === '{{ $wallet['coin_code'] }}'">
                                            <img class="inline" src="{{ asset('userassets/icons/check-circle-mobile.svg') }}">
                                        </template>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="withdrawStep >= 3">
                <div class="mt-[14.5rem]">
                    <label for="" class="text-[#FFFFFF] text-xs block mb-3 font-normal">
                        Input Wallet Address</label>
                    <input id="withdraw_payout_address" type="text"
                        class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" required>
                </div>
            </template>

            {{-- <template x-if="withdrawStep === 2 || withdrawStep === 3">
                <div class="mt-6">
                    <label for="withdraw_payment_method" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Payment Method</label>
                    <input x-model="withdrawPaymentMethod" type="hidden" id="withdraw_payment_method">
                    <div class="flex-1 md:flex-none relative">
                        <div @click="toggleWithdrawPaymentMethodDropdown()" class="flex items-center space-x-3 border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <template x-if="withdrawPaymentMethodTitle === 'Bitcoin'">
                                    <img class="inline" src="{{ asset('userassets/icons/btc-icon.svg') }}" alt="" srcset=""> 
                                </template>
                                <template x-if="withdrawPaymentMethodTitle === 'Ethereum'">
                                    <img class="inline" src="{{ asset('userassets/icons/eth-icon.svg') }}" alt="" srcset=""> 
                                </template>
                                <template x-if="withdrawPaymentMethodTitle === 'USDT'">
                                    <img class="inline" src="{{ asset('userassets/icons/usdt-icon.svg') }}" alt="" srcset=""> 
                                </template>
                                <p class="inline" x-text="withdrawPaymentMethodTitle"></p>
                            </div>
                            <div class="flex-none justify-self-end">
                                <img class="inline" src="{{ asset('userassets/icons/chevron-down-lg.svg') }}" alt="">
                            </div>
                        </div>
                        <div x-cloak x-show="isWithdrawPaymentMethodDropdownOpen" @click.outside="isWithdrawPaymentMethodDropdownOpen = false" class="bg-[#1F202B] absolute border-2 rounded-lg border-[#2A2B39] w-full h-28 overflow-scroll z-10 p-2 mt-1">
                            @foreach ($wallets as $wallet)
                                <div x-init="selectWithdrawPaymentMethod('{{ $wallets[0]['coin_code'] }}', '{{ $wallets[0]['coin_name'] }}')"></div>
                                <div @click="selectWithdrawPaymentMethod('{{ $wallet['coin_code'] }}', '{{ $wallet['coin_name'] }}')" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-2 rounded-md text-[#FFFFFF]">
                                    <div class="flex-1">
                                        @if ($wallet['coin_code'] === 'BTC')
                                            <img class="inline" src="{{ asset('userassets/icons/btc-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'ETH')
                                            <img class="inline" src="{{ asset('userassets/icons/eth-icon.svg') }}" alt="" srcset=""> 
                                        @elseif ($wallet['coin_code'] === 'USDT')
                                            <img class="inline" src="{{ asset('userassets/icons/usdt-icon.svg') }}" alt="" srcset=""> 
                                        @endif
                                        <p class="inline"> {{ $wallet['coin_name'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="withdrawStep === 3">
                <div class="mt-6">
                    <label for="" class="text-[#FFFFFF] text-xs block mb-3 font-normal">
                        Payout Address</label>
                    <input id="withdraw_payout_address" type="text"
                        class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" required>
                </div>
            </template> --}}


            <div class="mt-6 text-center">
                {{-- <img class="inline" src="{{ asset('userassets/icons/lock-closed.svg') }}">
                <p class="text-[#FFFFFF] text-xs my-6">Your data is encrypted using 256-bit SSL certificates, providing
                    you with the strongest security available</p> --}}
                <template x-if="withdrawStep === 1 || withdrawStep === 2">
                    <button @click="checkInputFields('withdraw_amount', '{{ $user['balance'] }}');" class="bg-[#40ffdd] rounded-lg py-3 px-2 w-full">
                        <span class="text-[#000000] text-sm font-bold">Next</span>
                    </button>
                </template>
                <template x-if="withdrawStep === 3">
                    <button onclick="checkFieldsAndSendOtp('{{ auth()->user()->status }}')" @click="$nextTick(() => { $refs.otpInput.focus(); });"
                        class="bg-[#40ffdd] rounded-lg py-3 px-2 w-full">
                        <span class="text-[#000000] text-sm font-bold">Withdraw</span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Withdrawal modal(OTP) -->
    <div id="withdraw__otp__modal" class="bg-[#242533] hidden w-full h-screen fixed top-0 z-20 lg:top-0 lg:w-96 lg:right-0">
        <form id="withdraw__data__form" action="{{ url('/user/withdraw') }}" method="post">
            @csrf
            <input type="hidden" value="" id="withdraw__amount" name="amount">
            <input type="hidden" value="" id="withdraw__payment__method" name="walletname">
            <input type="hidden" value="" id="withdraw__payout__address" name="walletaddress">
            <input type="hidden" value="" id="withdraw__otp" name="withdrawotp">
        </form>
        <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
            <h1 class="text-[#FFFFFF] text-xl font-bold">Enter your Verification Code</h1>
        </div>
        <div class="container mx-auto px-4">
            <div class="mt-6">
                <label for="" class="text-[#FFFFFF] text-xs block mb-3 font-normal">
                    Check your email for your verification code</label>
                <input id="withdraw_otp" type="text" x-ref="otpInput"
                    class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" required>
            </div>
            <div class="w-full mt-2 text-end">
                <a onclick="resendotp()"><p class="text-[#FFFFFF] text-xs">Didn't get code? <span class="text-[#209895] cursor-pointer text-xs underline">Resend code</span></p></a>
            </div>

            <div class="mt-6 text-center">
                {{-- <img class="inline" src="{{ asset('userassets/icons/lock-closed.svg') }}">
                <p class="text-[#FFFFFF] text-xs my-6">Your data is encrypted using 256-bit SSL certificates, providing
                    you with the strongest security available</p> --}}
                <button :disabled="isSubmitWithdrawalDataButtonDisabled" @click="isSubmitWithdrawalDataButtonDisabled = true; submitWithdrawalData();"
                    class="rounded-lg py-3 px-2 w-full" :class="isSubmitWithdrawalDataButtonDisabled ? 'bg-[#2c917e] cursor-not-allowed' : 'bg-[#40ffdd] cursor-pointer'">
                    <span class="text-[#000000] text-sm font-bold">Confirm</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Support Iframe -->
    <div x-cloak x-show="isSupportPortalOpen" class="bg-[#242533] w-full h-screen bottom-0 lg:mb-0 lg:h-screen fixed z-50 lg:top-0 lg:w-96 lg:right-0">
        <div class="flex items-center container md:max-w-full mx-auto mt-24 lg:mt-0 px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
            <div class="flex-1">
            </div>
            <div class="flex-none">
                <a @click="isSupportPortalOpen = false" style="color: #ffffff;">&#x2715;</a>
            </div>
        </div>
        <iframe class="h-[calc(100vh-154px)] lg:h-[90%]" frameborder="0" width="100%" height="100%" src="https://tawk.to/chat/67afcaa34cf39019080d5414/1ik4jd2pu"></iframe>
    </div>

    <!-- Robot modal -->
    <div x-cloak x-show="isRobotModalOpen" x-init="showRobotModalOnLoad('{{ Session::get('display_robot_modal') }}')" class="bg-[#242533] w-full h-screen fixed top-20 z-20 lg:top-0 lg:w-96 lg:left-[72px]">
        <div class="max-h-[90vh] pb-40 overflow-scroll">
            <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
                <div class="flex-1">
                    <h1 class="text-[#FFFFFF] text-xl font-bold inline">Robot Settings</h1>
                </div>
                <div class="flex-none">
                    <span @click="isHowToUseModalOpen = true" class="text-[#98A4B3] cursor-pointer text-xs inline-block mr-6">&#x24D8; How it works?</span>
                    <a @click="isRobotModalOpen = false" style="color: #ffffff;">&#x2715;</a>
                </div>
            </div>
            <input id="strategy_min_amount" type="hidden">
            <form id="execute__trade__form" action="{{ url('/user/robot') }}" method="post">
                @csrf
                <input id="strategy_trade_amount" x-model="selectedStrategy.tradeAmount" type="hidden" name="amount">
                <input id="strategy_trade_account" x-model="selectedStrategy.account" type="hidden" name="account">
                <input x-model="selectedStrategy.accumulatedDuration" type="hidden" name="duration">
                <input x-model="selectedStrategy.id" type="hidden" name="strategy_id">
            </form>
            <div class="container mx-auto px-4">
                <div class="flex mt-3 space-x-1">
                    <div class="flex-1">
                        <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Amount</label>
                        <div class="flex items-center border-2 border-[#2A2B39] px-4 bg-[#1F202B] rounded-md">
                            <div class="flex-none w-6">
                                <span class="text-[#FFFFFF] font-bold">$</span>
                            </div>
                            <div class="flex-1">
                                <input x-model="selectedStrategy.tradeAmount" id="trade_amount" type="text" class="w-full bg-[#1F202B] py-2 rounded-md text-[#FFFFFF] focus:outline focus:outline-0" required>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Account</label>
                        <div class="flex-1 md:flex-none relative">
                            <div @click="toggleAccountDropdown()" class="flex items-center space-x-3 border border-[#40ffdd] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF]">
                                <div class="flex-1">
                                    <template x-if="!selectedAccountBoolean">
                                        <p class="text-sm">Demo Account</p>
                                    </template>
                                    <template x-if="selectedAccountBoolean">
                                        <p class="text-sm">Live Account</p>
                                    </template>
                                </div>
                                <div class="flex-none justify-self-end">
                                    <img class="inline" src="{{ asset('userassets/icons/chevron-down-lg.svg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div x-cloak x-show="isAccountDropdownOpen" @click.outside="isAccountDropdownOpen = false" class="bg-[#1F202B] absolute border-2 rounded-lg border-[#2A2B39] w-full h-24 overflow-scroll z-10 p-2 mt-1">
                        <div x-init="selectTradingAccountOnLoad('{{ auth()->user()->balance }}')" @click="selectTradingAccount(false)" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-2 rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <p class="text-sm">Demo Account - @money($user['demo_balance'])</p>
                            </div>
                            <div class="flex-none w-8 text-end">
                                <template x-if="selectedAccountBoolean === false">
                                    <img class="inline" src="{{ asset('userassets/icons/check-circle-mobile.svg') }}">
                                </template>
                            </div>
                        </div>
                        <div @click="selectTradingAccount(true)" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-2 rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <p class="text-sm">Live Account - @money($user['balance'])</p>
                            </div>
                            <div class="flex-none w-8 text-end">
                                <template x-if="selectedAccountBoolean === true">
                                    <img class="inline" src="{{ asset('userassets/icons/check-circle-mobile.svg') }}">
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="flex mt-3 space-x-1">
                    <div class="flex-1">
                        <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Duration</label>
                        {{-- <div @click="toggleDurationDropdown()" class="flex items-center space-x-3 border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <p class="text-sm" x-text="durationTitle"></p>
                            </div>
                            <div class="flex-none justify-self-end">
                                <img class="inline" src="{{ asset('userassets/icons/chevron-down-lg.svg') }}" alt="">
                            </div>
                        </div> --}}
                        <div x-init="selectTradingDuration(5, '5 min')" class="flex items-center space-x-3 border-2 border-[#2A2B39] px-4 py-2.5 bg-[#1F202B] rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <p class="text-sm">24 hours</p>
                            </div>
                            {{-- <div class="flex-none justify-self-end">
                                <img class="inline" src="{{ asset('userassets/icons/chevron-down-lg.svg') }}" alt="">
                            </div> --}}
                        </div>
                    </div>
                    <div class="flex-1 text-center">
                        <label for="exchange" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Exchange</label>
                        <div class="w-full text-sm self-center text-center border-2 border-[#2A2B39] px-4 py-2.5 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]">
                            <img class="inline" src="{{ asset('userassets/icons/binance-logo.svg') }}" alt="binance-logo">
                        </div>
                    </div>
                    <div class="flex-1 text-center">
                        <label for="broker" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Broker</label>
                        <div class="w-full text-sm text-center self-center border-2 border-[#2A2B39] px-4 py-2.5 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]">
                            <img class="inline" src="{{ asset('userassets/icons/fxpro.svg') }}" alt="">
                        </div>
                    </div>
                </div>
                
                {{-- <div class="relative">
                    <div x-cloak x-show="isDurationDropdownOpen" @click.outside="isDurationDropdownOpen = false" class="bg-[#1F202B] absolute border-2 rounded-lg border-[#2A2B39] w-full h-28 overflow-scroll z-10 p-2 mt-1">
                        <div x-init="selectTradingDuration(1, '1 min')" @click="selectTradingDuration(1, '1 min')" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-2 rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <p class="mb-1 text-sm">1 min</p>
                            </div>
                        </div>
                        <div @click="selectTradingDuration(5, '5 mins')" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-2 rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <p class="mb-1 text-sm">5 mins</p>
                            </div>
                        </div>
                        <div @click="selectTradingDuration(15, '15 mins')" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-2 rounded-md text-[#FFFFFF]">
                            <div class="flex-1">
                                <p class="mb-1 text-sm">15 mins</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
    
                <div class="mt-3">
                    <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Select Strategy</label>
                    <div class="flex-1 md:flex-none relative">
                        <div @click="toggleStrategyDropdown()" class="flex items-center space-x-2 border border-[#40ffdd] px-4 py-4 bg-[#1F202B] rounded-md text-[#FFFFFF]">
                            <div class="flex-none w-12">
                                <img :src="selectedStrategy.image || '{{ $plans[0]['image'] }}'" alt="">
                                {{-- <img src="{{ asset('userassets/icons/strategy-image.svg') }}" alt=""> --}}
                            </div>
                            <div class="flex-1">
                                <h2 class="font-bold mb-1" x-text="selectedStrategy.name || '{{ $plans[0]['name'] }}'"></h2>
                                <p class="text-xs mb-1"><img class="inline" src="{{ asset('userassets/icons/presentation-chart-line.svg') }}"> Profit Range: <span x-text="selectedStrategy.minRoi || '{{ $plans[0]['min_roi_percentage'] }}'"></span>% to <span x-text="selectedStrategy.maxRoi || '{{ $plans[0]['max_roi_percentage'] }}'"></span>% in  <span x-text="selectedStrategy.totalDuration || '{{ $plans[0]['plan_duration'] }}'"></span>hrs</p>
                                <p class="text-xs"><img class="inline" src="{{ asset('userassets/icons/currency-dollar.svg') }}"> Minimum Amount: At least $<span x-text="selectedStrategy.minAmount || '{{ $plans[0]['min_amount'] }}'"></span></p>
                            </div>
                            <div class="flex-none w-4 justify-self-end">
                                <img class="inline" src="{{ asset('userassets/icons/chevron-down-lg.svg') }}" alt="">
                            </div>
                        </div>
                    </div> 
                </div>
    
                <div class="mt-3">
                    <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Profit Return</label>
                        <div class="flex items-center space-x-3 border-2 border-[#2A2B39] px-4 py-4 bg-[#1F202B] rounded-md text-[#FFFFFF]">
                            <div class="flex-none w-12">
                                <img src="{{ asset('userassets/icons/profit-return.svg') }}" alt="">
                            </div>
                            <div class="flex-1">
                                <h2 class="font-bold mb-1">Profit & Capital</h2>
                                <p class="text-xs mb-1"><img class="inline" src="{{ asset('userassets/icons/clock-icon.svg') }}"> Profit is made every <span x-text="selectedStrategy.accumulatedDuration"></span> minutes.</p>
                                <p class="text-xs"><img class="inline" src="{{ asset('userassets/icons/cube-icon.svg') }}"> Capital Returned After Trade: Yes</p>
                            </div>
                            <div class="flex-none justify-self-end">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mx-auto px-4 mt-2 md:mt-72 lg:mt-4">
                    <div class="text-center">
                        <button id="submit_trade_button" :disabled="isStartTradeButtonDisabled" @click="isStartTradeButtonDisabled = true; submitTradeRequest('{{ auth()->user()->balance }}', '{{ auth()->user()->demo_balance }}', '{{ auth()->user()->status }}')"
                            class="rounded-lg py-3 px-2 w-full" :class="isStartTradeButtonDisabled ? 'bg-[#2c917e] cursor-not-allowed' : 'bg-[#40ffdd] cursor-pointer'">
                            <span class="text-[#000000] text-sm font-bold">Start Trade</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-show="isStrategyDropdownOpen" @click="isStrategyDropdownOpen = false" class="w-full bg-[#1e293a] bg-opacity-50 h-screen flex justify-center items-center fixed top-0 z-50">
        <div class="bg-[#1F202B] border-2 rounded-lg border-[#2A2B39] h-auto md:w-[26rem] lg:w-[28rem] z-10 mt-1">
            @foreach ($plans as $plan)
            <div x-init="selectStrategy('{{$plans[0]['id']}}', '{{$plans[0]['name']}}', '{{$plans[0]['min_roi_percentage']}}', '{{$plans[0]['max_roi_percentage']}}', '{{$plans[0]['plan_duration']}}', '{{$plans[0]['min_amount']}}', '{{$plans[0]['image']}}')" @click="selectStrategy('{{$plan['id']}}', '{{$plan['name']}}', '{{$plan['min_roi_percentage']}}', '{{$plan['max_roi_percentage']}}', '{{$plan['plan_duration']}}', '{{$plan['min_amount']}}', '{{$plan['image']}}')" class="hover:bg-[#38394f] flex items-center space-x-3 px-4 py-3 rounded-md text-[#FFFFFF]">
                {{-- <div class="flex-none w-12">
                    <img src="{{{ $plan['image'] }}}" alt="">
                </div> --}}
                {{-- <div class="flex-1">
                    <p class="mb-1 text-sm">{{ $plan['name'] }}</p>
                </div> --}}

                <div class="flex-none w-12">
                    <img src="{{ $plan['image'] }}" alt="">
                    {{-- <img src="{{ asset('userassets/icons/strategy-image.svg') }}" alt=""> --}}
                </div>
                <div class="flex-1">
                    <h2 class="font-bold mb-1">{{ $plan['name'] }}</h2>
                    <p class="text-xs mb-1"><img class="inline" src="{{ asset('userassets/icons/presentation-chart-line.svg') }}"> Profit Range: <span x-text="{{ $plan['min_roi_percentage'] }}"></span>% to <span x-text="{{ $plan['max_roi_percentage'] }}"></span>% in  <span x-text="{{ $plans[0]['plan_duration'] }}"></span>hrs</p>
                    <p class="text-xs"><img class="inline" src="{{ asset('userassets/icons/currency-dollar.svg') }}"> Minimum Amount: At least $<span x-text="{{ $plan['min_amount'] }}"></span></p>
                </div>
            </div>
            <hr class="border border-[#2A2B39]">
            @endforeach
        </div>
    </div>

    <!-- Robot modal(active bot trade) -->
    <div x-cloak x-show="isActiveBotTradeModalOpen" class="bg-[#242533] w-full h-screen fixed top-20 z-20 lg:top-0 lg:w-96 lg:left-[72px]">
        @foreach ($tradingbots as $bot)
            <input type="hidden" name="tradingbot_id" id="tradingbot_id" value="{{ $bot['id'] }}">
        @endforeach
        <div>
            <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
                <div class="flex-1">
                    <h1 class="text-[#FFFFFF] text-xl font-bold">Active Robot</h1>
                </div>
                <div class="flex-none">
                    <a @click="isActiveBotTradeModalOpen = false" style="color: #ffffff;">&#x2715;</a>
                </div>
            </div>
            <div class="container mx-auto px-4 pb-40 max-h-[80vh] overflow-scroll">
                <div class="flex mt-2">
                    <div class="flex-1">
                        <p class="text-[#FFFFFF] text-3xl font-bold">$<span id="total_amount"></span></p>
                    </div>
                    <div class="flex-none">
                        <p class="text-sm text-[#FFFFFF] font-bold">Profits:</p>
                        <p class="text-sm text-[#28BD66] font-bold">$<span id="profit">0.00</span></p>
                    </div>
                </div>
    
                <div id="timer_loading" class="text-center mt-8 hidden">
                    <img src="{{ asset('homeassets/img/searching.gif') }}" class="w-16 inline" alt="">
                    <p class="text-xs mt-3 font-semibold text-[#FFFFFF]">Robot is searching for signals...</p>
                </div>
    
                <div id="timer_counter">
                    <div id="trading-indicator" class="mb-2">
                        <div class="flex h-16 justify-center">
                            <img src="{{ asset('homeassets/img/trading.gif') }}" class=" rounded-md inline" alt="">
                            {{-- <div class="w-auto h-12">
                                <dotlottie-wc class="w-auto h-12" src="{{ asset('homeassets/img/trading.lottie') }}" autoplay loop></dotlottie-wc> 
                            </div> --}}
                        </div>
                        <div class="text-center -mt-2">
                            <p class="text-xs font-semibold text-[#FFFFFF]">Robot is now trading...</p>
                        </div>
                    </div>
                    <div class="timer_cover items-center flex space-x-3 bg-[#1F202B] px-4 pr-6 rounded-lg border-2 border-[#2A2B39]">
                        <div class="timer_counter flex-none w-[80px]">
                            <div class="timer">
                                {{-- <div class="donat outer-circle"> --}}
                                    <div class="">
                                        <p id="countdown_timer" class="clock-time clock-timer mb-0 text-2xl font-bold"></p>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="flex-1 flex space-x-2 items-center justify-end">
                            {{-- <div class="flex-none">
                                <img id="trading_image" width="25px" src="https://olympbot.com/icons/assets/EURUSD_OTC.svg" alt="">
                            </div> --}}
                            <div class="text-[#FFFFFF] text-sm flex-none text-center">
                                <div>
                                    <p class="text-xs">Robot is trading</p>
                                </div>
                                <img class="inline" id="trading_image" width="20px" src="" alt=""> <p class="inline font-bold" id="trading_asset"></p>
                                {{-- <p class="text-[#28BD66]" id="trading_percentage"></p> --}}
                                <p class="text-xs font-bold" id="trading_action"></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 flex justify-center items-center px-4">
                        <a id="viewassettradebtn" href="">
                            <button type="submit" class="bg-[#40ffdd] rounded-lg py-2 px-4">
                                <img class="inline" src="{{ asset('userassets/icons/trade-chart-icon.svg') }}" /><span class="text-[#000000] text-xs font-bold"> Show the trade on the chart</span>
                            </button>
                        </a>
                    </div>
                </div>
    
                <div class="mt-2">
                    <div class="flex py-2 border-b-2 border-b-[#2A2B39]">
                        <div class="flex-1 text-sm text-[#FFFFFF]">Account</div>
                        <div class="flex-1 text-end text-sm text-[#FFFFFF]">{{ $tradingbots && $tradingbots[0]['account_type'] === 'demo' ? 'Demo' : 'Live' }} Account</div>
                    </div>
                    <div class="flex py-2 border-b-2 border-b-[#2A2B39]">
                        <div class="flex-1 text-sm text-[#FFFFFF]">Amount</div>
                        <div id="details_amount" class="flex-1 text-end text-sm text-[#FFFFFF]"></div>
                    </div>
                    <div class="flex py-2 border-b-2 border-b-[#2A2B39]">
                        <div class="flex-1 text-sm text-[#FFFFFF]">Strategy</div>
                        <div id="details_strategy" class="flex-1 text-end text-sm text-[#FFFFFF]"></div>
                    </div>
                    <div class="flex py-2 border-b-2 border-b-[#2A2B39]">
                        <div class="flex-1 text-sm text-[#FFFFFF]">Profit Limit</div>
                        <div id="details_profit_limit" class="flex-1 text-end text-sm text-[#FFFFFF]"></div>
                    </div>
                    <div class="flex py-2 border-b-2 border-b-[#2A2B39]">
                        <div class="flex-1 text-sm text-[#FFFFFF]">Fees - 1%(charged from profits)</div>
                        <div id="company_commission" class="flex-none text-end text-sm text-[#FFFFFF]"></div>
                    </div>
                    {{-- <div class="flex py-2 border-b-2 border-b-[#2A2B39]">
                        <div class="flex-1 text-sm text-[#FFFFFF]">Robot Expires In</div>
                        <div id="robot_expires" class="flex-none text-end text-sm text-[#FFFFFF]"></div>
                    </div> --}}
                </div>
    
                <div class="text-center mt-4 md:mt-72 lg:mt-4">
                    <button @click="toggleCancelModal()" class="bg-[#FB4B4E] rounded-lg py-3 px-2 w-full">
                        <span class="text-[#FFFFFF] text-sm font-bold">Stop Robot</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-show="isCancelModalOpen" @click="isCancelModalOpen = false" class="w-full h-screen flex justify-center items-center bg-[#1e293a] bg-opacity-50 fixed top-0 z-50">
        <div class="w-80 h-auto bg-[#38394b] p-6 rounded-md">
            <div class="text-center">
                <p class="text-sm text-[#FFFFFF]">
                    Are you sure you want to stop the robot at $<span id="stop_robot_profit" class="font-bold"></span> profit? 
                    {{-- 1% Fees Total Profits is <span id="stop_robot_commission" class="font-bold"></span> --}}
                </p>
            </div>
            <div class="mt-3">
                    <form id="stop__robot__form" method="post" action="{{ url('/user/stoprobot') }}">
                        @csrf
                        <input type="hidden" name="tradingbot_id" value="{{ $tradingbots ? $tradingbots[0]['id'] : '' }}">
                        <input id="robot_stopped_at" type="hidden" name="robot_stopped_at" value="">
                        <button type="submit" class="bg-[#FB4B4E] rounded-lg py-2 px-2 w-full">
                            <span class="text-[#FFFFFF] text-sm font-normal">Yes, stop robot</span>
                        </button>
                    </form>
            </div>
            <div class="mt-1">
                <button @click="toggleCancelModal()" class="bg-transparent rounded-lg py-3 px-2 w-full">
                    <span class="text-[#FFFFFF] text-sm font-bold">Cancel</span>
                </button>
            </div>
        </div>
    </div>

    <div x-cloak x-init="showHowToUseModalOnJustRegistered('{{ Session::get('just_registered') }}')" x-show="isHowToUseModalOpen" class="w-full h-screen flex justify-center items-start bg-[#1e293a] bg-opacity-50 fixed top-0 z-50">
        <div class="h-auto bg-[#38394b] px-4 mt-4 py-3 md:p-6 rounded-md w-[22rem] md:w-[30rem]">
            <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-12">
                <div class="flex-1">
                </div>
                <div class="flex-none">
                    <a @click="isHowToUseModalOpen = false" style="color: #ffffff;">&#x2715;</a>
                </div>
            </div>
            <div class="text-left">
                <div class="text-center">
                    <h2 class="text-[#FFFFFF] text-lg font-bold underline">How to Use the Nxcai Robot and Start Earning Profits:</h2>
                </div>
                <h4 class="my-2 text-[#FFFFFF] text-sm font-bold">How to start the robot?</h4>
                <p class="text-sm my-2 text-[#FFFFFF]">
                    Step 1: Enter your trade amount.
                </p>
                <p class="text-sm my-2 text-[#FFFFFF]">
                    Step 2: Select a strategy: Strategy depends on your trade amount, Choose one that matches your trade amount.
                </p>
                <p class="text-sm my-2 text-[#FFFFFF]">
                    Step 3: Activate the robot. Click "Start Robot," and it will begin trading on your behalf, generating profits every 5 minutes.
                </p>
                <h2 class="text-[#FFFFFF] text-md font-bold underline">Important Notes:</h2>
                
                <p class="text-sm my-2 text-[#FFFFFF]">
                    1.Your capital is always returned after each trade.
                </p>
                <p class="text-sm my-2 text-[#FFFFFF]">
                    2.You can stop the robot at any time.
                </p>
                <p class="text-sm my-2 text-[#FFFFFF]">
                    3.The robot generates profits every 5 minutes.
                </p>
                <p class="text-sm my-2 text-[#FFFFFF]">
                    4.After starting the robot, you don’t need to do anything else. It will automatically trade and accumulate profits for you until it reaches the profit limit.
                </p>
                <p class="text-sm my-2 text-[#FFFFFF]">
                    5.There are both Live and Demo accounts available. To make real profits, deposit funds into your Live account and start using the robot.
                </p>
                <p class="text-sm my-2 text-[#FFFFFF]">Feel free to contact us if you need any help with using the Nxcai Robot!</p>
            </div>
        </div>
    </div>

    <!-- Account modal -->
    <div x-cloak x-show="isAccountModalOpen" @click.outside="isAccountModalOpen = false" class="bg-[#242533] w-full h-screen fixed top-20 z-20 lg:top-0 lg:w-96 lg:right-0">
        <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:px-4 h-16 border-b-2 border-b-[#2A2B39]">
            <div class="flex-1">
                <h1 class="text-[#FFFFFF] text-xl font-bold">Account</h1>
            </div>
            <div class="flex-none">
                <a @click="isAccountModalOpen = false" style="color: #ffffff;">&#x2715;</a>
            </div>
        </div>
        <div class="container mx-auto px-4 pb-40 max-h-[80vh] lg:h-auto overflow-y-auto">
            <div class="mt-4 flex items-center space-x-3">
                <div class="flex-none">
                    <img src="{{ asset('userassets/icons/account-icon-full.svg') }}" alt="">
                </div>
                <div class="flex-1 text-[#FFFFFF]">
                    <div class="font-bold">{{ auth()->user()->username }}</div>
                    <div class="text-sm">
                        <span class="text-[#98A4B3]">ID</span> <div class="inline bg-[#40ffdd] text-[#000000] rounded-lg py-1 text-xs px-2 w-full">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="flex-none">
                    <img src="{{ asset('homeassets/img/Ctxailogo.png') }}" alt="Logo" width="40px"
                        class="d-inline-block align-text-top lg:hidden">
                </div>
            </div>

            <div class="my-6">
                <div class="text-[#FFFFFF] font-bold mb-1">Referral link</div>
                <div class="flex border-2 border-[#2A2B39] rounded-md focus:outline-0">
                    <div class="flex-1"><input id="userref" value="https://nxcai.com/user/register/{{ $user['refcode'] }}" class="w-full text-xs rounded-md rounded-tr-none rounded-br-none px-4 py-4 bg-[#1F202B] text-[#98A4B3]" type="text" readonly></div>
                    <div onclick="copyref()" class="flex-none w-12 rounded-tr-md rounded-br-md bg-[#1F202B] flex items-center justify-center"><img src="{{ asset('userassets/icons/duplicate.svg') }}"></div>
                </div>
            </div>

            <div class="flex">
                <div class="flex-1 text-sm text-[#FFFFFF]">
                    Balance
                </div>
                <div class="flex-1 font-bold text-[#FFFFFF] text-end">@money($user['balance'])</div>
            </div>

            <div class="my-6">
                <button @click="isAccountModalOpen = false; isRobotModalOpen = false; toggleWithdrawModal(); showWithdrawAmountInput = true; $nextTick(() => { $refs.withdrawAmountInput.scrollIntoView({ behavior: 'smooth', block: 'center' }); setTimeout(() => $refs.withdrawAmountInput.focus(), 100) });" class="bg-[#40ffdd] rounded-lg py-3 px-2 w-full text-center">
                    <img src="{{ asset('userassets/icons/withdraw-icon-mobile.svg') }}" class="inline" alt="">
                    <span class="text-[#000000] text-sm font-bold inline">Withdraw</span>
                </button>
            </div>

            <div>
                <a href="{{ route('deposits.view') }}">
                    <div class="flex items-center space-x-3 border-2 border-[#2A2B39] rounded-md p-3 bg-[#1F202B]">
                        <div class="flex-none">
                            <img src="{{ asset('userassets/icons/deposit-history-icon.svg') }}" alt="">
                        </div>
                        <div class="flex-1"><p class="text-[#FFFFFF] text-sm">Deposit history</p></div>
                        <div class="flex-none"><img src="{{ asset('userassets/icons/chevron-right-account.svg') }}" alt=""></div>
                    </div>
                </a>
            </div>

            <div class="my-1">
                <a href="{{ route('withdraw.view') }}">
                    <div class="flex items-center space-x-3 border-2 border-[#2A2B39] rounded-md p-3 bg-[#1F202B]">
                        <div class="flex-none">
                            <img src="{{ asset('userassets/icons/withdraw-history-icon.svg') }}" alt="">
                        </div>
                        <div class="flex-1"><p class="text-[#FFFFFF] text-sm">Withdrawal history</p></div>
                        <div class="flex-none"><img src="{{ asset('userassets/icons/chevron-right-account.svg') }}" alt=""></div>
                    </div>
                </a>
            </div>

            <div>
                <a href="{{ route('tradingbot.view') }}">
                    <div class="flex items-center space-x-3 border-2 border-[#2A2B39] rounded-md p-3 bg-[#1F202B]">
                        <div class="flex-none">
                            <img src="{{ asset('userassets/icons/robot-icon-mobile.svg') }}" alt="">
                        </div>
                        <div class="flex-1"><p class="text-[#FFFFFF] text-sm">Trading history</p></div>
                        <div class="flex-none"><img src="{{ asset('userassets/icons/chevron-right-account.svg') }}" alt=""></div>
                    </div>
                </a>
            </div>

            <div class="mt-1 mb-1">
                <a href="/user/account">
                    <div class="flex items-center space-x-3 border-2 border-[#2A2B39] rounded-md p-3 bg-[#1F202B]">
                        <div class="flex-none">
                            <img src="{{ asset('userassets/icons/settings-icon.svg') }}" alt="">
                        </div>
                        <div class="flex-1"><p class="text-[#FFFFFF] text-sm">Settings</p></div>
                        <div class="flex-none"><img src="{{ asset('userassets/icons/chevron-right-account.svg') }}" alt=""></div>
                    </div>
                </a>
            </div>

            <div class="mt-1 mb-1">
                <a href="/user/faq">
                    <div class="flex items-center space-x-3 border-2 border-[#2A2B39] rounded-md p-3 bg-[#1F202B]">
                        <div class="flex-none">
                            <img src="{{ asset('userassets/icons/faq-icon.svg') }}" alt="">
                        </div>
                        <div class="flex-1"><p class="text-[#FFFFFF] text-sm">FAQ</p></div>
                        <div class="flex-none"><img src="{{ asset('userassets/icons/chevron-right-account.svg') }}" alt=""></div>
                    </div>
                </a>
            </div>

            <div>
                @if(Session::has('device'))
                    @if(Session::get('device') == 'app')
                    <a href="/user/applogout">
                        <div class="flex items-center space-x-3 border-2 border-[#2A2B39] rounded-md p-3 bg-[#1F202B]">
                            <div class="flex-none">
                                <img src="{{ asset('userassets/icons/logout-icon-mobile.svg') }}" alt="">
                            </div>
                            <div class="flex-1"><p class="text-[#FF5765] text-sm">Logout</p></div>
                            <div class="flex-none"><img src="{{ asset('userassets/icons/chevron-right-account.svg') }}" alt=""></div>
                        </div>
                    </a>
                    @endif
                @else
                <a href="/user/logout">
                    <div class="flex items-center space-x-3 border-2 border-[#2A2B39] rounded-md p-3 bg-[#1F202B]">
                        <div class="flex-none">
                            <img src="{{ asset('userassets/icons/logout-icon-mobile.svg') }}" alt="">
                        </div>
                        <div class="flex-1"><p class="text-[#FF5765] text-sm">Logout</p></div>
                        <div class="flex-none"><img src="{{ asset('userassets/icons/chevron-right-account.svg') }}" alt=""></div>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>
    

    @yield('content')

    <script>
        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
        }

        function getTradePosition() {
            let tradeEntry = @json($tradeEntry);
            for (let i = 0; i < tradeEntry.trades.length; i++) {
                let timerEndsAt = tradeEntry.trades[i].timer_ends_at;
                if (Date.now() <= timerEndsAt) {
                    return {
                        trade: tradeEntry.trades[i],
                        position: i
                    }
                }
                // if (Date.now() <= timerEndsAt && shift === 1) {
                //     return {
                //         trade: tradeEntry.trades[i + 1],
                //         position: i + 1
                //     }
                // }
                continue;
            }
        }

        function calculateAmountEarned(position) {
            let tradeEntry = @json($tradeEntry);
            let amountEarned = 0;
            for (let i = 0; i < Number(position); i++) {
                let profit = tradeEntry.trades[i].profit;
                amountEarned += Number(profit);
            }
            return amountEarned;
        }
    </script>

@foreach($tradingbots as $tradingbot)
<script>
    document.getElementById("timer_counter").classList.add('hidden');
    var tradingbot = @json($tradingbot);
    var dollarUSLocale = Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    let tradePositionData = getTradePosition();

    function calculateCompanyCommission(profit) {
        let amountEarned = parseFloat(profit).toFixed(2);
        let onePercent = 0.01 * amountEarned;
        return parseFloat(onePercent).toFixed(2);
    }

    function hoursTillRobotExpiration() {
        let start = new Date(tradingbot.created_at);
        let expiration = new Date(start.getTime() + 24 * 60 * 60 * 1000);
        let now = new Date();
        let diff = expiration.getTime() - now.getTime();
        return Math.ceil(diff / (60 * 60 * 1000));
    }

    function setTradingBotDetails() {
        $("#total_amount").text(Intl.NumberFormat('en-US').format(Number(tradingbot.amount)));
        $("#details_amount").text('$' + Intl.NumberFormat('en-US').format(Number(tradingbot.amount)));
        $("#details_strategy").text(tradingbot.name);
        $("#details_profit_limit").text(Intl.NumberFormat('en-US').format(Number(tradingbot.max_roi_percentage)) + '%');
        amount_earned = calculateAmountEarned(tradePositionData.position);
        let companyCommission = calculateCompanyCommission(amount_earned);
        let stopRobotProfit = amount_earned - companyCommission;
        $("#profit").text(dollarUSLocale.format(amount_earned));
        $("#stop_robot_profit").text(dollarUSLocale.format(stopRobotProfit));
        $("#details_profit").text('$' + dollarUSLocale.format(amount_earned));
        $("#active_trade_profit").text('$' + dollarUSLocale.format(amount_earned));
        $("#active_trade_profit_2").text('$' + dollarUSLocale.format(amount_earned));
        $("#company_commission").text('$' + Number(companyCommission));
        $("#stop_robot_commission").text('$' + Number(companyCommission));
        let robotExpirationHours = hoursTillRobotExpiration();
        $("#robot_expires").text(robotExpirationHours + ' hr(s)');
    }

    setTradingBotDetails();

    function refreshProfitAndCommission(profit) {
        $("#profit").text(dollarUSLocale.format(Number(profit)));
        let companyCommission = calculateCompanyCommission(profit);
        let stopRobotProfit = profit - companyCommission;
        $("#stop_robot_profit").text(dollarUSLocale.format(Number(stopRobotProfit)));
        $("#active_trade_profit").text('$' + dollarUSLocale.format(amount_earned));
        $("#active_trade_profit_2").text('$' + dollarUSLocale.format(amount_earned));
        $("#company_commission").text('$' + Number(companyCommission));
        $("#stop_robot_commission").text('$' + Number(companyCommission));
    }

</script>
@endforeach

<script>
    const calculateTimeLeft = (timerEndsAt) => {
        const now = new Date();
        const difference = Number(timerEndsAt) - Number(now);
        if(0 > difference) {
            return { minutes: 0, seconds: 0 };
        }
        let minutes = Math.floor((difference / (1000 * 60)) % 60);
        let seconds = Math.floor((difference / 1000) % 60);
        return { minutes, seconds };
    };

    const transformTimerString = (minutes, seconds) => {
        let str_minutes,
            str_seconds;
        if (minutes < 10) {
            str_minutes = `0${minutes}`
        } else {
            str_minutes = `${minutes}`
        }
        if (seconds < 10) {
            str_seconds = `0${seconds}`
        } else {
            str_seconds = `${seconds}`
        }
        return `${str_minutes}:${str_seconds}`
    }

    function updateURLQueryString(key, value) {
        // Get the current URL
        const url = new URL(window.location.href);

        // Update or add the query parameter
        url.searchParams.set(key, value);

        // Update the browser's URL without reloading the page
        history.pushState(null, '', url.toString());
    }

    document.addEventListener('DOMContentLoaded', function() {
        // set trading pair details
        $("#trading_image").attr("src", tradePositionData.trade.image_url);
        $("#trading_asset").html(tradePositionData.trade.asset_display_name);
        $("#trading_percentage").html(tradePositionData.trade.percentage);
        $("#viewassettradebtn").attr("href", '/user/viewassettrade?tvwidgetsymbol=' + tradePositionData.trade.asset_name);
        $("#trading_action").html(tradePositionData.trade.action);
        let tradingAction = tradePositionData.trade.action;

        updateURLQueryString('tvwidgetsymbol', tradePositionData.trade.asset_name ?? 'BTCUSDT')

        if(tradingAction === 'BUY') {
            $("#trading_action").addClass("text-[#16C784]");
        }
        
        if(tradingAction === 'SELL') {
            $("#trading_action").addClass("text-[#ea3943]");
        }

        function startInterval() {
            let timer = setInterval(() => {
                let refreshedTradePositionData = getTradePosition();

                // update "robot_stopped_at" input to send over when the trade is stopped manually
                document.getElementById('robot_stopped_at').value = refreshedTradePositionData.position;

                let timeLeft = calculateTimeLeft(refreshedTradePositionData.trade.timer_ends_at);
                if(timeLeft.minutes === 0 && timeLeft.seconds === 0) {
                    clearInterval(timer);
                    startInterval();
                }

                if(timeLeft.minutes === 5 && timeLeft.seconds === 0) {
                    let newTradePositionData = getTradePosition();
                    let currentTradingBot = @json($tradingbots);
                    if(currentTradingBot[0]) {
                        $("#trading_image").attr("src", newTradePositionData.trade.image_url);
                        $("#trading_asset").html(newTradePositionData.trade.asset_display_name);
                        $("#trading_percentage").html(newTradePositionData.trade.percentage);
                        $("#trading_action").html(newTradePositionData.trade.action);
                        let tradingAction = newTradePositionData.trade.action;
                        updateURLQueryString('tvwidgetsymbol', newTradePositionData.trade.asset_name);
                        let robotExpirationHours = hoursTillRobotExpiration();
                        $("#robot_expires").text(robotExpirationHours + ' hrs');

                        if(tradingAction === 'BUY') {
                            $("#trading_action").removeClass("text-[#16C784]");
                            $("#trading_action").removeClass("text-[#ea3943]");
                            $("#trading_action").addClass("text-[#16C784]");
                        }
                        
                        if(tradingAction === 'SELL') {
                            $("#trading_action").removeClass("text-[#ea3943]");
                            $("#trading_action").removeClass("text-[#16C784]");
                            $("#trading_action").addClass("text-[#ea3943]");
                        }
                        $("#viewassettradebtn").attr("href", `/user/viewassettrade?tvwidgetsymbol=${newTradePositionData.trade.asset_name}`);
                        document.getElementById("timer_counter").classList.add('hidden');
                    }
                    document.getElementById("timer_counter").classList.remove('hidden');
                    document.getElementById("timer_loading").classList.add('hidden');
                }

                if(timeLeft.minutes === 5 && timeLeft.seconds > 0) {
                    document.getElementById("timer_counter").classList.add('hidden');
                    document.getElementById("timer_loading").classList.remove('hidden');
                    let newTradePositionData1 = getTradePosition();
                    let refreshedAmountEarned = calculateAmountEarned(newTradePositionData1.position);
                    refreshProfitAndCommission(refreshedAmountEarned);
                }

                if(timeLeft.minutes <= 4) {
                    document.getElementById("timer_counter").classList.remove('hidden');
                    document.getElementById("timer_loading").classList.add('hidden');
                }

                let newTradePositionData2 = getTradePosition();
                let refreshedAmountEarned2 = calculateAmountEarned(newTradePositionData2.position);
                $("#trading_asset").html(newTradePositionData2.trade.asset_display_name);
                $("#trading_action").html(newTradePositionData2.trade.action);
                if(newTradePositionData2.trade.action === 'BUY') {
                    $("#trading_action").removeClass("text-[#16C784]");
                    $("#trading_action").removeClass("text-[#ea3943]");
                    $("#trading_action").addClass("text-[#16C784]");
                }
                
                if(newTradePositionData2.trade.action === 'SELL') {
                    $("#trading_action").removeClass("text-[#ea3943]");
                    $("#trading_action").removeClass("text-[#16C784]");
                    $("#trading_action").addClass("text-[#ea3943]");
                }
                refreshProfitAndCommission(refreshedAmountEarned2);

                let timerString = transformTimerString(timeLeft.minutes, timeLeft.seconds);
                document.getElementById('countdown_timer').innerText = timerString;
            }, 1000);
        }
        startInterval();
    });

    // function reloadPageWithoutRefresh() {
    //     fetch(window.location.href)
    //     .then(response => response.text())
    //     .then(html => {
    //         var parser = new DOMParser();
    //         var newDoc = parser.parseFromString(html, "text/html");
    //         document.body.innerHTML = newDoc.body.innerHTML;
    //     });
    // }

    // document.addEventListener('visibilitychange', function() {
    //     if (document.visibilityState === 'visible') {
    //         location.reload();
    //     }
    // });
</script>

<script>
    const navbar = document.getElementById('mobile__navbar');
    const scrollableContent = document.getElementById('tradingbots__container');
    const scrollableContentLg = document.getElementById('tradingbots__container__lg');

    const historyContainer = document.getElementById('history__container');
    const historyContainerLg = document.getElementById('history__container__lg');
  
    function adjustTradingBotsContainerMargin() {
      const navbarHeight = navbar.offsetHeight;
      scrollableContent.style.marginBottom = `${navbarHeight}px`;
      scrollableContentLg.style.marginBottom = `2px`;
    }

    function adjustHistoryContainerMargin() {
      const navbarHeight = navbar.offsetHeight;
      historyContainer.style.marginBottom = `${navbarHeight}px`;
      historyContainerLg.style.marginBottom = `2px`;
    }
  
    // Call initially and on resize
    if (scrollableContent) {
        adjustTradingBotsContainerMargin();
        window.addEventListener('resize', adjustTradingBotsContainerMargin());
    }

    if (historyContainer) {
        adjustHistoryContainerMargin();
        window.addEventListener('resize', adjustHistoryContainerMargin());
    }
  </script>

</body>
</html>
