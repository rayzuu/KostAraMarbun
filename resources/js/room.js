document.querySelectorAll(".room-full-btn").forEach((btn) => {

    btn.addEventListener("click", function () {

        Swal.fire({
            icon: "warning",
            title: "Kamar Penuh",
            text: "Kamar ini sudah tidak tersedia untuk disewa",
            confirmButtonColor: "#f59e0b",
        });

    });

});