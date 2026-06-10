<footer class="footer-section">

    <div class="container">

        <div class="row">

            <div class="col-lg-5">

                <h2 class="footer-brand">

                    Kost Ara Marbun

                </h2>

                <p class="footer-text">
                    Hunian putri yang nyaman, aman, dan strategis untuk mendukung aktivitas belajar pelajar SMP dan SMA. 
                </p>

            </div>

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

            <div class="col-lg-3">

                <h5 class="footer-title">

                    Kontak Kami

                </h5>

                <div class="footer-contact">

                    <div class="footer-contact-item">

                        <i class="bi bi-geo-alt-fill"></i>

                        <span>
                            Pematangsiantar, Sumatera Utara
                        </span>

                    </div>

                    <div class="footer-contact-item">

                        <i class="bi bi-whatsapp"></i>

                        <span>
                            0852-2779-4397
                        </span>

                    </div>

                    <div class="footer-contact-item">

                        <i class="bi bi-envelope-fill"></i>

                        <span>
                            kosaramarbun@gmail.com
                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="footer-bottom">

            <p>

                © {{ date('Y') }} Kost Ara Marbun.
                Seluruh hak cipta dilindungi.

            </p>

        </div>

    </div>

</footer>