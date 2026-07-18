@extends('layouts.app')

@section('title', 'History Pembayaran')

@section('content')

    <section class="payment-history-section py-5">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

                <div>
                    <h2 class="fw-bold mb-1">
                        History Pembayaran
                    </h2>

                    <p class="text-muted mb-0">
                        Riwayat transaksi pembayaran kamar kost
                    </p>
                </div>

            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-modern align-middle mb-0">

                            <thead>

                                <tr>

                                    <th>Kamar</th>
                                    <th>Total</th>
                                    <th>Masa Sewa</th>
                                    <th>Metode</th>
                                    <th>VA Number</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($payments as $payment)
                                    <tr>

                                        {{-- KAMAR --}}
                                        <td>

                                            <div class="fw-semibold">
                                                {{ $payment->booking->room->name }}
                                            </div>

                                        </td>

                                        {{-- TOTAL --}}
                                        <td>

                                            <span class="fw-bold text-success">
                                                Rp {{ number_format($payment->amount) }}
                                            </span>

                                        </td>

                                        <td>

                                            {{ $payment->duration }} Bulan

                                        </td>

                                        {{-- METODE --}}
                                        <td>

                                            <span class="payment-method">

                                                {{ strtoupper($payment->bank ?? '-') }}

                                            </span>

                                        </td>

                                        {{-- VA --}}
                                        <td>

                                            @if ($payment->va_number)
                                                <div class="va-box">

                                                    {{ $payment->va_number }}

                                                </div>
                                            @else
                                                -
                                            @endif

                                        </td>

                                        {{-- STATUS --}}
                                        <td>

                                            @if ($payment->status == 'paid')
                                                <span class="badge-status success">

                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Berhasil

                                                </span>
                                            @elseif($payment->transaction_status == 'pending')
                                                <span class="badge-status pending">

                                                    <i class="bi bi-clock-fill"></i>
                                                    Pending

                                                </span>
                                            @elseif($payment->transaction_status == 'expire' || $payment->transaction_status == 'cancel')
                                                <span class="badge-status failed">

                                                    <i class="bi bi-x-circle-fill"></i>
                                                    Expired

                                                </span>
                                            @else
                                                <span class="badge-status unpaid">

                                                    <i class="bi bi-dash-circle-fill"></i>
                                                    Unpaid

                                                </span>
                                            @endif

                                        </td>

                                        {{-- TANGGAL --}}
                                        <td>

                                            <div class="small text-muted">

                                                {{ $payment->created_at->format('d M Y') }}

                                            </div>

                                            <div class="fw-semibold">

                                                {{ $payment->created_at->format('H:i') }}

                                            </div>

                                        </td>

                                        {{-- AKSI --}}
                                        <td>

                                            @if ($payment->status == 'paid')
                                                <a href="{{ route('payment.receipt', $payment->id) }}"
                                                    class="btn btn-sm btn-dark rounded-pill px-3">

                                                    <i class="bi bi-download me-1"></i>
                                                    Bukti

                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-secondary rounded-pill px-3" disabled>

                                                    Belum Tersedia

                                                </button>
                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="7" class="text-center py-5">

                                            <div class="text-muted">

                                                <i class="bi bi-receipt fs-1 d-block mb-3"></i>

                                                Belum ada pembayaran

                                            </div>

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
