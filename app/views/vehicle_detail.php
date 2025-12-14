<?php
$pageCss = ['DetailVoiture.css'];
$pageJs  = ['DetailVoiture.js'];
require __DIR__ . '/layout/header.php';
?>

<section class="main-section" id="details">

    <div class="gallery">
        <div class="image-overlay">
            <h1 class="image-car-title">BMW X5</h1>
            <div class="image-price-section">
                <span class="image-price-main">25</span>
                <span class="image-price-period">€ / jour</span>
            </div>
        </div>

        <div class="main-image">
            <img src="<?= BASE_URL ?>/assets/images/X5.png" alt="BMW X5" class="car-image">
        </div>

        <div class="carousel-thumbnails">
            <img class="thumb active" src="<?= BASE_URL ?>/assets/images/X5.png">
            <img class="thumb" src="<?= BASE_URL ?>/assets/images/X5.png">
            <img class="thumb" src="<?= BASE_URL ?>/assets/images/X5.png">
        </div>
    </div>

    <div class="details-section">
        <h3 class="section-subtitle">Caractéristiques Techniques</h3>

        <div class="specs-grid">
            <div class="spec-item"><div class="spec-icon">⚙️</div><div class="spec-label">Boîte</div><div class="spec-value">Automatique</div></div>
            <div class="spec-item"><div class="spec-icon">⛽</div><div class="spec-label">Carburant</div><div class="spec-value">Essence</div></div>
            <div class="spec-item"><div class="spec-icon">👥</div><div class="spec-label">Places</div><div class="spec-value">5</div></div>
        </div>

        <a href="<?= BASE_URL ?>/public/index.php?page=booking" class="btn-location">
            Rent a car
        </a>
    </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
