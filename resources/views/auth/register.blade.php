@extends('layouts.app')

@section('title', 'Register')

@section('content')

<section class="auth-section">

    <div class="container">

        <div class="row min-vh-100 align-items-center">

            {{-- LEFT --}}
            <div class="col-lg-6 d-none d-lg-block">

                <div class="auth-left">

                    <h1>
                        Buat Akun Baru
                    </h1>

                    <p>

                        Daftar sekarang untuk mulai
                        booking kamar kost impianmu.

                    </p>

                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85"
                        class="img-fluid rounded-4 shadow">

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-6">

                <div class="auth-card">

                    <h2 class="mb-4 fw-bold">
                        Register
                    </h2>

                    <form method="POST"
                        action="{{ route('register') }}">

                        @csrf

                        {{-- NAME --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Nama
                            </label>

                            <input type="text"
                                name="name"
                                class="form-control auth-input"
                                required>

                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                name="email"
                                class="form-control auth-input"
                                required>

                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input type="password"
                                name="password"
                                class="form-control auth-input"
                                required>

                        </div>

                        {{-- CONFIRM --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input type="password"
                                name="password_confirmation"
                                class="form-control auth-input"
                                required>

                        </div>

                        {{-- BUTTON --}}
                        <button class="btn btn-primary w-100 py-3">

                            Register

                        </button>

                    </form>

                    <p class="text-center mt-4">

                        Sudah punya akun?

                        <a href="{{ route('login') }}">
                            Login
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection