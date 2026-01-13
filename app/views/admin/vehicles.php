<?php
$pageCss = ['CSS_rentium.css'];
$pageJs  = ['JS_rentium.js'];

ob_start();
?>

<!-- HEADER PAGE -->
<section class="page-header">
    <div class="page-title-group">
        <span class="page-title-dot"></span>
        <h1 class="page-title">Véhicules</h1>
    </div>

    <div class="right-buttons">
        <button class="btn-add">+ Ajouter un véhicule</button>
        <button class="btn-delete">🗑 Supprimer des véhicules</button>
    </div>
</section>

<!-- FILTRE PRINCIPAL -->
<section class="filter-bar">
    <button class="filter-chip" id="typeFilterToggle" type="button">
        <span class="filter-icon">⚙</span>
        <span id="typeFilterLabel">Tous les types</span>
    </button>

    <div class="filter-dropdown" id="typeFilterMenu">
        <button class="filter-option" data-filter="all">Tous les types</button>
        <button class="filter-option" data-filter="Berline">Berlines</button>
        <button class="filter-option" data-filter="SUV">SUV</button>
        <button class="filter-option" data-filter="Électrique">Électriques</button>
    </div>
</section>

<!-- FILTRES SECONDAIRES -->
<section class="filter-bar-secondary">
    <select id="concessionFilter" class="filter-select">
        <option value="all">Toutes les concessions</option>
        <option value="1">Concession 1</option>
        <option value="2">Concession 2</option>
    </select>

    <select id="statusFilter" class="filter-select">
        <option value="all">Tous les statuts</option>
        <option value="disponible">🟢 Disponibles</option>
        <option value="entretien">🟡 En entretien</option>
        <option value="indisponible">🔴 Indisponibles</option>
    </select>

    <select id="sortSelect" class="filter-select">
        <option value="none">Tri par défaut</option>
        <option value="prix-asc">Prix croissant</option>
        <option value="prix-desc">Prix décroissant</option>
        <option value="marque-az">Marque A → Z</option>
    </select>
</section>

<!-- GRILLE DES VÉHICULES -->
<section class="cards-wrapper">

    <div class="results-summary">
        <span id="resultsCount">0 véhicules trouvés</span>
        <span class="dot-separator">•</span>
        <span id="availableCount">0 disponibles</span>
    </div>

    <div id="carGrid" class="card-grid"></div>

    <div class="load-more-wrapper">
        <button id="loadMoreBtn" class="btn-load-more">
            + Afficher plus
        </button>
    </div>

</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout/admin.php';
