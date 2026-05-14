@extends('layouts.admin')

@section('title', 'Data Pelanggan')

@section('page-title', 'Data Pelanggan')

@section('content')

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="fw-bold">
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
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($bookings as $booking)
                            <tr>

                                <td>

                                    {{ $booking->name }}

                                </td>

                                <td>

                                    {{ $booking->phone }}

                                </td>

                                <td>

                                    {{ $booking->room->name }}

                                </td>

                                <td>

                                    {{ $booking->start_date }}

                                </td>

                                <td>

                                    @if ($booking->status == 'pending')
                                        <span class="badge bg-warning">

                                            Pending

                                        </span>
                                    @elseif($booking->status == 'approved')
                                        <span class="badge bg-success">

                                            Approved

                                        </span>
                                    @else
                                        <span class="badge bg-danger">

                                            Rejected

                                        </span>
                                    @endif

                                </td>
                                <td>

                                    <div class="d-flex gap-2">

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

                                <td colspan="5" class="text-center">

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
