const payButton = document.getElementById("payButton");

const snapToken = payButton.dataset.token;

payButton.addEventListener("click", function () {

    snap.pay(snapToken, {

        onSuccess: function(result) {

            Swal.fire({
                icon: "success",
                title: "Pembayaran Berhasil",
                text: "Penyewaan kamar berhasil",

                confirmButtonColor: "#16a34a",
            }).then(() => {

                window.location.href = "/history-pembayaran";

            });

        },

        onPending: function(result) {

            Swal.fire({
                icon: "warning",
                title: "Pembayaran Pending",
                text: "Silakan selesaikan pembayaran",

                confirmButtonColor: "#f59e0b",
            }).then(() => {

                window.location.href = "/history-pembayaran";

            });

        },

        onError: function(result) {

            Swal.fire({
                icon: "error",
                title: "Pembayaran Gagal",
                text: "Transaksi gagal",

                confirmButtonColor: "#dc2626",
            });

        },

        onClose: function() {

            Swal.fire({
                icon: "info",
                title: "Pembayaran Belum Diselesaikan",
                text: "Data pembayaran tersimpan di history pembayaran",

                confirmButtonColor: "#2563eb",
            }).then(() => {

                window.location.href = "/history-pembayaran";

            });

        }

    });

});