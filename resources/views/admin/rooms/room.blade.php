@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard')

@section('content')

    {{-- TOP STATISTIC --}}
    <div class="row g-4">

        {{-- TOTAL PENGHUNI --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div>

                    <p class="dashboard-label">
                        Total Penghuni
                    </p>

                    <h2>
                        {{ $totalPenghuni }}
                    </h2>

                </div>

                <div class="dashboard-icon bg-primary">

                    <i class="bi bi-people-fill"></i>

                </div>

            </div>

        </div>

        {{-- TOTAL KAMAR --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div>

                    <p class="dashboard-label">
                        Total Kamar
                    </p>

                    <h2>
                        {{ $totalKamar }}
                    </h2>

                </div>

                <div class="dashboard-icon bg-dark">

                    <i class="bi bi-building"></i>

                </div>

            </div>

        </div>

        {{-- KAMAR TERSEDIA --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div>

                    <p class="dashboard-label">
                        Kamar Tersedia
                    </p>

                    <h2>
                        {{ $kamarTersedia }}
                    </h2>

                </div>

                <div class="dashboard-icon bg-success">

                    <i class="bi bi-check-circle-fill"></i>

                </div>

            </div>

        </div>

        {{-- KAMAR PENUH --}}
        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div>

                    <p class="dashboard-label">
                        Kamar Penuh
                    </p>

                    <h2>
                        {{ $kamarPenuh }}
                    </h2>

                </div>

                <div class="dashboard-icon bg-danger">

                    <i class="bi bi-x-circle-fill"></i>

                </div>

            </div>

        </div>

    </div>

    {{-- PENDAPATAN --}}
    <div class="row mt-2 g-4">

        {{-- TOTAL --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <h6 class="text-muted mb-2">

                        Total Pendapatan

                    </h6>

                    <h2 class="fw-bold text-success">

                        Rp {{ number_format($totalPendapatan,0,',','.') }}

                    </h2>

                </div>

            </div>

        </div>

        {{-- BULAN INI --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <h6 class="text-muted mb-2">

                        Pendapatan Bulan Ini

                    </h6>

                    <h2 class="fw-bold text-primary">

                        Rp {{ number_format($pendapatanBulanIni,0,',','.') }}

                    </h2>

                </div>

            </div>

        </div>

        {{-- BULAN LALU --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <h6 class="text-muted mb-2">

                        Pendapatan Bulan Lalu

                    </h6>

                    <h2 class="fw-bold text-dark">

                        Rp {{ number_format($pendapatanBulanLalu,0,',','.') }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART + INFO --}}
    <div class="row mt-2">

        {{-- CHART --}}
        <div class="col-lg-5 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">

                        Statistik Pendapatan

                    </h5>

                    <canvas id="incomeChart"></canvas>

                </div>

            </div>

        </div>

        {{-- INFO --}}
        <div class="col-lg-7 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">

                        Informasi Dashboard

                    </h5>

                    <div class="alert alert-success border-0">

                        Kamar tersedia saat ini sebanyak

                        <strong>
                            {{ $kamarTersedia }}
                        </strong>

                        kamar.

                    </div>

                    <div class="alert alert-danger border-0">

                        Kamar penuh saat ini sebanyak

                        <strong>
                            {{ $kamarPenuh }}
                        </strong>

                        kamar.

                    </div>

                    <div class="alert alert-primary border-0">

                        Total penghuni aktif saat ini sebanyak

                        <strong>
                            {{ $totalPenghuni }}
                        </strong>

                        orang.

                    </div>

                    <div class="alert alert-warning border-0">

                        Pendapatan bulan ini sebesar

                        <strong>

                            Rp {{ number_format($pendapatanBulanIni,0,',','.') }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- PAYMENT TERBARU --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h5 class="fw-bold">
                    Payment Terbaru
                </h5>

            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Nama</th>
                            <th>Kamar</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($latestPayments as $payment)

                            <tr>

                                <td>

                                    {{ $payment->booking->name ?? '-' }}

                                </td>

                                <td>

                                    {{ $payment->booking->room->name ?? '-' }}

                                </td>

                                <td>

                                    Rp {{ number_format($payment->amount,0,',','.') }}

                                </td>

                                <td>

                                    @if($payment->status == 'paid')

                                        <span class="badge bg-success">

                                            Paid

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            Unpaid

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $payment->created_at->format('d M Y') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-4">

                                    Belum ada payment

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- RECENT ROOM --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h5 class="fw-bold">
                    Data Kamar Terbaru
                </h5>

                <a href="{{ route('rooms.index') }}" class="btn btn-primary">

                    Kelola Kamar

                </a>

            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($latestRooms as $room)

                            <tr>

                                <td>

                                    @if ($room->image)

                                        <img src="{{ asset('storage/' . $room->image) }}"
                                            width="80"
                                            class="rounded-3">

                                    @endif

                                </td>

                                <td>

                                    {{ $room->name }}

                                </td>

                                <td>

                                    Rp {{ number_format($room->price,0,',','.') }}

                                </td>

                                <td>

                                    @if ($room->status == 'available')

                                        <span class="badge bg-success">

                                            Available

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Full

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-4">

                                    Belum ada data kamar

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>

        const ctx = document.getElementById('incomeChart');

        new Chart(ctx, {

            type: 'doughnut',

            data: {

                labels: [

                    'Bulan Ini',
                    'Bulan Lalu'

                ],

                datasets: [{

                    data: [

                        {{ $pendapatanBulanIni }},
                        {{ $pendapatanBulanLalu }}

                    ],

                    backgroundColor: [

                        '#22c55e',
                        '#3b82f6'

                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                plugins: {

                    legend: {

                        display: true,

                        position: 'bottom'

                    }

                }

            }

        });

    </script>

@endsection