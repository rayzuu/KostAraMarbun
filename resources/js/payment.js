const payButton = document.getElementById('payButton');

const snapToken = payButton.dataset.token;

const bookingId = payButton.dataset.booking;

function cancelBooking(){

    fetch(`/booking/${bookingId}/cancel`, {

        method: 'DELETE',

        headers: {

            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,

            'Content-Type': 'application/json'

        }

    });

}

payButton.addEventListener('click', function(){

    snap.pay(snapToken, {

        onSuccess: function(result){

            Swal.fire({

                icon: 'success',

                title: 'Pembayaran Berhasil',

                text: 'Penyewaan kamar berhasil diproses.',

                confirmButtonColor: '#22c55e',

            }).then(() => {

                window.location.href = "/";

            });

        },

        onPending: function(result){

            Swal.fire({

                icon: 'info',

                title: 'Menunggu Pembayaran',

                text: 'Silakan selesaikan pembayaran Anda.',

                confirmButtonColor: '#22c55e',

            });

        },

        onError: function(result){

            cancelBooking();

            Swal.fire({

                icon: 'error',

                title: 'Pembayaran Gagal',

                text: 'Booking dibatalkan.',

                confirmButtonColor: '#ef4444',

            }).then(() => {

                window.location.href = "/ajukan-sewa";

            });

        },

        onClose: function(){

            cancelBooking();

            Swal.fire({

                icon: 'warning',

                title: 'Pembayaran Dibatalkan',

                text: 'Booking dibatalkan.',

                confirmButtonColor: '#f59e0b',

            }).then(() => {

                window.location.href = "/ajukan-sewa";

            });

        }

    });

});