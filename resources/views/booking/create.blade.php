@extends('layouts.app')

@section('title', 'Ajukan Sewa')

@section('content')

    <section class="booking-section py-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-10">

                    <div class="booking-wrapper">

                        <div class="row g-0">

                            {{-- LEFT --}}
                            <div class="col-lg-5">

                                <div class="booking-left">

                                    <span class="booking-badge">

                                        Pengajuan Sewa

                                    </span>

                                    <h1 class="booking-title">

                                        Kost Ara Marbun
                                    </h1>

                                    <p class="booking-text">

                                        Lengkapi data diri untuk
                                        melanjutkan proses pengajuan
                                        sewa kamar kost.

                                    </p>

                                    <div class="booking-info">

                                        <div class="booking-info-item">

                                            <i class="bi bi-check-circle-fill"></i>
                                            Proses cepat

                                        </div>

                                        <div class="booking-info-item">

                                            <i class="bi bi-check-circle-fill"></i>
                                            Data aman

                                        </div>

                                        <div class="booking-info-item">

                                            <i class="bi bi-check-circle-fill"></i> Pembayaran online

                                        </div>

                                        <div class="booking-info-item">

                                            <i class="bi bi-check-circle-fill"></i> Konfirmasi otomatis

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- RIGHT --}}
                            <div class="col-lg-7">

                                <div class="booking-right">

                                    <h3 class="fw-bold mb-4">

                                        Form Data Penyewa

                                    </h3>

                                    <form method="POST" action="{{ route('booking.store') }}">

                                        @csrf

                                        <div class="row">

                                            {{-- NAMA --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Nama Lengkap
                                                </label>

                                                <input type="text" name="name" class="form-control booking-input"
                                                    value="{{ auth()->user()->name }}" readonly>

                                            </div>

                                            {{-- EMAIL --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Email
                                                </label>

                                                <input type="email" class="form-control booking-input"
                                                    value="{{ auth()->user()->email }}" readonly>

                                            </div>

                                            {{-- PHONE --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Nomor Handphone
                                                </label>

                                                <input type="text" name="phone" class="form-control booking-input"
                                                    value="{{ auth()->user()->phone }}" readonly>

                                            </div>

                                            {{-- TEMPAT LAHIR --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Tempat Lahir
                                                </label>

                                                <input type="text" name="birth_place" class="form-control booking-input"
                                                    value="{{ auth()->user()->birth_place }}" readonly>

                                            </div>

                                            {{-- TANGGAL LAHIR --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Tanggal Lahir
                                                </label>

                                                <input type="date" name="birth_date" class="form-control booking-input"
                                                    value="{{ auth()->user()->birth_date }}" readonly>

                                            </div>

                                            {{-- MULAI SEWA --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Tanggal Mulai Sewa
                                                </label>

                                                <input type="date" name="start_date" id="start_date"
                                                    class="form-control booking-input" min="{{ now()->toDateString() }}"
                                                    required>

                                            </div>

                                            {{-- KAMAR --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Pilih Kamar
                                                </label>

                                                <select name="room_id" id="room" class="form-control booking-input"
                                                    required>

                                                    <option value="">
                                                        -- Pilih Kamar --
                                                    </option>

                                                    @foreach ($rooms as $room)
                                                        <option value="{{ $room->id }}" data-price="{{ $room->price }}"
                                                            {{ $selectedRoom == $room->id ? 'selected' : '' }}>

                                                            {{ $room->name }}
                                                            -
                                                            Rp {{ number_format($room->price, 0, ',', '.') }}/bulan

                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>

                                            {{-- DURASI --}}
                                            <div class="col-md-6 mb-4">

                                                <label class="form-label">
                                                    Durasi Sewa (Bulan)
                                                </label>

                                                <div class="col-md-12 mb-4">

                                                    <div class="duration-box">

                                                        <button type="button" id="minusDuration" class="duration-btn">

                                                            <i class="bi bi-dash-lg"></i>

                                                        </button>

                                                        <input type="text" id="duration" name="duration" value="1"
                                                            readonly>

                                                        <button type="button" id="plusDuration" class="duration-btn">

                                                            <i class="bi bi-plus-lg"></i>

                                                        </button>

                                                    </div>


                                                </div>

                                            </div>

                                            {{-- RINGKASAN --}}
                                            <div class="col-md-12 mb-4">

                                                <div class="card border-0 shadow-sm rounded-4">

                                                    <div class="card-body">

                                                        <h5 class="fw-bold mb-3">

                                                            <i class="bi bi-receipt-cutoff text-success me-2"></i>

                                                            Ringkasan Pembayaran

                                                        </h5>

                                                        <div class="d-flex justify-content-between mb-2">

                                                            <span>Harga / Bulan</span>

                                                            <strong id="monthlyPrice">

                                                                Rp0

                                                            </strong>

                                                        </div>

                                                        <div class="d-flex justify-content-between mb-2">

                                                            <span>Durasi</span>

                                                            <strong id="durationText">

                                                                1 Bulan

                                                            </strong>

                                                        </div>

                                                        <div class="d-flex justify-content-between mb-2">

                                                            <span>Estimasi Selesai Sewa</span>

                                                            <strong id="endDate">

                                                                -

                                                            </strong>

                                                        </div>

                                                        <hr>

                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <h5 class="mb-0">

                                                                Total Bayar

                                                            </h5>

                                                            <h4 class="fw-bold text-success mb-0" id="totalPrice">

                                                                Rp0

                                                            </h4>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <button type="submit" class="btn booking-btn w-100">

                                                    Lanjut ke Pembayaran

                                                </button>

                                            </div>

                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
