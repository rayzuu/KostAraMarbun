const payButton = document.getElementById("payButton");

const snapToken = payButton.dataset.token;

const bookingId = payButton.dataset.booking;

function cancelBooking() {
    fetch(`/booking/${bookingId}/cancel`, {
        method: "DELETE",

        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,

            "Content-Type": "application/json",
        },
    });
}

payButton.addEventListener("click", function () {
    snap.pay(snapToken, {
        onSuccess: function (result) {
            Swal.fire({
                icon: "success",
                title: "Pembayaran Berhasil",
                text: "Penyewaan Kamar Berhasil",

                confirmButtonColor: "#16a34a",
            }).then(() => {
                window.location.href = "/";
            });
        },

        onPending: function (result) {
            Swal.fire({
                icon: "warning",
                title: "Pembayaran Belum Selesai",
                text: "Silakan selesaikan pembayaran",

                confirmButtonColor: "#f59e0b",
            });
        },

        onError: function (result) {
            Swal.fire({
                icon: "error",
                title: "Pembayaran Gagal",
                text: "Transaksi gagal",

                confirmButtonColor: "#dc2626",
            }).then(() => {
                window.location.href = '{{ route("booking.create") }}';
            });
        },

        onClose: function () {
            fetch("/cancel-booking/{{ $booking->id }}", {
                method: "POST",

                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",

                    Accept: "application/json",
                },
            }).then(() => {
                Swal.fire({
                    icon: "error",
                    title: "Pembayaran Dibatalkan",


                    confirmButtonColor: "#dc2626",
                }).then(() => {
                    window.location.href = '{{ route("booking.create") }}';
                });
            });
        },
    });
});
