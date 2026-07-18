@extends('layouts.admin')

@section('title', 'Data Pelanggan')

@section('page-title', 'Data Pelanggan')

@section('content')

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

                <h4 class="fw-bold mb-0">
                    Data Penyewa Kost
                </h4>

                <a href="{{ route('bookings.manual.create') }}" class="btn btn-primary">

                    Tambah Penyewa

                </a>

            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Kamar</th>
                            <th>Mulai Sewa</th>
                            <th>Tanggal Keluar</th>
                            <th>Status Penyewa</th>
                            <th>Status Pembayaran</th>
                            <th>Masa Sewa</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($bookings as $booking)

                            @php

                                // PAYMENT TERBARU
                                $latestPayment = $booking->payments
                                    ->sortByDesc(function ($item) {
                                        return $item->payment_year . $item->payment_month;
                                    })
                                    ->first();

                                // TOTAL PAYMENT PAID
                                $totalPaid = $booking->payments->where('status', 'paid')->sum('amount');

                            @endphp

                            <tr>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $booking->name }}

                                    </div>

                                </td>

                                <td>

                                    {{ $booking->phone }}

                                </td>

                                <td>

                                    {{ $booking->room->name ?? '-' }}

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}

                                </td>

                                <td>

                                    @if ($booking->end_date)
                                        {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                    @else
                                        -
                                    @endif

                                </td>

                                {{-- STATUS PENYEWA --}}
                                <td>

                                    @if ($booking->status == 'active')
                                        <span class="badge bg-success px-3 py-2">

                                            Active

                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">

                                            Inactive

                                        </span>
                                    @endif

                                </td>

                                {{-- STATUS PAYMENT --}}
                                <td>

                                    @if ($latestPayment)
                                        @if ($latestPayment->status == 'paid')
                                            <span class="badge bg-success px-3 py-2">

                                                Paid

                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2">

                                                Unpaid

                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">

                                            No Payment

                                        </span>
                                    @endif

                                </td>

                                <td>

                                    @if ($latestPayment)
                                        {{ $latestPayment->duration }} Bulan
                                    @else
                                        -
                                    @endif

                                </td>

                                {{-- TOTAL PEMBAYARAN --}}
                                <td>

                                    Rp {{ number_format($totalPaid, 0, ',', '.') }}

                                </td>



                                <td>

                                    <div class="d-flex gap-2 flex-wrap">

                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">

                                            Edit

                                        </a>

                                        <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data penyewa?')">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-4">

                                    Belum ada data penyewa

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
