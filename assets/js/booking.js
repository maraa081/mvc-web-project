/* ===================== SLIDER ===================== */

let currentSlide = 1;
const totalSlides = 4;

function updateSlider() {
    document.querySelectorAll('.slide').forEach(slide => {
        slide.classList.remove('active');
    });

    const activeSlide = document.querySelector(`.slide[data-slide="${currentSlide}"]`);
    if (activeSlide) activeSlide.classList.add('active');

    document.querySelectorAll('.step').forEach(step => {
        step.classList.remove('active');
    });

    const activeStep = document.querySelector(`.step[data-step="${currentSlide}"]`);
    if (activeStep) activeStep.classList.add('active');
}

function nextSlide() {
    if (currentSlide < totalSlides) {
        currentSlide++;
        updateSlider();
    }
}

function prevSlide() {
    if (currentSlide > 1) {
        currentSlide--;
        updateSlider();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    currentSlide = 1;
    updateSlider();
});

/* ===================== CALCUL PRIX ===================== */

const startDateInput = document.getElementById('startDate');
const endDateInput   = document.getElementById('endDate');

if (startDateInput && endDateInput) {
    startDateInput.addEventListener('change', calculatePrice);
    endDateInput.addEventListener('change', calculatePrice);
}

function calculatePrice() {
    if (!startDateInput.value || !endDateInput.value) return;

    const startDate = new Date(startDateInput.value);
    const endDate   = new Date(endDateInput.value);

    const diffTime = endDate - startDate;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays <= 0) return;

    document.getElementById('totalDays').innerText = diffDays;

    const priceText = document.getElementById('pricePerDay').innerText;
    const price     = parseInt(priceText.replace('€', ''));

    document.getElementById('totalPrice').innerText = (price * diffDays) + '€';
}

/* ===================== CONFIRMATION ===================== */

function confirmReservation() {
    const id_annonce = document.getElementById('id_annonce').value;
    const date_debut = document.getElementById('startDate').value;
    const date_fin   = document.getElementById('endDate').value;

    if (!date_debut || !date_fin) {
        alert("Veuillez sélectionner des dates");
        return;
    }

    fetch(`${BASE_URL}/public/index.php?page=booking_store`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            id_annonce: id_annonce,
            date_debut: date_debut,
            date_fin: date_fin
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Réponse serveur :", data);

        if (data.success) {
            // ✅ réservation réellement enregistrée en BDD
            document.getElementById('successModal').classList.add('show');
        } else {
            alert(data.error || "Erreur lors de la réservation");
        }
    })
    .catch(error => {
        console.error("Erreur AJAX :", error);
        alert("Erreur réseau");
    });
}

function closeModal() {
    document.getElementById('successModal').classList.remove('show');
    window.location.href = `${BASE_URL}/public/index.php?page=home`;
}
