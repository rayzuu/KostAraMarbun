    @extends('layouts.app')

    @section('title', 'Kost Ara Marbun')

    @section('content')

   <section class="hero-section" style="background-image: url('{{ asset('image/kost.jpg') }}');">>
    

    <div class="hero-overlay"></div>

    <div class="container position-relative">

        <div class="row align-items-center min-vh-100">

            <div class="col-lg-7">

                <span class="hero-badge">
                    Kost Nyaman & Modern
                </span>

                <h1 class="hero-title text-white">

                    KOST ARA MARBUN

                </h1>

                <p class="hero-text text-light">

                    Langsung booking kamar
                    nyaman dan strategis
                    melalui WhatsApp pemilik kost.

                </p>

                <div class="hero-action">

                    <a href="{{ route('rooms.all') }}"
                        class="btn btn-primary btn-lg px-4 py-3">

                        Cari Kamar

                    </a>

                </div>

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

                                        Full

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
{{-- FACILITIES --}}
<section class="facility-section">

    <div class="container">

        <div class="section-header text-center mb-5">

            <h2>
                Fasilitas Kost
            </h2>

            <p>
                Nikmati fasilitas nyaman dan lengkap
            </p>

        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">

                <div class="facility-card">

                    <div class="facility-icon">
                        <i class="bi bi-file-bar-graph"></i>
                    </div>

                    <h5>WiFi Cepat</h5>

                    <p>
                        Free Wifi untuk penghuni Kost
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-4">

                <div class="facility-card">

                    <div class="facility-icon">
                        <i class="fa-solid fa-bath"></i>
                    </div>

                    <h5>Kamar Mandi</h5>

                    <p>
                        Kamar mandi bersih dan nyaman
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-4">

                <div class="facility-card">

                    <div class="facility-icon">
                        <i class="bi bi-lock-fill"></i>
                    </div>

                    <h5>Keamanan</h5>

                    <p>
                        Area aman dengan akses terjaga
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-4">

                <div class="facility-card">

                    <div class="facility-icon">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    <h5>Parkiran</h5>

                    <p>
                        Area parkir luas untuk penghuni
                    </p>

                </div>

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

                   

                    <h4 class="room-price">

                        Rp {{ number_format($room->price) }} / bulan

                    </h4>

                    {{-- STATUS --}}
                    @if($room->status == 'available')

                        <span class="badge bg-success mb-3">
                            Available
                        </span>

                    @else

                        <span class="badge bg-danger mb-3">
                            Full
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
{{-- LOCATION --}}
<section class="location-section">

    <div class="container">

        <div class="section-header text-center mb-5">

            <h2>
                Lokasi Kost
            </h2>

            <p>
                Lokasi strategis dan mudah dijangkau
            </p>

        </div>

       <div class="ratio ratio-16x9 rounded-4 overflow-hidden">

           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31649.973596846652!2d109.21596780635792!3d-7.437932274658042!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655ea49d9f9885%3A0x62be0b6159700ec9!2sTelkom%20University%20Purwokerto!5e0!3m2!1sid!2sid!4v1778365109788!5m2!1sid!2sid" 
           width="600" 
           height="450" 
           style="border:0;" 
           allowfullscreen="" 
           loading="lazy" 
           referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        </div>

    </div>

</section>
<a href="https://wa.me/6285227794397?text=Saya%20ingin%20bertanya%20tentang%20kost"
    class="wa-floating"
    target="_blank">

    <i class="bi bi-whatsapp"></i>

</a>
    class="wa-floating"
    target="_blank">

    <i class="bi bi-whatsapp"></i>

</a>
    @endsection