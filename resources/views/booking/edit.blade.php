@extends('layouts.admin')

@section('title', 'Edit Penyewa')

@section('page-title', 'Edit Penyewa')

@section('content')

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form method="POST" action="{{ route('bookings.update', $booking->id) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Nama Penyewa
                    </label>

                    <input type="text" name="name" class="form-control" value="{{ $booking->name }}" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        No HP
                    </label>

                    <input type="text" name="phone" class="form-control" value="{{ $booking->phone }}" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tempat Lahir
                    </label>

                    <input type="text" name="birth_place" class="form-control" value="{{ $booking->birth_place }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tanggal Lahir
                    </label>

                    <input type="date" name="birth_date" class="form-control" value="{{ $booking->birth_date }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Mulai Sewa
                    </label>

                    <input type="date" name="start_date" class="form-control" value="{{ $booking->start_date }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Status Penyewa
                    </label>

                    <select name="tenant_status" class="form-select">

                        <option value="active" {{ $booking->status == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive" {{ $booking->status == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Status Pembayaran 
                    </label>

                    <select name="payment_status" class="form-select">

                        <option value="paid">
                            Paid
                        </option>

                        <option value="unpaid">
                            Unpaid
                        </option>

                    </select>

                </div>

                {{-- PILIH KAMAR --}}
                <div class="mb-4">

                    <label class="form-label">
                        Pilih Kamar
                    </label>

                    <select name="room_id" class="form-select">

                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ $booking->room_id == $room->id ? 'selected' : '' }}>

                                {{ $room->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <button class="btn btn-primary">

                    Update Penyewa

                </button>

            </form>

        </div>

    </div>

@endsection
