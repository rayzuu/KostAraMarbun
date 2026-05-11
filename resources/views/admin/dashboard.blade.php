@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard')

@section('content')

<div class="row">

    <div class="col-lg-4 mb-4">

        <div class="dashboard-card">

            <div>

                <p class="dashboard-label">
                    Total Kamar
                </p>

                <h2>
                    {{ $totalRooms }}
                </h2>

            </div>

            <div class="dashboard-icon bg-primary">

                <i class="bi bi-house-door-fill"></i>

            </div>

        </div>

    </div>
 
    <div class="col-lg-4 mb-4">

        <div class="dashboard-card">

            <div>

                <p class="dashboard-label">
                    Kamar Tersedia
                </p>

                <h2>
                    {{ $availableRooms }}
                </h2>

            </div>

            <div class="dashboard-icon bg-success">

               <i class="bi bi-check-circle-fill"></i>

            </div>

        </div>

    </div>

    {{-- BOOKED --}}
    <div class="col-lg-4 mb-4">

        <div class="dashboard-card">

            <div>

                <p class="dashboard-label">
                    Kamar Penuh
                </p>

                <h2>
                    {{ $bookedRooms }}
                </h2>

            </div>

            <div class="dashboard-icon bg-danger">

                <i class="bi bi-x-circle-fill"></i>

            </div>

        </div>

    </div>

</div>

{{-- CHART + INFO --}}
<div class="row">

    {{-- CHART --}}
    <div class="col-lg-5 mb-4">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-4">
                    Statistik Kamar
                </h5>

                <div style="max-width: 350px; margin:auto;">

                    <canvas id="roomChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    {{-- INFO --}}
    <div class="col-lg-7 mb-4">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-4">
                    Informasi Dashboard
                </h5>

                <div class="alert alert-primary border-0">

                    Total kamar yang terdaftar saat ini
                    sebanyak

                    <strong>
                        {{ $totalRooms }}
                    </strong>

                    kamar.

                </div>

                <div class="alert alert-success border-0">

                    Kamar tersedia saat ini sebanyak

                    <strong>
                        {{ $availableRooms }}
                    </strong>

                    kamar.

                </div>

                <div class="alert alert-danger border-0">

                    Kamar yang sudah penuh sebanyak

                    <strong>
                        {{ $bookedRooms }}
                    </strong>

                    kamar.

                </div>

            </div>

        </div>

    </div>

</div>

{{-- RECENT ROOM --}}
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="fw-bold">
                Data Kamar Terbaru
            </h5>

            <a href="{{ route('rooms.index') }}"
                class="btn btn-primary">

                Kelola Kamar

            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($latestRooms as $room)

                    <tr>

                        <td>

                            @if($room->image)

                                <img src="{{ asset('storage/' . $room->image) }}"
                                    width="80"
                                    class="rounded-3">

                            @endif

                        </td>

                        <td>

                            {{ $room->name }}

                        </td>

                        <td>

                            Rp {{ number_format($room->price) }}

                        </td>

                        <td>

                            @if($room->status == 'available')

                                <span class="badge bg-success">
                                    Available
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Full
                                </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

const ctx = document.getElementById('roomChart');

new Chart(ctx, {

    type: 'doughnut',

    data: {

        labels: [
            'Available',
            'Booked'
        ],

        datasets: [{

            data: [
                {{ $availableRooms }},
                {{ $bookedRooms }}
            ],

            borderWidth: 0

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'bottom'

            }

        }

    }

});

</script>

@endsection