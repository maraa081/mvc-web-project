<?php
$pageCss = ['style.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="container">
    <h1>Sélectionnez un groupe de véhicules</h1>

    <div class="filter-buttons">
        <button class="filter-btn active"><span>✓</span> Tout voir</button>
        <button class="filter-btn">🚗 Sedan</button>
        <button class="filter-btn">🚙 Cabriolet</button>
        <button class="filter-btn">🏎️ Pickup</button>
        <button class="filter-btn">🚐 SUV</button>
        <button class="filter-btn">🚌 Mobilité</button>
    </div>

    <div class="vehicle-grid">

        <div class="vehicle-card">
            <div class="vehicle-image">
                <img src="<?= BASE_URL ?>/assets/images/amg_gt.png">
            </div>
            <div class="vehicle-info">
                <div class="vehicle-header">
                    <span class="vehicle-name">Mercedes</span>
                    <span class="vehicle-price">50€</span>
                </div>
                <div class="vehicle-features">
                    <div class="feature">📍 Luxembourg</div>
                    <div class="feature">⚙️ Auto</div>
                    <div class="feature">⛽ Automatique</div>
                </div>
                <a href="<?= BASE_URL ?>/public/index.php?page=vehicle_detail" class="vehicle-btn">
                    Voir les détails
                </a>
            </div>
        </div>

        <!-- Tu peux dupliquer les cards ici sans te poser de questions -->

    </div>

    <div class="brand-logos">
        <img src="<?= BASE_URL ?>/assets/images/toyota.png">
        <img src="<?= BASE_URL ?>/assets/images/ford.png">
        <img src="<?= BASE_URL ?>/assets/images/mercedes.png">
        <img src="<?= BASE_URL ?>/assets/images/jeep.png">
        <img src="<?= BASE_URL ?>/assets/images/bmw.png">
        <img src="<?= BASE_URL ?>/assets/images/audi.png">
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
