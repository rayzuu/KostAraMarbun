<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-3">

    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <i class="bi bi-house-door-fill text-success"></i>
        
            <span>
                Kost Ara Marbun
            </span>
        
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarMenu">

            <i class="bi bi-list fs-3"></i>

        </button>


        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav mx-auto">
                <li class="nav-item">

                    <a href="{{ url('/') }}"
                        class="nav-link nav-custom {{ request()->is('/') ? 'active-nav' : '' }}">
                        Beranda
                    </a>
                </li>
            </ul>

            {{-- GUEST --}}
            @guest

                <div class="d-flex gap-2">

                    <a href="{{ route('login') }}" class="btn btn-outline-success px-4 rounded-3 fw-semibold">

                        Login

                    </a>

                    <a href="{{ route('register') }}" class="btn btn-success px-4 rounded-3 fw-semibold">

                        Register

                    </a>

                </div>

            @endguest

            {{-- AUTH --}}
            @auth

                <li class="nav-item dropdown list-unstyled" >

                    <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">

                        {{ Auth::user()->name }}

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4">

                        @if (Auth::user()->role == 'admin')
                            <li>

                                <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">

                                    Dashboard Admin

                                </a>

                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif

                        @auth

                            {{-- MENU KHUSUS CUSTOMER --}}
                            @if (auth()->user()->role == 'customer')
                                <li class="nav-item">

                                     <a class="dropdown-item py-2" href="{{ route('payment.history') }}">
                                            History Pembayaran
                                     </a>

                                </li>

                                <li class="nav-item">

                                     <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                            Profile
                                     </a>

                                </li>
                            @endif

                        @endauth

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        Logout
                                    </button>
                            </form>
                        </li>

                    </ul>

                </li>

            @endauth

        </div>

    </div>

</nav>