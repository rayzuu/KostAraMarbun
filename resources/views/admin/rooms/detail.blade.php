@extends('layouts.app')

@section('title', $room->name)

@section('content')

<section class="py-5">

    <div class="container">

        <div class="row g-4 align-items-start">

            <div class="col-lg-7">

               <div id="roomCarousel"
                    class="carousel slide"
                    data-bs-ride="carousel">

                 <div class="carousel-inner rounded-4">

                    @if($room->images->count() > 0)

                        @foreach($room->images as $key => $image)

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

    <button class="carousel-control-prev"
        type="button"
        data-bs-target="#roomCarousel"
        data-bs-slide="prev">

        <span class="carousel-control-prev-icon"></span>

    </button>

    <button class="carousel-control-next"
        type="button"
        data-bs-target="#roomCarousel"
        data-bs-slide="next">

        <span class="carousel-control-next-icon"></span>

    </button>

    </div>

            </div>

            <div class="col-lg-5">

                <div class="detail-card">

                    <span class="badge bg-primary mb-3">

                        {{ ucfirst($room->status) }}

                    </span>

                    <h1 class="fw-bold mb-2">

                        {{ $room->name }}

                    </h1>


                    <h3 class="text-primary fw-bold mb-4">

                        Rp {{ number_format($room->price) }}
                        / bulan

                    </h3>

                    <p class="mb-4">

                        {{ $room->description }}

                    </p>

                    <a href="https://wa.me/6285227794397?text=Saya%20ingin%20booking%20kamar%20{{ urlencode($room->name) }}"
                        target="_blank"
                        class="btn btn-success btn-lg w-100">

                        <i class="bi bi-whatsapp me-2"></i>
                            Booking via WhatsApp

                    </a>

                  <a href="{{ route('booking.create', [
                        'room' => $room->id
                    ]) }}"
                        class="btn btn-primary btn-lg w-100 mt-3">

                        Ajukan Sewa

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection