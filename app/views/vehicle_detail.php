
<div class="vehicle-detail-page">
    <?php
$pageCss = ['DetailVoiture.css'];
$pageJs  = ['DetailVoiture.js'];
require __DIR__ . '/layout/header.php';
?>

<section class="main-section" id="details">

    <!-- Galerie -->
    <div class="gallery">
        <div class="image-overlay">
            <h1 class="image-car-title">BMW X5</h1>
            <div class="image-price-section">
                <span class="image-price-main">25</span>
                <span class="image-price-period">€ / jour</span>
            </div>
        </div>

        <div class="main-image">
            <img src="<?= BASE_URL ?>/assets/images/X5.png" class="car-image" alt="BMW X5">
        </div>

        <div class="carousel-thumbnails">
            <img class="thumb active" src="<?= BASE_URL ?>/assets/images/X5.png">
            <img class="thumb" src="<?= BASE_URL ?>/assets/images/X5.png">
            <img class="thumb" src="<?= BASE_URL ?>/assets/images/X5.png">
        </div>
    </div>

    <!-- Détails -->
    <div class="details-section">
        <h3 class="section-subtitle">Caractéristiques Techniques</h3>

        <div class="specs-grid">
            <div class="spec-item"><div class="spec-icon">⚙️</div><div class="spec-label">Boîte</div><div class="spec-value">Automatique</div></div>
            <div class="spec-item"><div class="spec-icon">⛽</div><div class="spec-label">Carburant</div><div class="spec-value">Essence</div></div>
            <div class="spec-item"><div class="spec-icon">🚪</div><div class="spec-label">Portes</div><div class="spec-value">5</div></div>
            <div class="spec-item"><div class="spec-icon">❄️</div><div class="spec-label">Clim</div><div class="spec-value">Oui</div></div>
            <div class="spec-item"><div class="spec-icon">👥</div><div class="spec-label">Places</div><div class="spec-value">5</div></div>
            <div class="spec-item"><div class="spec-icon">📍</div><div class="spec-label">Distance</div><div class="spec-value">60 km</div></div>
        </div>

        <button class="btn-location">Rent a car</button>

        <div class="equipment-section">
            <h3 class="equipment-title">Équipements</h3>
            <div class="equipment-grid">
                <div class="equipment-item"><span class="check-icon">✓</span> ABS</div>
                <div class="equipment-item"><span class="check-icon">✓</span> ESP</div>
                <div class="equipment-item"><span class="check-icon">✓</span> GPS</div>
                <div class="equipment-item"><span class="check-icon">✓</span> Climatisation</div>
            </div>
        </div>
    </div>
</section>

<section class="other-cars">
    <div class="section-header">
        <h2 class="section-title">Autres voitures</h2>
        <a href="<?= BASE_URL ?>/public/index.php?page=vehicles" class="view-all">Voir tout →</a>
    </div>

    <div class="cars-grid">
        <?php for ($i = 0; $i < 3; $i++): ?>
            <div class="car-card">
                <div class="car-card-image">
                    <img src="<?= BASE_URL ?>/assets/images/mercedes1.png">
                </div>
                <div class="car-card-content">
                    <div class="car-card-header">
                        <span class="car-name">Mercedes</span>
                        <span class="car-price">30€</span>
                    </div>
                    <button class="btn-card">Voir les détails</button>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
</div>
