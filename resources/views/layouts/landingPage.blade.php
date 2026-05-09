    @extends('layouts.app')

    @section('title', 'Kost Ara Marbun')

    @section('content')

    <section class="hero-section">

        <div class="container">

            <div class="row align-items-center min-vh-75">

                <div class="col-lg-6">

                    <span class="hero-badge">
                        Kost Nyaman & Modern
                    </span>

                    <h1 class="hero-title">
                        KOST KETUA NAGA HITAM
                    </h1>

                    <p class="hero-text">
                        LANGSUNG BOOKING KE NOMOR KETUA
                    </p>

                    <div class="hero-action">
                        <a href="#" class="btn btn-primary btn-lg">
                            Cari Kamar
                        </a>
                    </div>

                </div>

                <div class="col-lg-6">

                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267"
                        class="img-fluid hero-image">

                </div>

            </div>

        </div>

    </section>
    {{-- SEARCH FILTER --}}
    <section class="mb-5">

        <div class="container">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <form method="GET" action="/">

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

        </div>

    </section>

    <section class="room-section">

        <div class="container">

            <div class="section-header d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Katalog Kamar</h2>

        <p>
            Pilihan kamar terbaik dengan fasilitas lengkap
        </p>

    </div>

    <a href="{{ route('rooms.all') }}"
        class="btn btn-outline-primary">

        Lihat Semua Kamar

    </a>

</div>

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

        </div>

    </section>

    @endsection