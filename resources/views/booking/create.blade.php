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
                                            <div class="col-md-12 mb-3">

                                                <label class="form-label">

                                                    Nama Lengkap

                                                </label>

                                                <input type="text" name="name" class="form-control booking-input"
                                                    placeholder="Masukkan nama lengkap" required>

                                            </div>

                                            {{-- PHONE --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">

                                                    Nomor Handphone

                                                </label>

                                                <input type="text" name="phone" class="form-control booking-input"
                                                    placeholder="08xxxxxxxxxx" required>

                                            </div>

                                            {{-- TEMPAT LAHIR --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">

                                                    Tempat Lahir

                                                </label>

                                                <input type="text" name="birth_place" class="form-control booking-input"
                                                    placeholder="Contoh: Jakarta" required>

                                            </div>

                                            {{-- TANGGAL LAHIR --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">

                                                    Tanggal Lahir

                                                </label>

                                                <input type="date" name="birth_date" class="form-control booking-input"
                                                    required>

                                            </div>

                                            {{-- MULAI SEWA --}}
                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">

                                                    Tanggal Mulai Sewa

                                                </label>

                                                <input type="date" name="start_date" class="form-control booking-input"
                                                    required>

                                            </div>

                                            {{-- KAMAR --}}
                                            <div class="col-md-12 mb-4">

                                                <label class="form-label">

                                                    Pilih Kamar

                                                </label>

                                                <select name="room_id" class="form-control booking-input" required>

                                                    <option value="">
                                                        -- Pilih Kamar --
                                                    </option>

                                                    @foreach ($rooms as $room)
                                                        <option value="{{ $room->id }}"
                                                            {{ $selectedRoom == $room->id ? 'selected' : '' }}>

                                                            {{ $room->name }}
                                                            -
                                                            Rp {{ number_format($room->price) }}

                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>

                                            <div class="col-md-12">

                                                <button class="btn booking-btn w-100">

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
