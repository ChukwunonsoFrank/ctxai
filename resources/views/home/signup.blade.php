@extends('home.layout.layout')

@section('content')
    <section class="single-page bg-dark text-white py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <div class="w-full h-full px-2">
                        <div class="flex justify-center w-full h-screen rounded items-center">
                            <div class="container-md bg-custom text-white py-5 px-4 rounded-4 shadow">
                                <h3 class="text-center fw-bold text-light" id="page-title">
                                    Register
                                </h3>
                                <div class="px-4 mt-4">
                                    <p class="bg-success text-light p-1 rounded-lg text-center d-none" id="noticeMsg">
                                        @if (Session::has('message'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </p>
                                </div>

                                <form method="post" action="{{ route('register.perform') }}" id="registerForm">
                                    @csrf
                                    <div class="row gy-2 mt-3 text-white">
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <input type="email" id="email" name="email"
                                                    class="form-control" required value="{{ old('email') }}" placeholder="Email" autofocus>
                                                <label for="email" class="text-dark">Email</label>
                                            </div>
                                            @if ($errors->has('email'))
                                                <span class="text-danger text-left" style="font-size: 12px;">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <input type="text" id="username" name="username"
                                                    class="form-control" placeholder="Username" required value="{{ old('username') }}">
                                                <label for="username" class="text-dark">Username</label>
                                            </div>
                                            @if ($errors->has('username'))
                                                <span class="text-danger text-left" style="font-size: 12px;">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="input-group">
                                                <div class="form-floating">
                                                    <input type="password" id="password1" name="password"
                                                        class="form-control" placeholder="Password" required value="{{ old('password') }}">
                                                    <label for="password1" class="text-dark">Password</label>
                                                </div>
                                                <span class="input-group-text" id="basic-addon1" role="button"><i
                                                        class="bi bi-eye-fill" id="togglePassword1"></i></span>
                                            </div>
                                            @if ($errors->has('password'))
                                                <span class="text-danger text-left" style="font-size: 12px;">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="form-floating">
                                                    <input type="password" id="password2" name="password_confirmation"
                                                        class="form-control" placeholder="Confirm Password" required value="{{ old('password_confirmation') }}">
                                                    <label for="password2" class="text-dark">Confirm Password</label>
                                                </div>
                                                <span class="input-group-text" id="basic-addon1" role="button"><i
                                                    class="bi bi-eye-fill" id="togglePassword2"></i></span>
                                            </div>
                                            @if ($errors->has('password'))
                                                <span class="text-danger text-left" style="font-size: 12px;">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            <div class="g-recaptcha mt-4"
                                                data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                                        </div>

                                        <input type="hidden" name="referer"
                                            value="@if (isset($ref)) {{ $ref }} @endif">
                                        <div class="col-12 py-3">
                                                <button type="submit" id="registerBtn" class="btn btn-primary text-white py-3 fw-bold" style="width: 100%;">Register</button>
                                        </div>
                                        <div class="d-flex justify-content-center text-light fw-semibold my-4">
                                            <div class="text-center">
                                                <span class="text-light" style="font-size: 13px;">Already have account? <a href="/user/login/" class="text-underline text-primary">Login</a></span>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <p style="font-size: 13px;">By pressing Register, you confirm that you are of legal age and accept the <a class="text-primary fw-bold"
                                                    href="/terms">Terms & Conditions</a> and <a class="text-primary fw-bold" href="/privacy">Privacy
                                                    Policy</a> as well as to Nxcai Robot <a class="text-primary fw-bold" href="/terms">Terms &
                                                    Conditions</a> and <a class="text-primary fw-bold" href="/privacy">Privacy Policy</a></p>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
