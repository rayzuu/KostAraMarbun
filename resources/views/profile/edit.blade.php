@extends('layouts.app')

@section('title', 'Akun Saya')

@section('content')

    <section class="py-5">

        ```
        <div class="container">

            {{-- PROFILE HEADER --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">

                <div class="profile-header">

                    <div class="profile-avatar">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>
                    <h2 class="fw-bold mb-2">

                        {{ auth()->user()->name }}

                    </h2>

                    <p class="mb-3 opacity-75">

                        {{ auth()->user()->email }}

                    </p>

                    @if ($booking)

                        @if ($booking->status == 'active')
                            <span class="badge bg-success px-3 py-2">

                                Penyewa Aktif

                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">

                                Penyewa Tidak Aktif

                            </span>
                        @endif

                        <div class="mt-3">

                            <strong>

                                {{ $booking->room->name ?? '-' }}

                            </strong>

                        </div>

                    @endif

                </div>

            </div>

            @if ($booking)

                <div class="row g-4 mb-4">

                    {{-- DATA DIRI --}}
                    <div class="col-lg-6">

                        <div class="card border-0 shadow-sm rounded-4 h-100">

                            <div class="card-body p-4">

                                <h4 class="fw-bold mb-4">

                                    <i class="bi bi-person-fill text-success me-2"></i>

                                    Data Diri Penyewa

                                </h4>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Nama Lengkap
                                    </small>

                                    <div class="fw-semibold">

                                        {{ $booking->name }}

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Nomor Handphone
                                    </small>

                                    <div class="fw-semibold">

                                        {{ $booking->phone }}

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Tempat Lahir
                                    </small>

                                    <div class="fw-semibold">

                                        {{ $booking->birth_place }}

                                    </div>

                                </div>

                                <div>

                                    <small class="text-muted">
                                        Tanggal Lahir
                                    </small>

                                    <div class="fw-semibold">

                                        {{ \Carbon\Carbon::parse($booking->birth_date)->format('d M Y') }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- DATA SEWA --}}
                    <div class="col-lg-6">

                        <div class="card border-0 shadow-sm rounded-4 h-100">

                            <div class="card-body p-4">

                                <h4 class="fw-bold mb-4">

                                    <i class="bi bi-house-door-fill text-success me-2"></i>

                                    Data Penyewaan

                                </h4>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Nama Kamar
                                    </small>

                                    <div class="fw-semibold">

                                        {{ $booking->room->name ?? '-' }}

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Status Penyewa
                                    </small>

                                    <div>

                                        @if ($booking->status == 'active')
                                            <span class="badge bg-success">

                                                Active

                                            </span>
                                        @else
                                            <span class="badge bg-secondary">

                                                Inactive

                                            </span>
                                        @endif

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Tanggal Masuk
                                    </small>

                                    <div class="fw-semibold">

                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}

                                    </div>

                                </div>

                                <div>

                                    <small class="text-muted">
                                        Tanggal Keluar
                                    </small>

                                    <div class="fw-semibold">

                                        @if ($booking->end_date)
                                            {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                        @else
                                            Masih Aktif
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            @else
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body text-center p-5">

                        <i class="bi bi-house fs-1 text-success"></i>

                        <h4 class="fw-bold mt-3">

                            Belum Ada Data Penyewaan

                        </h4>

                        <p class="text-muted">

                            Silakan ajukan sewa kamar terlebih dahulu untuk melihat data penyewaan.

                        </p>

                        <a href="{{ route('booking.create') }}" class="btn btn-success rounded-pill px-4">

                            Ajukan Sewa

                        </a>

                    </div>

                </div>

            @endif

            {{-- DATA AKUN --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        <i class="bi bi-person-circle text-success me-2"></i>

                        Data Akun

                    </h4>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <small class="text-muted">

                                Nama Akun

                            </small>

                            <div class="fw-semibold">

                                {{ auth()->user()->name }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <small class="text-muted">

                                Email

                            </small>

                            <div class="fw-semibold">

                                {{ auth()->user()->email }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        ```

    </section>

@endsection
