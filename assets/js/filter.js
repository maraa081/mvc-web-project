/**
 * filter.js - Système de filtrage des véhicules
 */

let currentType = '';
let currentSort = 'price_asc';

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    console.log("✅ Système de filtre initialisé");
    
    // Liaison des événements sur les checkboxes si elles existent
    const checkboxes = document.querySelectorAll('input[name="marque"], input[name="couleur"]');
    checkboxes.forEach(box => {
        box.addEventListener('change', () => applyFilters());
    });
    
    // Liaison de l'événement sur le curseur de prix si il existe
    const priceSlider = document.getElementById('maxPrice');
    if (priceSlider) {
        priceSlider.addEventListener('input', (e) => {
            const priceDisplay = document.getElementById('priceDisplay');
            if (priceDisplay) {
                priceDisplay.textContent = e.target.value + '€';
            }
        });
        
        priceSlider.addEventListener('change', () => applyFilters());
    }
});

/**
 * Filtre par type de véhicule (Berline, SUV, Citadine...)
 */
async function filterByType(type, event) {
    if (event) event.preventDefault();
    
    currentType = type;
    console.log("🔍 Filtrage par type :", type || "Tous");

    // Mise à jour visuelle des boutons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    } else {
        // Si pas d'événement (= "Tout voir"), on active le premier bouton
        const firstBtn = document.querySelector('.filter-btn');
        if (firstBtn) firstBtn.classList.add('active');
    }

    await applyFilters();
}

/**
 * Applique un tri
 */
function applySorting(sortValue, event) {
    if (event) event.preventDefault();
    
    currentSort = sortValue;
    console.log("📊 Tri appliqué :", sortValue);
    
    // Fermeture du menu déroulant
    const menu = document.getElementById('sortMenu');
    if (menu) menu.classList.remove('active');
    
    // Mise à jour visuelle du bouton actif
    document.querySelectorAll('.sort-option').forEach(opt => {
        opt.classList.remove('active');
    });
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
    
    applyFilters();
}

/**
 * FONCTION PRINCIPALE : Applique tous les filtres et envoie la requête
 */
async function applyFilters() {
    const grid = document.querySelector('.vehicle-grid');
    if (!grid) {
        console.error("❌ Erreur : .vehicle-grid introuvable dans le DOM");
        return;
    }
    
    // Animation de chargement
    grid.style.opacity = '0.5';

    // Récupération de tous les filtres actifs
    const filters = {
        type: currentType,
        sortBy: currentSort,
        maxPrice: document.getElementById('maxPrice')?.value || '',
        marques: [],
        couleurs: [],
        concessions: []
    };

    // Marques cochées
    document.querySelectorAll('input[name="marque"]:checked').forEach(cb => {
        filters.marques.push(cb.value);
    });
    
    // Couleurs cochées
    document.querySelectorAll('input[name="couleur"]:checked').forEach(cb => {
        filters.couleurs.push(cb.value);
    });
    
    // Concessions cochées
    document.querySelectorAll('input[name="concession"]:checked').forEach(cb => {
        filters.concessions.push(cb.value);
    });

    console.log("📤 Envoi des filtres :", filters);

    try {
        // ✅ CORRECTION : On utilise VEHICLE_API défini dans vehicles.php
        const apiUrl = (typeof VEHICLE_API !== 'undefined') 
            ? VEHICLE_API 
            : 'filter_vehicules.php';
            
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify(filters)
        });

        if (!response.ok) {
            throw new Error(`Erreur HTTP : ${response.status}`);
        }

        const data = await response.json();
        console.log("📥 Réponse reçue :", data);

        // ✅ CORRECTION: Vérifier le format de la réponse
        if (data.success && data.vehicles) {
            renderVehicles(data.vehicles);
        } else if (data.success === false) {
            console.error("❌ Erreur serveur :", data.error);
            grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:50px; color:red;">Erreur lors du chargement des véhicules</div>';
        } else if (Array.isArray(data)) {
            // Si la réponse est directement un tableau (ancien format)
            console.log("⚠️ Format de réponse ancien détecté, utilisation directe du tableau");
            renderVehicles(data);
        } else {
            console.error("❌ Format de réponse inattendu :", data);
            grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:50px; color:red;">Format de réponse invalide</div>';
        }
        
    } catch (error) {
        console.error("❌ ERREUR CRITIQUE :", error);
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:50px; color:red;">Impossible de charger les véhicules</div>';
    } finally {
        grid.style.opacity = '1';
    }
}

/**
 * ✅ CORRECTION: Affiche les véhicules avec image_url
 */
