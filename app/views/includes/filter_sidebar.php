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
                <div class="price-value-display">
                    <span id="priceDisplay">100€</span>
                </div>
                <input type="range" id="maxPrice" min="0" max="100" value="100" step="5">
                <div class="price-labels">
                    <span>0€</span>
                    <span>100€</span>
                </div>
            </div>
        </div>

        <hr>

        <!-- FILTRE PAR MARQUE -->
        <div class="filter-section">
            <h4>🚗 Marque</h4>
            <div class="checkbox-grid">
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="Mercedes">
                    <span class="checkbox-label">Mercedes</span>
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="BMW">
                    <span class="checkbox-label">BMW</span>
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="Audi">
                    <span class="checkbox-label">Audi</span>
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="Tesla">
                    <span class="checkbox-label">Tesla</span>
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="Toyota">
                    <span class="checkbox-label">Toyota</span>
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="Peugeot">
                    <span class="checkbox-label">Peugeot</span>
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="Renault">
                    <span class="checkbox-label">Renault</span>
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox" name="marque" value="Citroën">
                    <span class="checkbox-label">Citroën</span>
                </label>
            </div>
        </div>

        <hr>

        <!-- FILTRE PAR COULEUR -->
        <div class="filter-section">
            <h4>🎨 Couleur</h4>
            <div class="color-filters">
                <label class="color-checkbox">
                    <input type="checkbox" name="couleur" value="Noir">
                    <span class="color-box" style="background: #000;"></span>
                    <span class="color-label">Noir</span>
                </label>
                <label class="color-checkbox">
                    <input type="checkbox" name="couleur" value="Blanc">
                    <span class="color-box" style="background: #fff; border: 1px solid #ddd;"></span>
                    <span class="color-label">Blanc</span>
                </label>
                <label class="color-checkbox">
                    <input type="checkbox" name="couleur" value="Gris">
                    <span class="color-box" style="background: #888;"></span>
                    <span class="color-label">Gris</span>
                </label>
                <label class="color-checkbox">
                    <input type="checkbox" name="couleur" value="Rouge">
                    <span class="color-box" style="background: #e74c3c;"></span>
                    <span class="color-label">Rouge</span>
                </label>
                <label class="color-checkbox">
                    <input type="checkbox" name="couleur" value="Bleu">
                    <span class="color-box" style="background: #3498db;"></span>
                    <span class="color-label">Bleu</span>
                </label>
                <label class="color-checkbox">
                    <input type="checkbox" name="couleur" value="Vert">
                    <span class="color-box" style="background: #27ae60;"></span>
                    <span class="color-label">Vert</span>
                </label>
            </div>
        </div>

        <hr>

        <!-- Filtre par Concessions -->
        <div class="filter-section">
            <h3>📍 Concessions</h3>
            <div class="filter-checkboxes">
                <?php if (isset($concessions) && !empty($concessions)): ?>
                    <?php foreach ($concessions as $concession): ?>
                        <label class="filter-checkbox-label">
                            <input type="checkbox" 
                                name="concession" 
                                value="<?= htmlspecialchars($concession, ENT_QUOTES, 'UTF-8') ?>">
                            <span><?= htmlspecialchars($concession, ENT_QUOTES, 'UTF-8') ?></span>
                        </label>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #999; font-size: 0.9rem;">Aucune concession disponible</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Boutons d'action -->
    <div class="filter-panel-footer">
        <button class="btn-reset" onclick="resetFilters()">🔄 Réinitialiser</button>
        <button class="btn-apply" onclick="applyFilters(); toggleFilterPanel();">✓ Appliquer</button>
    </div>
</div>