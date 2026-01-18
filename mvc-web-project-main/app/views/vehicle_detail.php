<?php
$pageCss = ['DetailVoiture.css'];
require __DIR__ . '/layout/header.php';
?>

<section class="vehicle-detail-page">

    <section class="main-section" id="details">

        <!-- ================= GALERIE ================= -->
        <div class="gallery">

            <div class="image-overlay">
                <h1 class="image-car-title">
                    <?= htmlspecialchars($vehicle['marque']) ?>
                    <?= htmlspecialchars($vehicle['modele']) ?>
                </h1>

                <div class="image-price-section">
                    <span class="image-price-main">
                        <?= number_format($vehicle['prix_journalier'], 0) ?>
                    </span>
                    <span class="image-price-period">€ / jour</span>
                </div>
            </div>

            <div class="main-image">
                <img
                    id="carousel-main"
                    src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>"
                    alt="<?= htmlspecialchars($vehicle['marque'] . ' ' . $vehicle['modele']) ?>"
                    class="car-image"
                >
            </div>

            <div class="carousel-thumbnails">
                <img class="thumb active"
                     src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>"
                     data-full="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>"
                     alt="Vue 1">
                <img class="thumb"
                     src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>"
                     data-full="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>"
                     alt="Vue 2">
                <img class="thumb"
                     src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>"
                     data-full="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>"
                     alt="Vue 3">
            </div>

        </div>

        <!-- ================= DÉTAILS ================= -->
        <div class="details-section">

            <h3 class="section-subtitle">Caractéristiques Techniques</h3>

            <div class="specs-grid">

                <div class="spec-item">
                    <div class="spec-icon">⚙️</div>
                    <div class="spec-label">Transmission</div>
                    <div class="spec-value">Automatique</div>
                </div>

                <div class="spec-item">
                    <div class="spec-icon">⛽</div>
                    <div class="spec-label">Carburant</div>
                    <div class="spec-value">
                        <?= htmlspecialchars($vehicle['type']) ?>
                    </div>
                </div>

                <div class="spec-item">
                    <div class="spec-icon">👥</div>
                    <div class="spec-label">Places</div>
                    <div class="spec-value">5</div>
                </div>

                <div class="spec-item">
                    <div class="spec-icon">📍</div>
                    <div class="spec-label">Concession</div>
                    <div class="spec-value">
                        <?= htmlspecialchars($vehicle['concession']) ?>
                    </div>
                </div>

            </div>

            <!-- ================= BOUTON LOCATION ================= -->
            <a
                href="<?= BASE_URL ?>/public/index.php?page=booking&id_annonce=<?= $annonce['id_annonce'] ?>"
                class="btn-location"
            >
                Louer ce véhicule
            </a>

            <!-- ================= ÉQUIPEMENTS ================= -->
            <div class="equipment-section">

                <h3 class="equipment-title">Équipements du véhicule</h3>

                <div class="equipment-grid">
                    <div class="equipment-item">
                        <div class="check-icon">✓</div> ABS
                    </div>
                    <div class="equipment-item">
                        <div class="check-icon">✓</div> ESP
                    </div>
                    <div class="equipment-item">
                        <div class="check-icon">✓</div> Airbags
                    </div>
                    <div class="equipment-item">
                        <div class="check-icon">✓</div> GPS
                    </div>
                    <div class="equipment-item">
                        <div class="check-icon">✓</div> Climatisation
                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- ================= AUTRES VOITURES ================= -->
    <section class="other-cars" id="autres-vehicules">
        <div class="section-header">
            <h2 class="section-title">Autres voitures</h2>
            <a href="<?= BASE_URL ?>/public/index.php?page=vehicles" class="view-all">Voir tout →</a>
        </div>

        <div class="cars-grid">
            <?php foreach ($otherVehicles as $otherVehicle): ?>
                <div class="car-card" data-type="<?= htmlspecialchars($otherVehicle['type']) ?>">
                    <div class="car-card-image">
                        <img src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($otherVehicle['image']) ?>"
                             alt="<?= htmlspecialchars($otherVehicle['marque'] . ' ' . $otherVehicle['modele']) ?>">
                    </div>
                    <div class="car-card-content">
                        <div class="car-card-header">
                            <span class="car-name">
                                <?= htmlspecialchars($otherVehicle['marque'] . ' ' . $otherVehicle['modele']) ?>
                            </span>
                            <span class="car-price">
                                <?= number_format($otherVehicle['prix_journalier'], 0) ?>€
                            </span>
                        </div>
                        <div class="car-card-specs">
                            <span>🔵 <?= htmlspecialchars($otherVehicle['type']) ?></span>
                            <span>⚙️ Auto</span>
                            <span>📍 <?= htmlspecialchars($otherVehicle['concession']) ?></span>
                        </div>
                        <a href="<?= BASE_URL ?>/public/index.php?page=vehicle&plaque=<?= urlencode($otherVehicle['plaque']) ?>"
                           class="btn-card">
                            Voir les détails
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</section>

<?php
$pageJs = ['DetailVoiture.js'];
require __DIR__ . '/layout/footer.php';
?>
