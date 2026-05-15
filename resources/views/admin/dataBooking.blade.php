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
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($bookings as $booking)

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

                                    {{ $booking->room->name }}

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}

                                </td>

                                <td>

                                    @if ($booking->status == 'paid')

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

                                    <div class="d-flex gap-2 flex-wrap">

                                        <a href="{{ route('bookings.edit', $booking->id) }}"
                                            class="btn btn-warning btn-sm">

                                            Edit

                                        </a>

                                        <form method="POST"
                                            action="{{ route('bookings.destroy', $booking->id) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data penyewa?')">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-4">

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