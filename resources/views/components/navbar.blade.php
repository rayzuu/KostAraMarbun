<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">

    <div class="container">

        {{-- LOGO --}}
        <a class="navbar-brand fw-bold"
            href="{{ url('/') }}">

            Kost Ara Marbun

        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMenu">

            <span class="navbar-toggler-icon"></span>

        </button>

        {{-- MENU --}}
        <div class="collapse navbar-collapse"
            id="navbarMenu">

            <ul class="navbar-nav ms-auto align-items-center">

                {{-- BERANDA --}}
                <li class="nav-item me-3">

                    <a href="{{ url('/') }}"
                        class="nav-link {{ request()->is('/') ? 'active fw-semibold text-primary' : '' }}">

                        Beranda

                    </a>

                </li>

                {{-- KAMAR --}}
                <li class="nav-item me-3">

                    <a href="{{ route('rooms.all') }}"
                        class="nav-link {{ request()->is('kamar') ? 'active fw-semibold text-primary' : '' }}">

                        Kamar

                    </a>

                </li>

                {{-- GUEST --}}
                @guest

                    <li class="nav-item me-2">

                        <a href="{{ route('login') }}"
                            class="btn btn-outline-primary">

                            Login

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="{{ route('register') }}"
                            class="btn btn-primary">

                            Register

                        </a>

                    </li>

                @endguest

                {{-- AUTH --}}
                @auth

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                        href="#"
                        data-bs-toggle="dropdown">

                        {{ Auth::user()->name }}

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">

                        {{-- ADMIN --}}
                        @if(Auth::user()->role == 'admin')

                            <li>

                                <a class="dropdown-item"
                                    href="{{ route('admin.dashboard') }}">

                                    Dashboard Admin

                                </a>

                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                        @endif

                        {{-- PROFILE --}}
                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Profil

                            </a>

                        </li>

                        {{-- LOGOUT --}}
                        <li>

                            <form method="POST"
                                action="{{ route('logout') }}">

                                @csrf

                                <button type="submit"
                                    class="dropdown-item">

                                    Logout

                                </button>

                            </form>

                        </li>

                    </ul>

                </li>

                @endauth

            </ul>

        </div>

    </div>

</nav>