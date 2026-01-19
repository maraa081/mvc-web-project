<?php
$pageCss = ['dashboard.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="dashboard-container">

    <aside class="dashboard-sidebar">
        <h2>Concessionnaire</h2>

        <ul>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=dashboard_concessionnaire">🏠 Tableau de bord</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=ajouter_voiture">➕ Ajouter un véhicule</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=mes_voitures">🚗 Mes véhicules</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=reservations_concessionnaire">📅 Réservations</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=settings">⚙️ Paramètres</a></li>
        </ul>
    </aside>

    <main class="dashboard-main">
        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user']['nom']) ?></h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Véhicules publiés</h3>
                <p class="stat-number"><?= $stats['nb_vehicules'] ?? 0 ?></p>
            </div>

            <div class="stat-card">
                <h3>Réservations en cours</h3>
                <p class="stat-number"><?= $stats['nb_reservations'] ?? 0 ?></p>
            </div>

            <div class="stat-card">
                <h3>Revenus estimés</h3>
                <p class="stat-number"><?= number_format($stats['revenus_estimes'] ?? 0, 2, ',', ' ') ?> €</p>
            </div>
        </div>

        <div class="dashboard-section">
            <h2>Actions rapides</h2>
            <div class="quick-actions">
                <a href="<?= BASE_URL ?>/public/index.php?page=ajouter_voiture" class="btn-primary">Ajouter un véhicule</a>
                <a href="<?= BASE_URL ?>/public/index.php?page=mes_voitures" class="btn-secondary">Gérer mes véhicules</a>
            </div>
        </div>
    </main>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
