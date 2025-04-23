<div class="side-bar-desktop bg-custom rounded-right-3 overflow-hidden d-none d-sm-none d-lg-inline-flex mt-4 position-fixed">
    <div class="cointainer-flui d-inline-flex">
        <div class="menu d-flex flex-column gap-2 pt-2">
            
            
            <a href="/user/robot" class="text-decoration-none">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                    @if(Session::get('page') == 'robot')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-robot fs-1"></i>
                    <span>Robot</span>
                </div>
            </a>

            <a href="/user/dashboard" class="text-decoration-none">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                    @if(Session::get('page') == 'dashboard')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-speedometer fs-1"></i>
                    <span>Chart</span>
                </div>
            </a>
            

            <a href="#" class="text-decoration-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_withdraw" aria-controls="offcanvasRight">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                    @if(Session::get('page') == 'withdraw')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-wallet fs-1"></i>
                    <span>Withdraw</span>
                </div>
            </a>

            <!-- <a href="#" class="text-decoration-none" type="button" data-bs-toggle="modal" data-bs-target="#supportchat">
                <div class="menu-item px-3 d-flex flex-column align-items-center">
                    <i class="bi bi-chat-right-text-fill fs-1"></i>
                    <span>Support</span>
                </div>
            </a> -->

            <!-- <a href="#" class="text-decoration-none" id="openChatButton2">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                ">
                    <i class="bi bi-chat-right-text-fill fs-1"></i>
                    <span>Support</span>
                </div>
            </a> -->

            <a href="/user/account" class="text-decoration-none">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                    @if(Session::get('page') == 'account')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-person-fill fs-1"></i>
                    <span>Account</span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="mobile-menu fixed-bottom bg-custom d-lg-none d-sm-block">
    <div class="container-fluid">
        <div class="menu d-flex flex-row justify-content-between py-2" style="padding-right: 20px;">
            
            
            <a href="/user/robot" class="text-decoration-none">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                    @if(Session::get('page') == 'robot')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-robot fs-1"></i>
                    <span>Robot</span>
                </div>
            </a>

            <a href="/user/dashboard" class="text-decoration-none">
                <div class="menu-item px-3 d-flex flex-column align-items-center 
                @if(Session::has('page'))
                    @if(Session::get('page') == 'dashboard')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-speedometer fs-1"></i>
                    <span>Chart</span>
                </div>
            </a>

            
           
            <a href="#" class="text-decoration-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_withdraw" aria-controls="offcanvasRight">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                        @if(Session::get('page') == 'withdraw')
                        active
                        @endif
                    @endif
                " >
                    <i class="bi bi-wallet fs-1"></i>
                    <span>Withdraw</span>
                </div>
            </a>

            <!-- <a href="#" class="text-decoration-none" id="openChatButton">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                ">
                    <i class="bi bi-chat-right-text-fill fs-1"></i>
                    <span>Support</span>
                </div>
            </a> -->
            <!-- <a href="#" class="text-decoration-none" type="button" data-bs-toggle="modal" data-bs-target="#supportchat">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                ">
                    <i class="bi bi-chat-right-text-fill fs-1"></i>
                    <span>Support</span>
                </div>
            </a> -->
            <a href="/user/account" class="text-decoration-none">
                <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                    @if(Session::get('page') == 'account')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-person-fill fs-1"></i>
                    <span>Account</span>
                </div>
            </a>
            <a href="/user/account" class="text-decoration-none">
                <!-- <div class="menu-item px-3 d-flex flex-column align-items-center
                @if(Session::has('page'))
                    @if(Session::get('page') == 'account')
                    active
                    @endif
                @endif
                ">
                    <i class="bi bi-person-fill fs-1"></i>
                    <span>Account</span>
                </div> -->
            </a>

        </div>
    </div>
</div>

<!-- this is the deposit form -->
<div class="account offcanvas offcanvas-end bg-custom-dark" tabindex="-1" id="offcanvasRight_withdraw" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white" id="offcanvasRightLabel">Withdraw from live account</h5>
        <button type="button" class="btn-close bg-text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="account offcanvas-body bg-custom-dark">
        <div class="text-white d-flex justify-content-between">
            <h4>Live Balance</h4>
            <h4>@money($user['balance'])</h4>
        </div>
        
        <div class="row gy-3 text-white">
            <form action="{{ url('/user/withdraw')}}" method="post">@CSrf
                <div id="withdrawform">
                    <div class="col-12">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="input-group mb-0">
                            <span class="input-group-text" id="basic-addon1">$</span>
                            <input name="amount" type="number" required step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$"  class="form-control form-control-lg px-2" placeholder="Amount" name="amount" aria-label="amount" id="withdrawamount">
                        </div>
                        <label for="amount" id="withdrawerror" class="form-label text-danger">Minimum withdraw is $10</label>
                        <label for="amount" id="withdrawotperror" class="form-label text-danger"><i>You do not have enough funds in your balance to proceed</i></label>
                    </div>
                    <div class="col-12">
                        <label for="amount" class="form-label">Payment Method</label>
                        <select class="form-select form-select-lg mb-3"  name="walletname" id="walletname" aria-label="Large select example">
                            <option value="" required selected>Select Method</option>
                            @forelse ($wallets as $wallet)
                                <option value="{{ $wallet['coin_name']}}">{{ $wallet['coin_name']}}</option>
                                @empty
                                <option>No wallet address yet</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="amount" class="form-label">Input Wallet Address</label>
                        <input name="walletaddress" type="text" id="walletaddress" class="form-control form-control-lg px-2" placeholder="" required aria-label="amount">
                    </div>

                    <div class="col-12 py-3">
                        <div class="form-control form-control-lg px-0 btn btn-primary btn-lg" onclick="sendotp()">Withdraw</div>
                    </div>
                </div>
            
            <input type="hidden" name="livebalance" id="livebalance" value="{{ $user['balance'] }}">
            <div id="withdrawotpform">
                <div class="col-12 py-3">
                    <button type="button" class="btn btn-primary btn-sm" onclick="backwithdraw()"><i class="bi bi-arrow-left-short"></i>  back</button>
                </div>
                <div class="col-12" id="otpinput">
                    <center>
                        <label class="form-label text-white">Check your email for verification code</label>
                       
                    </center>
                    <label class="form-label">Enter Verification Code</label>
                    <input name="withdrawotp" type="text" class="form-control form-control-lg px-2" placeholder=""  required>
                </div>
                <div class="col-12 py-3">
                    <input type="submit" class="form-control form-control-lg px-0 btn btn-primary btn-lg single-submit" value="Confirm" required aria-label="amount" id="withdrawbutton">
                </div>
                
                <label class="form-label text-white">Didn't get code?  <b class="text-default" style="color:#0166b1;" onclick="resendotp()">Resend Code</b> </label>
            </div>
            
            </form>
        </div>
    </div>
</div>

<!-- support popup -->

<div class="modal fade" id="supportchat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen text-white">
    <div class="modal-content bg-custom">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-0">
        <iframe src="https://widget-page.smartsupp.com/widget/1742486f6be88cc339ff73082ad2132a1f42d8ae" width="100%" height="100%" title="YouTube video">
<script>
    // Send a message to the parent window
window.parent.postMessage({
    type: 'smartSuppMessage',
    href: window.location.href
}, 'https://exvb.com'); // Replace with your site’s URL
    </script>

        </iframe>
      </div>
      
    </div>
  </div>
</div>