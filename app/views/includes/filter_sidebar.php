<!-- Overlay pour fermer le panneau en cliquant à côté -->
<div class="filter-overlay" onclick="toggleFilterPanel()"></div>

<!-- Panneau latéral des filtres avancés -->
<div class="filter-panel" id="filterPanel">
    <div class="filter-panel-header">
        <h3>🔍 Filtres avancés</h3>
        <button class="close-panel" onclick="toggleFilterPanel()">✕</button>
    </div>

    <div class="filter-panel-content">
        
        <!-- FILTRE PAR PRIX -->
        <div class="filter-section">
            <h4>💰 Prix maximum</h4>
            <div class="price-filter">
                <input type="range" id="maxPrice" min="0" max="100" value="100" step="5">
                <div class="price-display">
                    <span>0€</span>
                    <span id="priceDisplay" style="font-weight: bold; color: #4CAF50;">100€</span>
                </div>
            </div>
        </div>

        <hr>

        <!-- FILTRE PAR MARQUE -->
        <div class="filter-section">
            <h4>🚗 Marque</h4>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="Mercedes">
                <span>Mercedes</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="BMW">
                <span>BMW</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="Audi">
                <span>Audi</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="Tesla">
                <span>Tesla</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="Toyota">
                <span>Toyota</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="Peugeot">
                <span>Peugeot</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="Renault">
                <span>Renault</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="marque" value="Citroën">
                <span>Citroën</span>
            </label>
        </div>

        <hr>

        <!-- FILTRE PAR COULEUR -->
        <div class="filter-section">
            <h4>🎨 Couleur</h4>
            <label class="filter-checkbox">
                <input type="checkbox" name="couleur" value="Noir">
                <span>⚫ Noir</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="couleur" value="Blanc">
                <span>⚪ Blanc</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="couleur" value="Gris">
                <span>⚫ Gris</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="couleur" value="Rouge">
                <span>🔴 Rouge</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="couleur" value="Bleu">
                <span>🔵 Bleu</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="couleur" value="Vert">
                <span>🟢 Vert</span>
            </label>
        </div>

        <hr>

        <!-- FILTRE PAR CONCESSION -->
        <div class="filter-section">
            <h4>📍 Concession</h4>
            <label class="filter-checkbox">
                <input type="checkbox" name="concession" value="Concession Rentium Paris">
                <span>Concession Rentium Paris</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" name="concession" value="Rentium Paris">
                <span>Rentium Paris</span>
            </label>
        </div>

    </div>

    <!-- Boutons d'action -->
    <div class="filter-panel-footer">
        <button class="btn-reset" onclick="resetFilters()">🔄 Réinitialiser</button>
        <button class="btn-apply" onclick="applyFilters(); toggleFilterPanel();">✓ Appliquer</button>
    </div>
</div>

<style>
/* Overlay sombre */
.filter-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 998;
    display: none;
    opacity: 0;
    transition: opacity 0.3s;
}

.filter-overlay.show {
    display: block;
    opacity: 1;
}

/* Panneau latéral */
.filter-panel {
    position: fixed;
    right: -400px;
    top: 0;
    width: 380px;
    height: 100vh;
    background: white;
    box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    z-index: 999;
    transition: right 0.3s ease;
    display: flex;
    flex-direction: column;
}

.filter-panel.open {
    right: 0;
}

/* En-tête du panneau */
.filter-panel-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.filter-panel-header h3 {
    margin: 0;
    font-size: 20px;
}

.close-panel {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: white;
    padding: 5px 10px;
    transition: transform 0.2s;
}

.close-panel:hover {
    transform: scale(1.2);
}

/* Contenu scrollable */
.filter-panel-content {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
}

/* Sections de filtres */
.filter-section {
    margin-bottom: 20px;
}

.filter-section h4 {
    margin: 0 0 15px 0;
    font-size: 16px;
    color: #333;
}

.filter-checkbox {
    display: flex;
    align-items: center;
    padding: 8px 0;
    cursor: pointer;
    user-select: none;
}

.filter-checkbox input[type="checkbox"] {
    margin-right: 10px;
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.filter-checkbox:hover {
    background: #f5f5f5;
    padding-left: 5px;
    transition: all 0.2s;
}

/* Filtre de prix */
.price-filter input[type="range"] {
    width: 100%;
    margin: 10px 0;
}

.price-display {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
}

/* Pied du panneau */
.filter-panel-footer {
    padding: 20px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    background: #f9f9f9;
}

.btn-reset, .btn-apply {
    flex: 1;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-reset {
    background: #f0f0f0;
    color: #666;
}

.btn-reset:hover {
    background: #e0e0e0;
}

.btn-apply {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-apply:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

hr {
    border: none;
    border-top: 1px solid #eee;
    margin: 20px 0;
}

/* Menu de tri */
.sort-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-top: 5px;
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s;
    z-index: 100;
}

.sort-menu.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.sort-option {
    display: block;
    width: 100%;
    padding: 12px 16px;
    border: none;
    background: none;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.sort-option:hover {
    background: #f5f5f5;
}

.sort-option.active {
    background: #e8f5e9;
    color: #4CAF50;
    font-weight: bold;
}

.sort-dropdown {
    position: relative;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-panel {
        width: 100%;
        right: -100%;
    }
}
</style>