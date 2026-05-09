@extends('layouts.app')

@section('title', $room->name)

@section('content')

<section class="py-5">

    <div class="container">

        <div class="row">

            {{-- IMAGE --}}
            <div class="col-lg-6 mb-4">

                @if($room->image)

                    <img src="{{ asset('storage/' . $room->image) }}"
                        class="img-fluid rounded-4 shadow">

                @endif

            </div>

            {{-- DETAIL --}}
            <div class="col-lg-6">

                <span class="badge bg-success mb-3">

                    {{ $room->status }}

                </span>

                <h1 class="fw-bold">

                    {{ $room->name }}

                </h1>

                <p class="text-muted">

                    {{ $room->location }}

                </p>

                <h2 class="text-primary fw-bold mb-4">

                    Rp {{ number_format($room->price) }} / bulan

                </h2>

                <div class="mb-4">

                    <h5>Deskripsi</h5>

                    <p>

                        {{ $room->description }}

                    </p>

                </div>

                {{-- BOOKING BUTTON --}}
                <a href="https://wa.me/6281234567890?text=Saya%20ingin%20booking%20kamar%20{{ urlencode($room->name) }}"
                    target="_blank"
                    class="btn btn-success btn-lg w-100">

                    Booking via WhatsApp

                </a>

            </div>

        </div>

    </div>

</section>

@endsection