function renderVehicles(vehicles) {
    const grid = document.querySelector('.vehicle-grid');
    if (!grid) {
        console.error("❌ .vehicle-grid introuvable");
        return;
    }

    grid.innerHTML = '';

    if (!vehicles || vehicles.length === 0) {
        grid.innerHTML = `
            <div style="grid-column:1/-1; text-align:center; padding:50px;">
                <h3>😕 Aucun véhicule trouvé</h3>
                <p>Essayez de modifier vos critères de recherche</p>
            </div>`;
        return;
    }

    // ✅ URL de base pour l'image par défaut
    const defaultImage = (typeof BASE_URL !== 'undefined') 
        ? BASE_URL + '/assets/images/vehicles/default.jpg'
        : '/assets/images/vehicles/default.jpg';
        
    const detailUrl = (typeof DETAIL_PAGE_URL !== 'undefined')
        ? DETAIL_PAGE_URL
        : 'index.php?page=vehicle&plaque=';

    vehicles.forEach(v => {
        // ✅ CORRECTION: Utiliser v.image_url au lieu de construire le chemin
        const imageUrl = v.image_url || defaultImage;
        
        const card = `
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="${escapeHtml(imageUrl)}" 
                         alt="${escapeHtml(v.marque)} ${escapeHtml(v.modele)}"
                         onerror="this.src='${defaultImage}'">
                </div>
                <div class="vehicle-info">
                    <div class="vehicle-header">
                        <span class="vehicle-name">${escapeHtml(v.marque)} ${escapeHtml(v.modele)}</span>
                        <span class="vehicle-price">${Math.round(v.prix_journalier)}€/j</span>
                    </div>
                    <div class="vehicle-features">
                        <div class="vehicle-feature">📍 ${escapeHtml(v.concession || 'Standard')}</div>
                        <div class="vehicle-feature">🎨 ${escapeHtml(v.couleur)}</div>
                        <div class="vehicle-feature">🚘 ${escapeHtml(v.type)}</div>
                    </div>
                    <a class="vehicle-btn" href="${detailUrl}${encodeURIComponent(v.plaque)}">
                        Voir les détails
                    </a>
                </div>
            </div>`;
        grid.insertAdjacentHTML('beforeend', card);
    });
    
    // Mise à jour du compteur de résultats
    const resultCount = document.getElementById('resultCount');
    if (resultCount) {
        resultCount.textContent = `${vehicles.length} véhicule(s) disponible(s)`;
    }
    
    console.log(`✅ ${vehicles.length} véhicule(s) affiché(s)`);
}

/**
 * ✅ Fonction pour échapper le HTML (sécurité XSS)
 */
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Ouvre/ferme le panneau de filtres avancés
 */
function toggleFilterPanel() {
    const panel = document.getElementById('filterPanel');
    const overlay = document.querySelector('.filter-overlay');
    
    if (panel) panel.classList.toggle('open');
    if (overlay) overlay.classList.toggle('show');
}

/**
 * Ouvre/ferme le menu de tri
 */
function toggleSortDropdown() {
    const menu = document.getElementById('sortMenu');
    if (menu) menu.classList.toggle('active');
}

/**
 * Réinitialise tous les filtres
 */
function resetFilters() {
    // Réinitialisation des variables
    currentType = '';
    currentSort = 'price_asc';
    
    // Décochage des checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
    });
    
    // Réinitialisation du prix
    const priceSlider = document.getElementById('maxPrice');
    if (priceSlider) {
        priceSlider.value = priceSlider.max;
        const priceDisplay = document.getElementById('priceDisplay');
        if (priceDisplay) {
            priceDisplay.textContent = priceSlider.max + '€';
        }
    }
    
    // Réactivation du bouton "Tout voir"
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    const firstBtn = document.querySelector('.filter-btn');
    if (firstBtn) firstBtn.classList.add('active');
    
    // Application des filtres vides
    applyFilters();
}

/**
 * Appliquer les filtres avancés depuis le panneau
 */
function applyAdvancedFilters() {
    // Récupérer tous les filtres
    const marques = Array.from(document.querySelectorAll('input[name="marque"]:checked'))
        .map(cb => cb.value);
    
    const couleurs = Array.from(document.querySelectorAll('input[name="couleur"]:checked'))
        .map(cb => cb.value);
    
    const concessions = Array.from(document.querySelectorAll('input[name="concession"]:checked'))
        .map(cb => cb.value);
    
    const maxPrice = document.getElementById('maxPrice')?.value || '';

    // Mettre à jour les filtres
    currentFilters = {
        type: currentType,
        sortBy: currentSort,
        maxPrice: maxPrice,
        marques: marques,
        couleurs: couleurs,
        concessions: concessions
    };

    console.log("🔧 Filtres avancés appliqués:", currentFilters);

    // Appliquer
    applyFilters();
    
    // Fermer le panneau
    toggleFilterPanel();
}           