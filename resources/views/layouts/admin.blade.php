<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom CSS --}}
    @vite('resources/css/admin.css')
</head>
<body>

<div class="admin-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div>

            <div class="sidebar-logo">

                <h3>KOST ARA MARBUN</h3>

                <p>Management System</p>

            </div>

            <ul class="sidebar-menu">

                <li>

                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                        <span>🏠</span>
                        Dashboard

                    </a>

                </li>

                <li>

                    <a href="{{ route('rooms.index') }}"
                        class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">

                        <span>🛏️</span>
                        Data Kamar

                    </a>

                </li>

                <li>

                    <a href="#">

                        <span>📄</span>
                        Laporan

                    </a>

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

        {{-- TOPBAR --}}
        <div class="topbar">

            <div>

                <h4>@yield('page-title')</h4>

            </div>

           <div class="d-flex align-items-center">

    {{-- BACK TO LANDING --}}
    <a href="{{ url('/') }}"
        class="btn btn-outline-primary me-2">

        ← Landing Page

    </a>

    {{-- LOGOUT --}}
    <form method="POST"
        action="{{ route('logout') }}">

        @csrf

        <button type="submit"
            class="btn btn-danger">

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