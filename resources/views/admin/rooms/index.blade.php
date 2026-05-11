@extends('layouts.admin')

@section('title', 'Data Kamar')

@section('page-title', 'Data Kamar')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h4>Daftar Kamar</h4>

    <a href="{{ route('rooms.create') }}"
        class="btn btn-primary">

        Tambah Kamar

    </a>

</div>

<table class="table table-bordered bg-white align-middle">

    <thead>

        <tr>

            <th>Gambar</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Aksi</th>

        </tr>

    </thead>

    <tbody>

        @foreach($rooms as $room)

        <tr>

            <td>

                @if($room->image)

                    <img src="{{ asset('storage/' . $room->image) }}"
                        width="120"
                        class="rounded">

                @endif

            </td>

            <td>

                {{ $room->name }}

            </td>

            <td>

                Rp {{ number_format($room->price) }}

            </td>

            <td>

                {{ $room->location }}

            </td>

            <td>

                @if($room->status == 'available')

                    <span class="badge bg-success">
                        Available
                    </span>

                @else

                    <span class="badge bg-danger">
                        Booked
                    </span>

                @endif

            </td>

            {{-- ACTION --}}
            <td>

                <div class="d-flex gap-2">

                    <a href="{{ route('rooms.edit', $room->id) }}"
                        class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form action="{{ route('rooms.destroy', $room->id) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus kamar ini?')">

                            Hapus

                        </button>

                    </form>

                </div>

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

@endsection