document.addEventListener('DOMContentLoaded', () => {

    /* ===== CARROUSEL ===== */
    const mainImage = document.querySelector('.vehicle-detail-page .car-image');
    const thumbs = document.querySelectorAll('.vehicle-detail-page .thumb');

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            thumbs.forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
            mainImage.src = thumb.src;
        });
    });

    /* ===== BOUTON RESERVATION ===== */
    const rentBtn = document.querySelector('.btn-location');

    if (rentBtn) {
        rentBtn.addEventListener('click', () => {
            window.location.href = 'index.php?page=booking';
        });
    }

});
