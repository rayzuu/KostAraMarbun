@extends('layouts.admin')

@section('title', 'Laporan Pembayaran')

@section('page-title', 'Laporan Pembayaran')

@section('content')

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <form method="GET" action="{{ route('report.index') }}">

                <div class="row align-items-end">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Bulan
                        </label>

                        <select name="month" class="form-select">

                            @for ($i = 1; $i <= 12; $i++)

                                <option
                                    value="{{ $i }}"
                                    {{ $month == $i ? 'selected' : '' }}
                                >

                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

                                </option>

                            @endfor

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Tahun
                        </label>

                        <select name="year" class="form-select">

                            @for ($i = now()->year; $i >= 2024; $i--)

                                <option
                                    value="{{ $i }}"
                                    {{ $year == $i ? 'selected' : '' }}
                                >

                                    {{ $i }}

                                </option>

                            @endfor

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <button class="btn btn-success w-100">

                            Filter Laporan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- TOTAL --}}
    <div class="row">

        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <p class="text-muted mb-2">

                        Total Pendapatan

                    </p>

                    <h3 class="fw-bold text-success">

                        Rp {{ number_format($totalIncome, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <p class="text-muted mb-2">

                        Total Pembayaran

                    </p>

                    <h3 class="fw-bold">

                        {{ $reports->count() }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <p class="text-muted mb-2">

                        Pembayaran Berhasil

                    </p>

                    <h3 class="fw-bold text-primary">

                        {{ $reports->where('status', 'paid')->count() }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

    <h5 class="fw-bold mb-0">
        Data Pembayaran
    </h5>

    <a
        href="{{ route('report.payment.pdf', request()->query()) }}"
        class="btn btn-danger">

        <i class="bi bi-file-earmark-pdf"></i>
        Download PDF

    </a>

</div>

            
            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Nama Penyewa</th>
                            <th>Kamar</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reports as $report)

                            <tr>

                                <td>

                                    {{ $report->booking->name ?? '-' }}

                                </td>

                                <td>

                                    {{ $report->booking->room->name ?? '-' }}

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::create()->month($report->payment_month)->translatedFormat('F') }}

                                </td>

                                <td>

                                    {{ $report->payment_year }}

                                </td>

                                <td>

                                    Rp {{ number_format($report->amount, 0, ',', '.') }}

                                </td>

                                <td>

                                    @if($report->status == 'paid')

                                        <span class="badge bg-success px-3 py-2">

                                            Paid

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark px-3 py-2">

                                            Unpaid

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($report->paid_at)

                                        {{ \Carbon\Carbon::parse($report->paid_at)->format('d M Y H:i') }}

                                    @else

                                        -

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-4">

                                    Belum ada data laporan

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection