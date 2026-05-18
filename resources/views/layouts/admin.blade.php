<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Custom CSS --}}
    @vite('resources/css/admin.css')
</head>

<body>

    <div class="admin-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar" id="sidebar">
            <div>

                <div class="sidebar-logo">

                    <h3>KOST ARA MARBUN</h3>

                    <p>Management System</p>

                </div>

                <ul class="sidebar-menu">

                    <li>

                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                            <i class="bi bi-grid-fill"></i>
                            Dashboard

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('rooms.index') }}"
                            class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">

                            <i class="bi bi-building"></i>
                            Data Kamar

                        </a>

                    </li>
                    <li class="sidebar-item">

                        <a href="{{ route('admin.dataBooking') }}"
                            class="{{ request()->routeIs('admin.dataBooking') ? 'active' : '' }}">

                            <i class="bi bi-person-fill"></i>
                            Data Penyewa Kost

                        </a>

                    </li>
                    <li class="nav-item">

                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#laporanMenu" role="button" aria-expanded="false">

                            <div>

                                <i class="bi bi-file-earmark-text"></i>

                                <span>
                                    Laporan
                                </span>

                            </div>

                            <i class="bi bi-chevron-down small"></i>

                        </a>

                        <div class="collapse" id="laporanMenu">

                            <ul class="btn-toggle-nav list-unstyled fw-normal small ms-4 mt-2">

                                <li class="mb-2">

                                    <a href="{{ route('report.index') }}" class="nav-link">

                                        <i class="bi bi-cash-stack"></i>

                                        Laporan Pembayaran

                                    </a>

                                </li>

                                <li>

                                    <a href="{{ route('report.tenant') }}" class="nav-link">

                                        <i class="bi bi-people-fill"></i>

                                        Laporan Penyewa

                                    </a>

                                </li>
                                <li>

                                    <a href="{{ route('report.arrears') }}" class="nav-link">

                                        <i class="bi bi-exclamation-circle"></i>

                                        Laporan Tunggakan

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </li>

                </ul>

            </div>

            {{-- USER PROFILE --}}
            <div class="sidebar-user">

                <div>

                    <h6>{{ Auth::user()->name ?? 'Admin' }}</h6>

                    <small>Administrator</small>

                </div>

            </div>

        </aside>


        {{-- MAIN --}}
        <main class="main-wrapper">

            <div class="topbar">

                <div class="d-flex align-items-center gap-3">
                    <button class="menu-toggle" id="menuToggle">

                        <i class="bi bi-list"></i>
                    </button>


                    <h4>@yield('page-title')</h4>

                </div>

                <div class="d-flex align-items-center">

                    {{-- BACK TO LANDING --}}
                    <a href="{{ url('/') }}" class="btn btn-outline-primary me-2">

                        Home

                    </a>

                    {{-- LOGOUT --}}
                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <button type="submit" class="btn btn-danger">

                            Logout

                        </button>

                    </form>

                </div>

            </div>
            {{-- CONTENT --}}
            <div class="main-content">

                @yield('content')

            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('scripts')
    @vite('resources/js/admin.js')


</body>


</html>
