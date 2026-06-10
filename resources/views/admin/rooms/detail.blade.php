@extends('layouts.app')

@section('title', $room->name)

@section('content')

    <section class="py-5">

        <div class="container">

            <div class="row g-4 align-items-start">

                <div class="col-lg-7">

                    <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">

                        <div class="carousel-inner rounded-4">

                            @if ($room->images->count() > 0)

                                @foreach ($room->images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                                        <img src="{{ asset('storage/' . $image->image) }}"
                                            class="d-block w-100 detail-main-image">

                                    </div>
                                @endforeach
                            @elseif($room->image)
                                <div class="carousel-item active">

                                    <img src="{{ asset('storage/' . $room->image) }}"
                                        class="d-block w-100 detail-main-image">

                                </div>

                            @endif

                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel"
                            data-bs-slide="prev">

                            <span class="carousel-control-prev-icon"></span>

                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel"
                            data-bs-slide="next">

                            <span class="carousel-control-next-icon"></span>

                        </button>

                    </div>

                </div>

                <div class="col-lg-5">

                    <div class="detail-card">

                        @if ($room->status == 'available')
                            <span class="badge bg-success mb-3 px-3 py-2">

                                Available

                            </span>
                        @else
                            <span class="badge bg-danger mb-3 px-3 py-2">

                                Full

                            </span>
                        @endif

                        <h1 class="mb-3" style="font-weight: 700; font-size: 2rem;">
                            {{ $room->name }}
                        </h1>
                        @php

                            $totalPenghuni = $room->bookings->where('status', 'active')->count();

                            $sisaKamar = max(0, $room->kapasitas - $totalPenghuni);

                        @endphp

                        <div class="mb-3">

                            <span class="badge bg-success px-3 py-2">

                                Sisa Kamar:
                                {{ $sisaKamar }}
                                / {{ $room->kapasitas }}

                            </span>

                        </div>

                        <h3 class="text-primary fw-bold mb-3">

                            Rp {{ number_format($room->price) }}
                            / bulan

                        </h3>

                        <p class="mb-5" style="text-align: justify;">
                            {{ $room->description }}

                        </p>

                        <a href="https://wa.me/6285227794397?text=Saya%20ingin%20booking%20kamar%20{{ urlencode($room->name) }}"
                            target="_blank" class="btn btn-success btn-lg w-100">

                            <i class="bi bi-whatsapp me-2"></i>
                            Booking via WhatsApp

                        </a>

                        @if ($sisaKamar > 0)
                            <a href="{{ route('booking.create', ['room' => $room->id]) }}" class="btn btn-primary btn-lg w-100 mt-3">
                                Ajukan Sewa
                            </a>
                        @else
                            <button class="btn btn-primary btn-lg w-100 mt-3 room-full-btn">
                                Kamar Penuh
                            </button>
                        @endif
                        

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
