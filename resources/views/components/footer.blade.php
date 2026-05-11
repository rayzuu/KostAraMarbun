<footer class="footer-section">

    <div class="container">

        <div class="row gy-4">

            {{-- BRAND --}}
            <div class="col-lg-4">

                <h4 class="footer-brand">
                    Kost Ara Marbun
                </h4>

                <p class="footer-text">

                    Kost nyaman, aman, dan strategis
                    dengan fasilitas lengkap untuk kebutuhan
                    tempat tinggal anda.

                </p>

            </div>

            {{-- MENU --}}
            <div class="col-lg-2">

                <h5 class="footer-title">
                    Menu
                </h5>

                <ul class="footer-links">

                    <li>
                        <a href="{{ url('/') }}">
                            Beranda
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('rooms.all') }}">
                            Kamar
                        </a>
                    </li>

                </ul>

            </div>

            {{-- KONTAK --}}
            <div class="col-lg-3">

                <h5 class="footer-title">
                    Kontak
                </h5>

                <ul class="footer-links">

                    <li>
                        WhatsApp: 0852-2779-4397
                    </li>

                    <li>
                        Email: info@kostaramarbun.com
                    </li>

                    <li>
                        Medan, Indonesia
                    </li>

                </ul>

            </div>

            {{-- SOSMED --}}
            <div class="col-lg-3">

                <h5 class="footer-title">
                    Sosial Media
                </h5>

                <div class="footer-social">

                    <a href="#">
                        Instagram
                    </a>

                    <a href="#">
                        TikTok
                    </a>

                    <a href="#">
                        Facebook
                    </a>

                </div>

            </div>

        </div>

        {{-- COPYRIGHT --}}
        <div class="footer-bottom">

            <p>

                © {{ date('Y') }} Kost Ara Marbun.
                All Rights Reserved.

            </p>

        </div>

    </div>

</footer>