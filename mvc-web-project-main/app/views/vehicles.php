<?php
$pageCss = ['vehicles.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="container">
    <h1>Sélectionnez un groupe de véhicules</h1>

    <div class="vehicle-grid">

        <?php foreach ($vehicles as $v): ?>
            <div class="vehicle-card">

                <div class="vehicle-image">
                    <img src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($v['image']) ?>"
                         alt="<?= htmlspecialchars($v['marque'] . ' ' . $v['modele']) ?>">
                </div>

                <div class="vehicle-info">

                    <div class="vehicle-header">
                        <span class="vehicle-name">
                            <?= htmlspecialchars($v['marque']) ?>
                            <?= htmlspecialchars($v['modele']) ?>
                        </span>
                        <span class="vehicle-price">
                            <?= number_format($v['prix_journalier'], 0) ?>€
                        </span>
                    </div>

                    <div class="vehicle-features">
                        <div class="vehicle-feature">📍 <?= htmlspecialchars($v['concession']) ?></div>
                        <div class="vehicle-feature">🎨 <?= htmlspecialchars($v['couleur']) ?></div>
                        <div class="vehicle-feature">🚘 <?= htmlspecialchars($v['type']) ?></div>
                    </div>

                    <a class="vehicle-btn"
                       href="<?= BASE_URL ?>/public/index.php?page=vehicle&plaque=<?= urlencode($v['plaque']) ?>">
                        Voir les détails
                    </a>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
