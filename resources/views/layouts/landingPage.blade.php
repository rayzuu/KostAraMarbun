@extends('layouts.app')

@section('title', 'Kost Ara Marbun')

@section('content')

    <section class="hero-section" style="background-image:url('{{ asset('image/background.jpg') }}')">

        <div class="container">

            <div class="row align-items-center min-vh-100">

                {{-- LEFT --}}
                <div class="col-lg-5">

                    <div class="hero-content">

                        <div class="hero-tag">

                            <i class="bi bi-shield-check-fill"></i>

                            Kost Putri SMP & SMA

                        </div>

                        <h1 class="hero-title">

                            Hunian Aman & Nyaman untuk
                            <span>Pelajar Putri</span>

                        </h1>

                        <p class="hero-text">

                            Kost khusus putri tingkat SMP & SMA dengan lingkungan nyaman,
                            aman, bersih dan strategis untuk mendukung kegiatan belajar.

                        </p>

                        <div class="hero-action">

                            <a href="{{ route('rooms.all') }}" class="hero-btn-primary">

                                <i class="bi bi-building"></i>

                                Lihat Kamar

                            </a>

                            <a href="https://wa.me/6285227794397" target="_blank" class="hero-btn-secondary">

                                <i class="bi bi-whatsapp"></i>

                                Hubungi WhatsApp

                            </a>

                        </div>

                        <div class="hero-trusted">
                            <p>

                                Dipercaya oleh orang tua & siswi

                                <i class="bi bi-heart-fill"></i>

                            </p>

                        </div>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-7">

                    <div class="hero-image-wrapper">

                        <img src="{{ asset('image/kost.jpg') }}" class="hero-image">

                    </div>

                </div>

            </div>

        </div>

    </section>
    {{-- FEATURE BAR --}}
    <section class="feature-bar">

        <div class="container">

            <div class="feature-wrapper">

                <div class="row g-4">

                    <div class="col-lg-3 col-md-6">

                        <div class="feature-item">

                            <div class="feature-icon">

                                <i class="bi bi-shield-check"></i>

                            </div>

                            <div>

                                <h5>Aman & Terpercaya</h5>

                                <p>
                                    Lingkungan terjaga dan pengawasan 24 jam.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <div class="feature-item">

                            <div class="feature-icon">

                                <i class="bi bi-geo-alt-fill"></i>

                            </div>

                            <div>

                                <h5>Lokasi Strategis</h5>

                                <p>
                                    Dekat sekolah, minimarket, dan fasilitas umum.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <div class="feature-item">

                            <div class="feature-icon">

                                <i class="fa-solid fa-bed"></i>

                            </div>

                            <div>

                                <h5>Kamar Nyaman</h5>

                                <p>
                                    Kamar bersih, rapi, dan nyaman untuk belajar.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <div class="feature-item">

                            <div class="feature-icon">

                                <i class="fa-solid fa-wifi"></i>

                            </div>

                            <div>

                                <h5>Fasilitas Lengkap</h5>

                                <p>
                                    WiFi, kamar mandi dalam, lemari, dan lainnya.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- SEARCH FILTER --}}
    {{-- 
<section class="py-4">

    <div class="container">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <form method="GET" action="/">

                    <div class="row align-items-center">

                        
                        <div class="col-lg-4 col-md-6 mb-3">

                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control rounded-3" placeholder="Cari kamar...">

                        </div>

                        
                        <div class="col-lg-3 col-md-6 mb-3">

                            <select name="status" class="form-control rounded-3">

                                <option value="">
                                    Semua Status
                                </option>

                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>

                                    Available

                                </option>

                                <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>

                                    Full

                                </option>

                            </select>

                        </div>

                        
                        <div class="col-lg-2 col-md-12 mb-3">

                            <button class="btn btn-success w-100 rounded-3">

                                Cari

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>
--}}

    {{-- FACILITY 
    
    div class="section-header text-center mb-5">

                <h2 class="fw-bold">
                    Fasilitas Kost
                </h2>

                <p class="text-muted">
                    Suasana nyaman dan fasilitas lengkap
                    untuk penghuni kost
                </p>

            </div>
            <div class="row g-3 mb-5">

                <div class="col-6 col-md-6 col-lg-3">

                    <div class="facility-card">

                        <div class="facility-icon text-success">

                            <i class="fa-solid fa-wifi"></i>

                        </div>

                        <h5>WiFi Cepat</h5>

                        <p>
                            Free Wifi untuk penghuni Kost
                        </p>

                    </div>

                </div>

                <div class="col-6 col-md-6 col-lg-3">

                    <div class="facility-card">

                        <div class="facility-icon text-success">

                            <i class="fa-solid fa-bath"></i>

                        </div>

                        <h5>Kamar Mandi</h5>

                        <p>
                            Kamar mandi bersih dan nyaman
                        </p>

                    </div>

                </div>

                <div class="col-6 col-md-6 col-lg-3">

                    <div class="facility-card">

                        <div class="facility-icon text-success">

                            <i class="fa-solid fa-lock"></i>

                        </div>

                        <h5>Keamanan</h5>

                        <p>
                            Area aman dengan akses terjaga
                        </p>

                    </div>

                </div>

                <div class="col-6 col-md-6 col-lg-3">

                    <div class="facility-card">

                        <div class="facility-icon text-success">

                            <i class="fa-solid fa-car"></i>

                        </div>

                        <h5>Parkiran</h5>

                        <p>
                            Area parkir luas untuk penghuni
                        </p>

                    </div>

                </div>

            </div> --}}

    <section class="facility-gallery py-5">

        <div class="container">
            @php

                $room = \App\Models\Room::first();

            @endphp

            @if ($room)

                {{-- CAROUSEL --}}
                <div id="facilityCarousel" class="carousel slide" data-bs-ride="carousel">

                    <div class="carousel-inner rounded-4 shadow-lg">



                        @foreach ($room->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                                <img src="{{ asset('storage/' . $image->image) }}" class="facility-image">

                            </div>
                        @endforeach

                    </div>

                    {{-- PREV --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#facilityCarousel"
                        data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>

                    </button>

                    {{-- NEXT --}}
                    <button class="carousel-control-next" type="button" data-bs-target="#facilityCarousel"
                        data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>

                    </button>

                </div>

                {{-- BUTTON --}}
                <div class="text-center mt-4">

                    <a href="{{ route('rooms.show', $room->id) }}"
                        class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow">

                        Detail Kamar

                    </a>

                </div>

            @endif

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

            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d498.07012354577535!2d99.0721545!3d2.9416532!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031844c9530597d%3A0x46b933a2264379d6!2sTOKO%20Marbun!5e0!3m2!1sid!2sid!4v1779110362235!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>

        </div>

    </section>

    {{-- WA FLOATING --}}
    <a href="https://wa.me/6285227794397?text=Saya%20ingin%20bertanya%20tentang%20kost" class="wa-floating" target="_blank">

        <i class="bi bi-whatsapp"></i>

    </a>

@endsection
