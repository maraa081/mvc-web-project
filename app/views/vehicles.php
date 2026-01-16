<?php
$pageCss = ['vehicles.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="container">
    <h1>Sélectionnez un groupe de véhicules</h1>

    <div class="filters-bar" style="display: flex; justify-content: space-between; margin-bottom: 20px; gap: 10px; flex-wrap: wrap;">
        <div class="filter-buttons">
            <button class="filter-btn active" onclick="filterByType('', event)">🔍 Tout voir</button>
            <button class="filter-btn" onclick="filterByType('Berline', event)">🚗 Berline</button>
            <button class="filter-btn" onclick="filterByType('SUV', event)">🚐 SUV</button>
            <button class="filter-btn" onclick="filterByType('Citadine', event)">🏙️ Citadine</button>
            <button class="filter-btn" onclick="filterByType('Électrique', event)">⚡ Électrique</button>
            
            <button class="filter-btn filter-advanced-btn" onclick="toggleFilterPanel()">
                <span>⚙️</span> Filtres avancés
            </button>
        </div>

        <div class="sort-dropdown">
            <button class="filter-btn sort-btn" onclick="toggleSortDropdown()">
                <span>⇅</span> Trier par <span class="dropdown-arrow">▼</span>
            </button>
            <div class="sort-menu" id="sortMenu">
                <button class="sort-option" onclick="applySorting('price_asc', event)">💰 Prix croissant</button>
                <button class="sort-option" onclick="applySorting('price_desc', event)">💎 Prix décroissant</button>
                <button class="sort-option" onclick="applySorting('marque_asc', event)">🔤 Marque A→Z</button>
                <button class="sort-option" onclick="applySorting('marque_desc', event)">🔤 Marque Z→A</button>
                <button class="sort-option" onclick="applySorting('recent', event)">🆕 Plus récent</button>
                <button class="sort-option" onclick="applySorting('oldest', event)">📅 Plus ancien</button>
            </div>
        </div>
    </div>

    <!-- Compteur de résultats -->
    <div id="resultCount" style="margin-bottom: 15px; color: #666; font-size: 14px;">
        <?= count($vehicles) ?> véhicule(s) disponible(s)
    </div>

    <div class="vehicle-grid" id="vehicleContainer">
        <?php foreach ($vehicles as $v): ?>
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($v['image']) ?>"
                         alt="<?= htmlspecialchars($v['marque'] . ' ' . $v['modele']) ?>">
                </div>

                <div class="vehicle-info">
                    <div class="vehicle-header">
                        <span class="vehicle-name">
                            <?= htmlspecialchars($v['marque']) ?> <?= htmlspecialchars($v['modele']) ?>
                        </span>
                        <span class="vehicle-price">
                            <?= number_format($v['prix_journalier'], 0) ?>€/j
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

<script>
    const VEHICLE_API = "<?= BASE_URL ?>/public/filter_vehicules.php";
    const VEHICLE_IMAGE_PATH = "<?= BASE_URL ?>/assets/images/vehicles/";
    const DETAIL_PAGE_URL = "<?= BASE_URL ?>/public/index.php?page=vehicle&plaque=";
</script>
<script src="<?= BASE_URL ?>/assets/js/filter.js"></script>

<?php include __DIR__ . '/includes/filter_sidebar.php'; ?>
<?php require __DIR__ . '/layout/footer.php'; ?>