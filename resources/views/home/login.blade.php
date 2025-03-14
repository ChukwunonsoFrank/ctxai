@extends('home.layout.layout')

@section('content')
<section class="single-page bg-dark text-white py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 col-12 mx-auto">
                <div class="w-full h-full px-2">
                    <div class="flex justify-center w-full h-screen rounded items-center">
                        <div class="container-md bg-custom text-white py-5 rounded-4 shadow">
                            <h3 class="text-center fw-bold text-light" id="page-title">
                                Login
                            </h3>

                            <div class="px-4 mt-4">
                                <p class="bg-success text-light p-1 rounded-lg text-center d-none" id="noticeMsg">
                                    @if(Session::has('login_error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ Session::get('login_error') }}
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

                            <form action="{{ url('user/login') }}" method="POST" class="px-4 mt-4" id="loginForm">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" id="email" name="username" placeholder="Email"
                                            class="form-control" required value="{{ old('username') }}">
                                        <label for="email" class="text-dark">Email</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="password" name="password" placeholder="Password" id="password"
                                            class="form-control" required value="{{ old('password') }}">
                                        <label for="password" class="text-dark">Password</label>
                                    </div>
                                </div>

                                <div class="d-flex text-light fw-semibold my-4">
                                    <div class="text-center">
                                        <span style="font-size: 13px;"><a class="text-underline text-primary" href="/user/forgot-password/">Forgot password?</a></span>
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <div class="g-recaptcha mt-4"
                                        data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                                </div> --}}

                                <div class="d-grid">
                                    <button type="submit" id="loginBtn" class="btn btn-primary text-white py-3 fw-bold">Login</button>
                                </div>

                                <div class="d-flex justify-content-center text-light fw-semibold my-4">
                                    <div class="text-center">
                                        <span class="text-light" style="font-size: 13px;">Don't have account? <a href="/user/register/" class="text-underline text-primary">Register</a></span>
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
