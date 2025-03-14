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

                            <form method="POST" action="{{ route('password.store') }}" class="px-4 mt-4">
                                @csrf
                        
                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        
                                <!-- Email Address -->
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="Email Address" />
                                        <label for="email" class="text-dark">Email Address</label>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                </div>
                        
                                <!-- Password -->
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input id="password" class="form-control" type="password" name="password" required placeholder="Password" />
                                        <label for="password" class="text-dark">Password</label>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                </div>
                        
                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required placeholder="Confirm Password" />
                                        <label for="password_confirmation" class="text-dark">Confirm Password</label>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary text-white py-3" type="submit" name="submit-form">Reset Password</button>
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