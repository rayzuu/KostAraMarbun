@extends('layouts.admin')

@section('title', 'Laporan Penyewa')

@section('page-title', 'Laporan Penyewa')

@section('content')

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <form method="GET"
            action="{{ route('report.tenant') }}">

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Bulan
                    </label>

                    <select name="month" class="form-select">

                        @for($i = 1; $i <= 12; $i++)

                            <option
                                value="{{ $i }}"
                                {{ $month == $i ? 'selected' : '' }}
                            >

                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

                            </option>

                        @endfor

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Tahun
                    </label>

                    <select name="year" class="form-select">

                        @for($i = now()->year; $i >= 2024; $i--)

                            <option
                                value="{{ $i }}"
                                {{ $year == $i ? 'selected' : '' }}
                            >

                                {{ $i }}

                            </option>

                        @endfor

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Status Penyewa
                    </label>

                    <select name="tenant_status"
                        class="form-select">

                        <option value="">
                            Semua
                        </option>

                        <option
                            value="active"
                            {{ $tenantStatus == 'active' ? 'selected' : '' }}
                        >

                            Active

                        </option>

                        <option
                            value="inactive"
                            {{ $tenantStatus == 'inactive' ? 'selected' : '' }}
                        >

                            Inactive

                        </option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Status Pembayaran
                    </label>

                    <select name="payment_status"
                        class="form-select">

                        <option value="">
                            Semua
                        </option>

                        <option
                            value="paid"
                            {{ $paymentStatus == 'paid' ? 'selected' : '' }}
                        >

                            Paid

                        </option>

                        <option
                            value="unpaid"
                            {{ $paymentStatus == 'unpaid' ? 'selected' : '' }}
                        >

                            Unpaid

                        </option>

                    </select>

                </div>

            </div>

            <button class="btn btn-success">

                Filter Laporan

            </button>

        </form>

    </div>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Nama</th>
                        <th>Kamar</th>
                        <th>Mulai Sewa</th>
                        <th>Status Penyewa</th>
                        <th>Status Pembayaran</th>
                        <th>Total Bayar</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($reports as $report)

                        @php
                            $payment = $report->payments->last();
                        @endphp

                        <tr>

                            <td>

                                {{ $report->name }}

                            </td>

                            <td>

                                {{ $report->room->name ?? '-' }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($report->start_date)->format('d M Y') }}

                            </td>

                            <td>

                                @if($report->status == 'active')

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($payment)

                                    @if($payment->status == 'paid')

                                        <span class="badge bg-success">

                                            Paid

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            Unpaid

                                        </span>

                                    @endif

                                @endif

                            </td>

                            <td>

                                Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-4">

                                Belum ada data laporan penyewa

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection