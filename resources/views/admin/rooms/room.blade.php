@extends('layouts.app')

@section('content')

<section class="py-5">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">

            <div>

                <h2 class="fw-bold mb-2">

                    Semua Kamar Kost

                </h2>

                <p class="text-muted mb-0">

                    Pilih kamar yang sesuai kebutuhan kamu

                </p>

            </div>

            {{-- SEARCH --}}
            <form method="GET" class="d-flex gap-2">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari kamar..."
                       value="{{ request('search') }}">

                <select name="status" class="form-select">

                    <option value="">
                        Semua
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

                <button class="btn btn-primary">

                    Cari

                </button>

            </form>

        </div>

        <div class="row g-4">

            @forelse($rooms as $room)

                <div class="col-lg-4 col-md-6">

                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                        {{-- IMAGE --}}
                        @if($room->image)

                            <img src="{{ asset('storage/' . $room->image) }}"
                                 class="card-img-top"
                                 style="height:250px; object-fit:cover;">

                        @endif

                        <div class="card-body d-flex flex-column">

                            {{-- STATUS --}}
                            @if($room->status == 'available')

                                <span class="badge bg-success mb-3 align-self-start">

                                    Available

                                </span>

                            @else

                                <span class="badge bg-danger mb-3 align-self-start">

                                    Full

                                </span>

                            @endif

                            {{-- NAME --}}
                            <h5 class="fw-bold">

                                {{ $room->name }}

                            </h5>

                            {{-- PRICE --}}
                            <h4 class="text-primary fw-bold mb-3">

                                Rp {{ number_format($room->price,0,',','.') }}

                                <small class="fs-6 text-muted">
                                    / bulan
                                </small>

                            </h4>

                            {{-- DESC --}}
                            <p class="text-muted small flex-grow-1">

                                {{ Str::limit($room->description, 100) }}

                            </p>

                            {{-- BUTTON --}}
                            <a href="{{ route('rooms.show', $room->id) }}"
                               class="btn btn-primary rounded-pill mt-3">

                                Lihat Detail

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">

                    <h5 class="text-muted">

                        Kamar tidak ditemukan

                    </h5>

                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="mt-5 d-flex justify-content-center">

            {{ $rooms->links() }}

        </div>

    </div>

</section>

@endsection