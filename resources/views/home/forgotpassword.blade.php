@extends('home.layout.layout')

@section('content')
<section class="single-page bg-dark text-white py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 col-12 mx-auto">
                <div class="w-full h-full px-2">
                    <div class="flex justify-center w-full h-screen rounded items-center">
                        <div class="container-md bg-custom text-white py-5 rounded-4 shadow">
                            <h3 class="text-center fw-bold text-light" id="page-title">Password Reset</h3>
                            <x-auth-session-status class="mb-4 text-center" style="font-size: 14px;" :status="session('status')" />
                            <form method="POST" action="{{ route('password.email') }}" class="px-4 mt-4" id="loginForm">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="email" id="email" name="email" placeholder="Email Address"
                                            class="form-control" required autofocus value="{{ old('username') }}">
                                        <label for="email" class="text-dark">Email Address</label>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary text-white py-3 fw-bold" type="submit" name="submit-form">Email Password Reset Link</button>
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