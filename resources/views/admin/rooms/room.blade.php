@extends('layouts.app')

@section('title', 'Semua Kamar')

@section('content')

<section class="py-5">

    <div class="container">

        {{-- HEADER --}}
        <div class="mb-5">

            <h2 class="fw-bold">
                Semua Kamar
            </h2>

            <p class="text-muted">
                Temukan kamar terbaik untuk anda
            </p>

        </div>

        {{-- SEARCH FILTER --}}
        <div class="card border-0 shadow-sm rounded-4 mb-5">

            <div class="card-body p-4">

                <form method="GET">

                    <div class="row">

                        {{-- SEARCH --}}
                        <div class="col-lg-4 mb-3">

                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Cari kamar...">

                        </div>

                        {{-- LOCATION --}}
                        <div class="col-lg-3 mb-3">

                            <select name="location"
                                class="form-control">

                                <option value="">
                                    Semua Lokasi
                                </option>

                                @foreach($locations as $location)

                                    <option value="{{ $location }}"
                                        {{ request('location') == $location ? 'selected' : '' }}>

                                        {{ $location }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- STATUS --}}
                        <div class="col-lg-3 mb-3">

                            <select name="status"
                                class="form-control">

                                <option value="">
                                    Semua Status
                                </option>

                                <option value="available"
                                    {{ request('status') == 'available' ? 'selected' : '' }}>

                                    Available

                                </option>

                                <option value="booked"
                                    {{ request('status') == 'booked' ? 'selected' : '' }}>

                                    Booked

                                </option>

                            </select>

                        </div>

                        {{-- BUTTON --}}
                        <div class="col-lg-2 mb-3">

                            <button class="btn btn-primary w-100">

                                Cari

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- ROOM LIST --}}
        <div class="row">

            @forelse($rooms as $room)

            <div class="col-lg-4 mb-4">

                <div class="room-card">

                    {{-- IMAGE --}}
                    @if($room->image)

                        <img src="{{ asset('storage/' . $room->image) }}"
                            class="room-image">

                    @else

                        <img src="https://via.placeholder.com/400x300"
                            class="room-image">

                    @endif

                    <div class="room-body">

                        <h5>{{ $room->name }}</h5>

                        <p class="room-location">

                            {{ $room->location }}

                        </p>

                        <h4 class="room-price">

                            Rp {{ number_format($room->price) }} / bulan

                        </h4>

                        {{-- STATUS --}}
                        @if($room->status == 'available')

                            <span class="badge bg-success mb-3">
                                Tersedia
                            </span>

                        @else

                            <span class="badge bg-danger mb-3">
                                Penuh
                            </span>

                        @endif

                        <br>

                        <a href="{{ route('rooms.show', $room->id) }}"
                            class="btn btn-outline-primary w-100">

                            Lihat Detail

                        </a>

                    </div>

                </div>

            </div>

            @empty

            <div class="col-12 text-center">

                <h5>Belum ada kamar tersedia</h5>

            </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-4">

            {{ $rooms->links() }}

        </div>

    </div>

</section>

@endsection