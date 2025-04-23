<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exvb - AI Trading bot</title>
    

    <link rel="icon" type="image/png" href="/homeassets/img/Ctxailogo.png">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="/homeassets/css/main.css">

    <!--Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script async src="https://www.google.com/recaptcha/api.js"></script>

</head>
<body class="bg-custom">
    <div class="container-fluid w-100 vh-100 bg-custom d-flex flex-col justify-content-center">
        <header class="w-100">
        <div class="form-wrapper w-100 h-auto pt-5">
            <h1 class="text-light text-center fw-bold">Create a <br><span class="text-primary">Exvb</span> account</h1>
            <div class="row gy-3 text-white flex">
                <div class="col-12">
                    <ul class="nav nav-underline justify-content-center gap-0" id="nav-bar-tab">
                        <li class="nav-item w-50 ">
                            <a class="nav-link 
                            @if (isset($link))
                                @if ($link=='login')
                                active 
                                @endif 
                            @else
                            active
                            @endif
                            text-center" id="login-btn01" aria-current="page" href="#login" data-bs-toggle="tab">Login</a>
                        </li>
                        <li class="nav-item w-50">
                            <a class="nav-link  
                            @if (isset($link))
                                @if ($link=='register')
                                active 
                                @endif 
                            @endif
                            text-center" id="register-btn01" href="#register" data-bs-toggle="tab">Register</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- {{ env('APP_MAIL_LOGO') }} -->
                        
                        <div class="tab-pane fade 
                            @if (isset($link))
                                @if ($link=='login')
                                show active
                                @endif 
                            @else
                            show active
                            @endif
                        " id="login">
                        @if (isset($link))
                        
                            @if ($link=='login')
                                
                                @if(Session::has('login_error'))
                                <div class="alert alert-danger" role="alert">
                                    {{Session::get('login_error')}}
                                </div>
                                @endif

                                @if ($errors->any())
                                
                                    <div class="alert alert-danger">
                                        <ul style="margin-bottom:0px!important;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        @endif
                        
                        
                            <!-- login form -->
                            <div class="row gy-2  mt-3 text-white">
                                <form name="form" method="post" action="{{ url('user/applogin')}}">@csrf
                                <div class="col-12">
                                    <label for="username" class="form-label">Email/Username</label>
                                    <input type="text" class="form-control form-control-lg" required aria-label="username" name="username" value="{{ old('username') }}" placeholder="Username or Email" required="required" autofocus>
                                    
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" id="password" class="form-control form-control-lg" placeholder="" required aria-label="amount" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                                        <span class="input-group-text" id="basic-addon1" role="button" ><i class="bi bi-eye-fill" id="togglePassword"></i></span>
                                    </div>
                                    
                                </div>
                                
                                
                                <div class="col-12 py-3">
                                    <input type="submit" class="form-control form-control-lg px-0 btn btn-primary btn-lg" value="Login" required aria-label="amount">
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade
                            @if (isset($link))
                                @if ($link=='register')
                                show active 
                                @endif 
                            @endif
                        " id="register">
                            <!-- signup form  -->
                            <form method="post" action="{{ route('register.perform') }}">
                            @csrf
                            <div class="row gy-2  mt-3 text-white">
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus aria-label="email">
                                    @if ($errors->has('email'))
                                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label for="Username" class="form-label">Username</label>
                                    <input type="text" class="form-control form-control-lg" aria-label="Email" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
                                    @if ($errors->has('username'))
                                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group mb-3">
                                    
                                        <input type="password" class="form-control form-control-lg" aria-label="amount" name="password" value="{{ old('password') }}" id="password1" placeholder="Password" required="required">
                                        <span class="input-group-text" id="basic-addon1" role="button" ><i class="bi bi-eye-fill" id="togglePassword1"></i></span>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Confirm Password</label>
                                    <div class="input-group mb-3">
                                    
                                        <input type="password" id="password2" class="form-control form-control-lg" aria-label="amount" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
                                        <span class="input-group-text" id="basic-addon1" role="button" ><i class="bi bi-eye-fill" id="togglePassword2"></i></span>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <!-- Google Recaptcha Widget-->
                                    <div class="g-recaptcha mt-4" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                                </div>
                                
                                <input type="hidden" name="referer" value="@if(isset($ref)){{$ref}}@endif">
                                <div class="col-12 py-3">
                                    <input type="submit" class="form-control form-control-lg px-0 btn btn-primary btn-lg" value="Register" required aria-label="amount">
                                </div>
                                <!-- <div class="col-12">
                                        <p>By pressing Register, you confirm that you are of legal age and accept the <a href="https://ctxai.org/terms" target="_blank">Terms & Conditions</a> and <a href="https://ctxai.org/privacy" target="_blank">Privacy Policy</a> as well as to Ctxai Robot <a href="https://ctxai.org/terms" target="_blank">Terms & Conditions</a> and <a href="https://ctxai.org/privacy" target="_blank">Privacy Policy</a></p>
                                    </div> -->

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </header>
        
    </div>




   
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye-fill');
        });

        const togglePassword1 = document.querySelector('#togglePassword1');
        const password1 = document.querySelector('#password1');
        togglePassword1.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password1.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye-fill');
        });

        const togglePassword2 = document.querySelector('#togglePassword2');
        const password2 = document.querySelector('#password2');
        togglePassword2.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password2.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye-fill');
        });
    </script>

  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $("[id^=login-btn]").each(function () {
            $(this).click(function () {
                let stateObj = { id: "100" };
                
                window.history.replaceState(stateObj,"Page", "/user/applogin");
            });
        });

        $("[id^=register-btn]").each(function () {
            $(this).click(function () {
                let stateObj = { id: "100" };
			
			    window.history.replaceState(stateObj,"Page", "/user/appregister/null");
            });
        });

        $(document).ready(function(){
            $('.gt_switcher-popup').find('span').hide();
        })
    </script>




<script>window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","flag_size":24,"flag_style":"3d"}</script>
<script src="https://cdn.gtranslate.net/widgets/latest/popup.js" defer></script>
    @yield('footer')
</body>
</html>