<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation | VTC Rentium</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/booking.css">
</head>
<body>

<nav>
    <div class="logo">
        <img src="<?= BASE_URL ?>/assets/images/LogoRentium.png" alt="Logo">
        <span>VTC Rentium</span>
    </div>
    <a href="<?= BASE_URL ?>/public/index.php?page=vehicles" class="btn-back">← Retour</a>
</nav>

<div class="reservation-container">

    <!-- STEPS -->
    <div class="steps-indicator">
        <?php
        $steps = ['Détails', 'Dates', 'Paiement', 'Confirmation'];
        foreach ($steps as $i => $label): ?>
            <div class="step <?= $i === 0 ? 'active' : '' ?>" data-step="<?= $i + 1 ?>">
                <div class="step-circle"><?= $i + 1 ?></div>
                <span><?= $label ?></span>
            </div>
            <?php if ($i < 3): ?><div class="step-line"></div><?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- SLIDER -->
    <div class="slider-wrapper">
        <div class="slider-container">

            <!-- SLIDE 1 -->
            <div class="slide active" data-slide="1">
                <div class="slide-content">

                    <div class="slide-header">
                        <h2>🚗 Détails du véhicule</h2>
                        <p>Vérifiez les informations de votre véhicule</p>
                    </div>

                    <div class="car-details-card">

                        <div class="car-image-container">
                            <img
                                src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($annonce['image']) ?>"
                                class="car-detail-image"
                                alt="Véhicule">
                        </div>

                        <div class="car-info">
                            <h3 class="car-title">
                                <?= htmlspecialchars($annonce['marque'] . ' ' . $annonce['modele']) ?>
                            </h3>

                            <span class="car-category">
                                <?= htmlspecialchars($annonce['type']) ?>
                            </span>

                            <div class="car-specs-list">
                                <div class="spec-badge">🎨 <?= htmlspecialchars($annonce['couleur']) ?></div>
                                <div class="spec-badge">📍 <?= htmlspecialchars($annonce['concession']) ?></div>
                            </div>

                            <div class="price-display">
                                <span class="price-label">Prix par jour</span>
                                <span class="price-value" id="pricePerDay">
                                    <?= number_format($annonce['prix_journalier'], 0) ?>€
                                </span>
                            </div>
                        </div>
                    </div>

                    <button class="btn-next" onclick="nextSlide()">
                        Continuer →
                    </button>
                </div>
            </div>

            <!-- SLIDE 2 -->
            <div class="slide" data-slide="2">
                <div class="slide-content">

                    <div class="slide-header">
                        <h2>📅 Sélection des dates</h2>
                    </div>

                    <div class="dates-card">
                        <div class="date-input-group">
                            <label>Date de début</label>
                            <input type="date" id="startDate" class="date-input">
                        </div>

                        <div class="date-separator">→</div>

                        <div class="date-input-group">
                            <label>Date de fin</label>
                            <input type="date" id="endDate" class="date-input">
                        </div>
                    </div>

                    <div class="calculation-card">
                        <div class="calc-row">
                            <span>Jours</span>
                            <strong id="totalDays">0</strong>
                        </div>
                        <div class="calc-divider"></div>
                        <div class="calc-row total">
                            <span>Total</span>
                            <strong id="totalPrice">0€</strong>
                        </div>
                    </div>

                    <div class="buttons-group">
                        <button class="btn-back-slide" onclick="prevSlide()">← Retour</button>
                        <button class="btn-next" onclick="nextSlide()">Continuer →</button>
                    </div>
                </div>
            </div>

            <!-- SLIDE 3 -->
            <div class="slide" data-slide="3">
                <div class="slide-content">
                    <h2>Paiement</h2>
                    <div class="buttons-group">
                        <button class="btn-back-slide" onclick="prevSlide()">← Retour</button>
                        <button class="btn-next" onclick="nextSlide()">Continuer →</button>
                    </div>
                </div>
            </div>

            <!-- SLIDE 4 -->
            <div class="slide" data-slide="4">
                <div class="slide-content">
                    <button class="btn-confirm" onclick="confirmReservation()">
                        Confirmer la réservation
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<input type="hidden" id="id_annonce" value="<?= (int)$annonce['id_annonce'] ?>">

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>/assets/js/booking.js"></script>

</body>
</html>
