@extends('layouts.admin')

@section('title', 'Tambah Penyewa')

@section('page-title', 'Tambah Penyewa')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form method="POST"
            action="{{ route('bookings.manual.store') }}">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Nama Penyewa
                </label>

                <input type="text"
                    name="name"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    No HP
                </label>

                <input type="text"
                    name="phone"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Tempat Lahir
                </label>

                <input type="text"
                    name="birth_place"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Tanggal Lahir
                </label>

                <input type="date"
                    name="birth_date"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Mulai Sewa
                </label>

                <input type="date"
                    name="start_date"
                    class="form-control"
                    required>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Pilih Kamar
                </label>

                <select name="room_id"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Kamar --
                    </option>

                    @foreach($rooms as $room)

                        <option value="{{ $room->id }}">

                            {{ $room->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <button class="btn btn-primary">

                Simpan Penyewa

            </button>

        </form>

    </div>

</div>

@endsection