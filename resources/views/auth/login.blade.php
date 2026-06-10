@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <section class="auth-section">

        <div class="container">

            <div class="row min-vh-100 align-items-center">

                {{-- LEFT --}}
                <div class="col-lg-6 d-none d-lg-block">

                    <div class="auth-left">

                        <h1 style="font-weight: 800;">
                            Selamat Datang
                        </h1>

                        <p class="text-muted" style="font-size: 14px;">
                            Login untuk mulai memesan kamar di Kost Ara Marbun.
                         </p>

                        <img src="https://i.ibb.co.com/yFPxq6tj/kosara1.png"
                               
                            class="img-fluid rounded-4 shadow">

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-6">

                    <div class="auth-card">

                        <h2 class="mb-4 fw-bold" style="text-align: center;">
                            Login
                        </h2>
                        @if (session('status'))
                            <div class="alert alert-danger">

                                {{ session('status') }}

                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">

                            @csrf

                            {{-- EMAIL --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control auth-input @error('email') is-invalid @enderror" required>

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

                                <input type="password" name="password"
                                    class="form-control auth-input @error('password') is-invalid @enderror" required>

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
