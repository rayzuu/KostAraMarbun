@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section class="auth-section">

    <div class="container">

        <div class="row min-vh-100 align-items-center">

            {{-- LEFT --}}
            <div class="col-lg-6 d-none d-lg-block">

                <div class="auth-left">

                    <h1>
                        Selamat Datang Kembali
                    </h1>

                    <p>

                        Login untuk mulai mencari
                        kamar kost terbaik untuk anda.

                    </p>

                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267"
                        class="img-fluid rounded-4 shadow">

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-6">

                <div class="auth-card">

                    <h2 class="mb-4 fw-bold">
                        Login
                    </h2>
                     @if(session('status'))

                        <div class="alert alert-danger">

                            {{ session('status') }}

                        </div>

                    @endif
                    <form method="POST"
                        action="{{ route('login') }}">

                        @csrf

                        {{-- EMAIL --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control auth-input @error('email') is-invalid @enderror"
                                required>

                            @error('email')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        {{-- PASSWORD --}}
                       <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <input type="password"
                                name="password"
                                class="form-control auth-input @error('password') is-invalid @enderror"
                                required>

                            @error('password')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        {{-- BUTTON --}}
                        <button class="btn btn-primary w-100 py-3">

                            Login

                        </button>

                    </form>

                    <p class="text-center mt-4">

                        Belum punya akun?

                        <a href="{{ route('register') }}">
                            Register
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection