<footer class="footer-section">

    <div class="container">

        <div class="row">

            <div class="col-lg-4">

                <h2 class="footer-brand">

                    Kost Ara Marbun

                </h2>

                <p class="footer-text">

                    Kost putri nyaman, aman dan strategis
                    untuk pelajar SMP & SMA.

                </p>

            </div>

            <div class="col-lg-3">

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

            <div class="col-lg-5">

                <h5 class="footer-title">

                    Kontak

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
                            kostaramarbun@gmail.com
                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="footer-bottom">

            <p>

                © {{ date('Y') }} Kost Ara Marbun.
                All rights reserved.

            </p>

        </div>

    </div>

</footer>