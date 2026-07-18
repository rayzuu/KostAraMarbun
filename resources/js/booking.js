const roomSelect = document.getElementById("room");
const durationInput = document.getElementById("duration");

const monthlyPrice = document.getElementById("monthlyPrice");
const durationText = document.getElementById("durationText");
const totalPrice = document.getElementById("totalPrice");
const startDateInput = document.getElementById("start_date");
const endDate = document.getElementById("endDate");

function formatRupiah(number) {
    return "Rp " + Number(number).toLocaleString("id-ID");
}

function updateSummary() {

    const selected = roomSelect.options[roomSelect.selectedIndex];

    const price = Number(selected.dataset.price || 0);

    const duration = Number(durationInput.value || 1);

    monthlyPrice.textContent = formatRupiah(price);

    durationText.textContent = `${duration} Bulan`;

    totalPrice.textContent = formatRupiah(price * duration);
        if (startDateInput.value) {

        const date = new Date(startDateInput.value);

        date.setMonth(date.getMonth() + duration);

        endDate.textContent = date.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "long",
            year: "numeric",
        });

    } else {

        endDate.textContent = "-";

    }

}

roomSelect.addEventListener("change", updateSummary);
startDateInput.addEventListener("change", updateSummary);
const plusBtn = document.getElementById("plusDuration");

const minusBtn = document.getElementById("minusDuration");

plusBtn.addEventListener("click", () => {

    let duration = parseInt(durationInput.value);

    if(duration < 24){

        duration++;

        durationInput.value = duration;

        updateSummary();

    }

});

minusBtn.addEventListener("click", () => {

    let duration = parseInt(durationInput.value);

    if(duration > 1){

        duration--;

        durationInput.value = duration;

        updateSummary();

    }

});

document.addEventListener("DOMContentLoaded", updateSummary);