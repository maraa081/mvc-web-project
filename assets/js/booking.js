document.addEventListener('DOMContentLoaded', () => {

    let currentSlide = 1;
    const slides = document.querySelectorAll('.booking-page .slide');
    const slider = document.querySelector('.booking-page .slider-container');

    window.nextSlide = () => {
        if (currentSlide < slides.length) {
            currentSlide++;
            updateSlider();
        }
    };

    window.prevSlide = () => {
        if (currentSlide > 1) {
            currentSlide--;
            updateSlider();
        }
    };

    function updateSlider() {
        slides.forEach(slide => slide.classList.remove('active'));
        slides[currentSlide - 1].classList.add('active');
        slider.style.transform = `translateX(-${(currentSlide - 1) * 100}%)`;
    }

    /* ===== DATES & CALCUL ===== */
    const start = document.getElementById('startDate');
    const end = document.getElementById('endDate');

    const totalDays = document.getElementById('totalDays');
    const totalPrice = document.getElementById('totalPrice');
    const pricePerDay = 25;

    function updatePrice() {
        if (start.value && end.value) {
            const d1 = new Date(start.value);
            const d2 = new Date(end.value);
            const days = Math.max(0, (d2 - d1) / (1000 * 60 * 60 * 24));
            totalDays.textContent = days;
            totalPrice.textContent = (days * pricePerDay) + '€';
        }
    }

    start?.addEventListener('change', updatePrice);
    end?.addEventListener('change', updatePrice);

    /* ===== CONFIRMATION ===== */
    window.confirmReservation = () => {
        document.getElementById('successModal').classList.add('show');
    };

    window.closeModal = () => {
        window.location.href = 'index.php?page=home';
    };

});
