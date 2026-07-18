<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pembayaran Kost</title>

    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ICON --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- MIDTRANS --}}
    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    @vite('resources/css/payment.css')

</head>

<body>

    <div class="payment-card">

        <div class="payment-icon">

            <i class="bi bi-credit-card-fill"></i>

        </div>

        <h1 class="payment-title">

            Pembayaran Sewa

        </h1>

        <p class="payment-text">

            Selesaikan pembayaran untuk melanjutkan proses penyewaan kamar kost Anda.

        </p>

        <div class="payment-info">

            <div class="payment-info-item">

                <span>Nama Penyewa</span>

                <strong>{{ $booking->name }}</strong>

            </div>

            <div class="payment-info-item">

                <span>Kamar</span>

                <strong>{{ $room->name }}</strong>

            </div>

            <div class="payment-info-item">

                <span>Total Pembayaran</span>

                <strong>

                    Rp {{ number_format($totalPayment, 0, ',', '.') }}

                </strong>

            </div>

        </div>

        <button
            class="payment-btn"
            id="payButton"
            data-token="{{ $snapToken }}"
            data-booking="{{ $booking->id }}">
        
            Bayar Sekarang

        </button>

        <div class="secure-text">

            Pembayaran aman & terenkripsi oleh Midtrans

        </div>

    </div>

    @vite('resources/js/payment.js')

</body>

</html>