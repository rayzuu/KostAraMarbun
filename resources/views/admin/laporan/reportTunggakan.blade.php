@extends('layouts.admin')

@section('title', 'Laporan Tunggakan')

@section('page-title', 'Laporan Tunggakan')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <h4 class="fw-bold mb-0">
                Data Tunggakan Penyewa
            </h4>

        </div>

        {{-- FILTER --}}
        <form method="GET" class="row g-3 mb-4">

            <div class="col-md-3">

                <label class="form-label">
                    Bulan
                </label>

                <select name="month" class="form-select">

                    @for($i = 1; $i <= 12; $i++)

                        <option value="{{ $i }}"
                            {{ $month == $i ? 'selected' : '' }}>

                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}

                        </option>

                    @endfor

                </select>

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Tahun
                </label>

                <select name="year" class="form-select">

                    @for($i = now()->year; $i >= 2024; $i--)

                        <option value="{{ $i }}"
                            {{ $year == $i ? 'selected' : '' }}>

                            {{ $i }}

                        </option>

                    @endfor

                </select>

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button class="btn btn-primary w-100">

                    Filter

                </button>

            </div>

        </form>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Nama</th>
                        <th>Kamar</th>
                        <th>No HP</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Total</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($arrears as $payment)

                        <tr>

                            <td>

                                {{ $payment->booking->name ?? '-' }}

                            </td>

                            <td>

                                {{ $payment->booking->room->name ?? '-' }}

                            </td>

                            <td>

                                {{ $payment->booking->phone ?? '-' }}

                            </td>

                            <td>

                                {{ DateTime::createFromFormat('!m', $payment->payment_month)->format('F') }}

                            </td>

                            <td>

                                {{ $payment->payment_year }}

                            </td>

                            <td>

                                Rp {{ number_format($payment->amount, 0, ',', '.') }}

                            </td>

                            <td>

                                <span class="badge bg-danger">

                                    Unpaid

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-4">

                                Tidak ada tunggakan

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection