// filter.js - VERSION CORRIGÉE AVEC CHEMINS D'IMAGES

// Variables globales
let userLatitude = null;
let userLongitude = null;
let currentSort = 'price_asc';



// ========================================
// FONCTIONS TYPE
// ========================================

// Variable globale pour le type sélectionné
let currentType = '';

// Filtrer par type de véhicule
async function filterByType(type) {
    currentType = type;
    
    // Mettre à jour les boutons actifs
    document.querySelectorAll('.filter-buttons .filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.filter-btn').classList.add('active');
    
    // Récupérer les filtres actuels et ajouter le type
    const filters = {
        minPrice: document.getElementById('minPrice')?.value || '',
        maxPrice: document.getElementById('maxPrice')?.value || '',
        marques: Array.from(document.querySelectorAll('input[name="marque"]:checked')).map(cb => cb.value),
        couleurs: Array.from(document.querySelectorAll('input[name="couleur"]:checked')).map(cb => cb.value),
        distance: document.getElementById('distanceRange')?.value || '',
        concession: document.getElementById('concessionSelect')?.value || '',
        userLat: userLatitude,
        userLon: userLongitude,
        sortBy: currentSort || 'price_asc',
        type: type  // Ajouter le type ici
    };
    
    showLoader();
    
    try {
        const response = await fetch('filter_vehicules.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(filters)
        });
        
        const data = await response.json();
        hideLoader();
        
        if (data.success) {
            displayVehicles(data.vehicles);
            const typeLabel = type ? `Type: ${type}` : 'Tous les types';
            showFilterMessage(`${data.count} véhicule(s) trouvé(s) - ${typeLabel}`, 'success');
        } else {
            showFilterMessage(data.message || 'Erreur lors du chargement', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        hideLoader();
        showFilterMessage('Erreur de connexion au serveur', 'error');
    }
}

// Modifier la fonction applyFilters pour inclure le type
async function applyFilters() {
    const filters = {
        minPrice: document.getElementById('minPrice')?.value || '',
        maxPrice: document.getElementById('maxPrice')?.value || '',
        marques: Array.from(document.querySelectorAll('input[name="marque"]:checked')).map(cb => cb.value),
        couleurs: Array.from(document.querySelectorAll('input[name="couleur"]:checked')).map(cb => cb.value),
        distance: document.getElementById('distanceRange')?.value || '',
        concession: document.getElementById('concessionSelect')?.value || '',
        userLat: userLatitude,
        userLon: userLongitude,
        sortBy: currentSort || 'price_asc',
        type: currentType  // Conserver le type sélectionné
    };
    
    console.log('Filtres appliqués:', filters);
    
    showLoader();
    
    try {
        const response = await fetch('filter_vehicules.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(filters)
        });
        
        const data = await response.json();
        
        hideLoader();
        
        if (data.success) {
            displayVehicles(data.vehicles);
            showFilterMessage(`${data.count} véhicule(s) trouvé(s)`, 'success');
            toggleFilterPanel();
        } else {
            showFilterMessage(data.message || 'Erreur lors du chargement', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        hideLoader();
        showFilterMessage('Erreur lors du chargement des véhicules', 'error');
    }
}

// Modifier applyFiltersWithSort pour inclure le type
async function applyFiltersWithSort(sortBy) {
    const filters = {
        minPrice: document.getElementById('minPrice')?.value || '',
        maxPrice: document.getElementById('maxPrice')?.value || '',
        marques: Array.from(document.querySelectorAll('input[name="marque"]:checked')).map(cb => cb.value),
        couleurs: Array.from(document.querySelectorAll('input[name="couleur"]:checked')).map(cb => cb.value),
        distance: document.getElementById('distanceRange')?.value || '',
        concession: document.getElementById('concessionSelect')?.value || '',
        userLat: userLatitude,
        userLon: userLongitude,
        sortBy: sortBy || currentSort,
        type: currentType  // Conserver le type sélectionné
    };

    showLoader();

    try {
        const response = await fetch('filter_vehicules.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(filters)
        });

        const data = await response.json();
        hideLoader();

        if (data.success) {
            displayVehicles(data.vehicles);
            showFilterMessage(`${data.count} véhicule(s) trouvé(s)`, 'success');
        } else {
            showFilterMessage(data.message || 'Erreur', 'error');
        }
    } catch (err) {
        console.error(err);
        hideLoader();
        showFilterMessage('Erreur de connexion', 'error');
    }
}


// ========================================
// FONCTIONS PANNEAU DE FILTRES
// ========================================

function toggleFilterPanel() {
    const panel = document.getElementById('filterPanel');
    const overlay = document.querySelector('.filter-overlay');
    
    if (!panel) {
        console.error('Panneau de filtres introuvable');
        return;
    }
    
    // Si pas d'overlay, le créer
    if (!overlay) {
        const newOverlay = document.createElement('div');
        newOverlay.className = 'filter-overlay';
        newOverlay.onclick = toggleFilterPanel;
        document.body.appendChild(newOverlay);
    }
    
    const filterOverlay = document.querySelector('.filter-overlay');
    const isOpen = panel.classList.toggle('open');
    
    if (filterOverlay) {
        filterOverlay.classList.toggle('show', isOpen);
    }
    
    document.body.style.overflow = isOpen ? 'hidden' : '';
}


document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        // Retirer la classe active des autres boutons
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const selectedType = this.getAttribute('data-type');

        const filters = {
            minPrice: document.getElementById('minPrice')?.value || '',
            maxPrice: document.getElementById('maxPrice')?.value || '',
            marques: Array.from(document.querySelectorAll('input[name="marque"]:checked')).map(cb => cb.value),
            couleurs: Array.from(document.querySelectorAll('input[name="couleur"]:checked')).map(cb => cb.value),
            distance: document.getElementById('distanceRange')?.value || '',
            concession: document.getElementById('concessionSelect')?.value || '',
            userLat: userLatitude,
            userLon: userLongitude,
            sortBy: currentSort,
            type: selectedType // 👈 ajout du type
        };

        showLoader();

        try {
            const response = await fetch('filter_vehicules.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(filters)
            });

            const data = await response.json();
            hideLoader();

            if (data.success) {
                displayVehicles(data.vehicles);
                showFilterMessage(`${data.count} véhicule(s) trouvé(s)`, 'success');
            } else {
                showFilterMessage(data.message || 'Erreur', 'error');
            }
        } catch (err) {
            console.error('Erreur:', err);
            hideLoader();
            showFilterMessage('Erreur de connexion', 'error');
        }
    });
});


// ========================================
// FONCTIONS TRI
// ========================================

function toggleSortDropdown(event) {
    if (event) {
        event.stopPropagation();
    }
    
    const menu = document.getElementById('sortMenu');
    const overlay = document.getElementById('sortOverlay');
    const btn = document.querySelector('.sort-btn');
    
    if (menu && overlay && btn) {
        const isActive = menu.classList.contains('active');
        
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
        btn.classList.toggle('active');
    }
}

async function applySorting(sortType) {
    currentSort = sortType;
    
    const sortLabels = {
        'price_asc': '💰 Prix ↑',
        'price_desc': '💎 Prix ↓',
        'recent': '🆕 Récent',
        'oldest': '📅 Ancien',
        'brand_asc': '🔤 A-Z',
        'brand_desc': '🔡 Z-A'
    };
    
    const sortBtn = document.querySelector('.sort-btn');
    if (sortBtn) {
        sortBtn.innerHTML = `<span>⇅</span> ${sortLabels[sortType]} <span class="dropdown-arrow">▼</span>`;
    }
    
    document.querySelectorAll('.sort-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    const clickedOption = document.querySelector(`[data-sort="${sortType}"]`);
    if (clickedOption) {
        clickedOption.classList.add('selected');
    }
    
    toggleSortDropdown();
    await applyFiltersWithSort(currentSort);
}

// ========================================
// FONCTIONS FILTRES
// ========================================

async function applyFilters() {
    await applyFiltersWithSort(currentSort);
    toggleFilterPanel();
}

async function applyFiltersWithSort(sortBy) {
    const filters = {
        minPrice: document.getElementById('minPrice')?.value || '',
        maxPrice: document.getElementById('maxPrice')?.value || '',
        marques: Array.from(document.querySelectorAll('input[name="marque"]:checked')).map(cb => cb.value),
        couleurs: Array.from(document.querySelectorAll('input[name="couleur"]:checked')).map(cb => cb.value),
        distance: document.getElementById('distanceRange')?.value || '',
        concession: document.getElementById('concessionSelect')?.value || '',
        userLat: userLatitude,
        userLon: userLongitude,
        sortBy: sortBy || currentSort
    };

    console.log('Filtres appliqués:', filters);
    showLoader();

    try {
        const response = await fetch('filter_vehicules.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(filters)
        });

        const data = await response.json();
        console.log('Réponse serveur:', data);
        
        hideLoader();

        if (data.success) {
            displayVehicles(data.vehicles);
            showFilterMessage(`${data.count} véhicule(s) trouvé(s)`, 'success');
        } else {
            showFilterMessage(data.message || 'Erreur', 'error');
        }
    } catch (err) {
        console.error('Erreur:', err);
        hideLoader();
        showFilterMessage('Erreur de connexion', 'error');
    }
}

// ========================================
// AFFICHAGE DES VÉHICULES
// ========================================

function getImagePath(vehicle) {

    const modelClean = vehicle.modele.replace(/ /g, '_');
    const base = `images/${vehicle.plaque}_${modelClean}`;
    const formats = ['png','jpg','jpeg','webp'];

    // Retourne la première image existante via un HEAD request
    for (const ext of formats) {
        const url = `${base}.${ext}`;
        const xhr = new XMLHttpRequest();
        xhr.open('HEAD', url, false);

        try {
            xhr.send();
            if (xhr.status === 200) {
                return url; // ✔ bon format trouvé
            }
        } catch(e) {}
    }

    return `/rentium/images/${vehicle.plaque}_${modelClean}.png`;
}


function displayVehicles(vehicles) {
    const grid = document.querySelector('.vehicle-grid');
    if (!grid) {
        console.error('Grille de véhicules introuvable');
        return;
    }

    if (!vehicles || vehicles.length === 0) {
        grid.innerHTML = `
            <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                <div style="font-size: 48px; margin-bottom: 20px;">🚗</div>
                <h3 style="font-size: 24px; color: #1a1a1a; margin-bottom: 10px;">Aucun véhicule trouvé</h3>
                <p style="color: #666;">Essayez de modifier vos critères de recherche</p>
                <button onclick="resetFilters()" style="margin-top: 20px; padding: 12px 30px; background-color: #149D42; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Réinitialiser les filtres
                </button>
            </div>
        `;
        return;
    }

    // Générer le HTML pour chaque véhicule
    grid.innerHTML = vehicles.map(vehicle => {
        const imagePath = getImagePath(vehicle);
        console.log("Image générée :", imagePath);

        return `
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="${imagePath}" 
                         alt="${vehicle.marque} ${vehicle.modele}"
                         onerror="this.onerror=null; this.src='images/default_car.png';"
                         style="width: 100%; height: 100%; object-fit: cover;">
                    ${vehicle.distance_km ? `
                        <div style="position: absolute; bottom: 10px; right: 10px; background-color: #149D42; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                            ${vehicle.distance_km} km
                        </div>` : ''}
                </div>
                <div class="vehicle-info">
                    <div class="vehicle-header">
                        <span class="vehicle-name">${vehicle.marque} ${vehicle.modele}</span>
                        <span class="vehicle-price">${vehicle.prix_journalier}€/jour</span>
                    </div>
                    <div class="vehicle-features">
                        <div class="feature">🚗 Type : ${vehicle.type}</div>
                        <div class="feature">🎨 Couleur : ${vehicle.couleur}</div>
                        ${vehicle.concession_nom ? 
                            `<div class="feature">📍 ${vehicle.concession_nom}</div>` : 
                            `<div class="feature">📍 Concession : ${vehicle.id_concess}</div>`
                        }
                    </div>
                    ${vehicle.distance_km ? 
                        `<div style="color: #149D42; font-weight: 600; margin-top: 10px; font-size: 13px;">
                            📍 À ${vehicle.distance_km} km de vous
                        </div>` : ''
                    }
                    <button class="vehicle-btn" onclick="viewDetails('${vehicle.plaque}')">Voir les détails</button>
                </div>
            </div>
        `;
    }).join('');
}

// ========================================
// UTILITAIRES
// ========================================

function showLoader() {
    const grid = document.querySelector('.vehicle-grid');
    if (grid) {
        grid.innerHTML = `
            <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                <div class="loader"></div>
                <p style="color: #666; margin-top: 20px;">Recherche en cours...</p>
            </div>
        `;
    }
}

function hideLoader() {
    // Le loader sera remplacé par les résultats
}

function showFilterMessage(message, type) {
    const existingMessage = document.querySelector('.filter-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `filter-message ${type}`;
    messageDiv.style.cssText = `
        padding: 12px 16px;
        border-radius: 8px;
        margin: 20px 0;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        animation: slideDown 0.3s ease;
    `;
    
    if (type === 'success') {
        messageDiv.style.backgroundColor = '#d4edda';
        messageDiv.style.color = '#155724';
        messageDiv.style.border = '1px solid #c3e6cb';
    } else {
        messageDiv.style.backgroundColor = '#f8d7da';
        messageDiv.style.color = '#721c24';
        messageDiv.style.border = '1px solid #f5c6cb';
    }
    
    messageDiv.textContent = message;
    
    const container = document.querySelector('.container');
    const filterButtons = container?.querySelector('.filter-buttons');
    if (filterButtons && filterButtons.parentNode) {
        filterButtons.parentNode.insertBefore(messageDiv, filterButtons.nextSibling);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
}

function getUserLocation() {
    if (navigator.geolocation) {
        const btn = document.querySelector('.btn-locate');
        if (!btn) return;
        
        btn.textContent = '⏳ Localisation...';
        btn.disabled = true;
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                userLatitude = position.coords.latitude;
                userLongitude = position.coords.longitude;
                
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLatitude}&lon=${userLongitude}`)
                    .then(response => response.json())
                    .then(data => {
                        const address = data.address?.city || data.address?.town || data.address?.village || data.display_name;
                        const locationInput = document.getElementById('userLocation');
                        if (locationInput) {
                            locationInput.value = address;
                        }
                        btn.textContent = '✓ Localisé';
                        btn.style.backgroundColor = '#149D42';
                        
                        setTimeout(() => {
                            btn.textContent = '📍 Me localiser';
                            btn.style.backgroundColor = '';
                            btn.disabled = false;
                        }, 2000);
                    })
                    .catch(error => {
                        console.error('Erreur de géocodage:', error);
                        const locationInput = document.getElementById('userLocation');
                        if (locationInput) {
                            locationInput.value = `Lat: ${userLatitude.toFixed(4)}, Lon: ${userLongitude.toFixed(4)}`;
                        }
                        btn.textContent = '📍 Me localiser';
                        btn.disabled = false;
                    });
            },
            function(error) {
                alert('Erreur de géolocalisation : ' + error.message);
                btn.textContent = '📍 Me localiser';
                btn.disabled = false;
            }
        );
    } else {
        alert('La géolocalisation n\'est pas supportée par votre navigateur');
    }
}

function resetFilters() {
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    const distanceRange = document.getElementById('distanceRange');
    const distanceValue = document.getElementById('distanceValue');
    const userLocation = document.getElementById('userLocation');
    const concessionSelect = document.getElementById('concessionSelect');
    
    if (minPrice) minPrice.value = '';
    if (maxPrice) maxPrice.value = '';
    if (priceRange) priceRange.value = 200;
    if (priceValue) priceValue.textContent = '0€ - 200€';
    if (distanceRange) distanceRange.value = 50;
    if (distanceValue) distanceValue.textContent = '50 km';
    if (userLocation) userLocation.value = '';
    if (concessionSelect) concessionSelect.value = '';
    
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    userLatitude = null;
    userLongitude = null;
    
    loadAllVehicles();
}

async function loadAllVehicles() {
    showLoader();
    
    try {
        const response = await fetch('filter_vehicules.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ sortBy: currentSort })
        });
        
        const data = await response.json();
        console.log('Véhicules chargés:', data);
        
        hideLoader();
        
        if (data.success) {
            displayVehicles(data.vehicles);
        } else {
            showFilterMessage('Erreur lors du chargement des véhicules', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        hideLoader();
        showFilterMessage('Erreur de connexion au serveur', 'error');
    }
}

function viewDetails(plaque) {
    window.location.href = `vehicle_details.php?plaque=${encodeURIComponent(plaque)}`;
}

// ========================================
// INITIALISATION
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initialisation des filtres...');
    
    loadAllVehicles();
    
    // Sliders
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    const minPriceInput = document.getElementById("minPrice");
    const maxPriceInput = document.getElementById("maxPrice");

if (priceRange && priceValue && minPriceInput && maxPriceInput) {
    // Initialisation
    minPriceInput.value = 0;
    maxPriceInput.value = priceRange.value;
    priceValue.textContent = `${minPriceInput.value}€ - ${maxPriceInput.value}€`;

    // Slider → met à jour maxPrice
    priceRange.addEventListener("input", function() {
        maxPriceInput.value = this.value;
        priceValue.textContent = `${minPriceInput.value || 0}€ - ${this.value}€`;
    });

    // MinPrice → met à jour affichage
    minPriceInput.addEventListener("input", function() {
        priceValue.textContent = `${this.value || 0}€ - ${maxPriceInput.value || priceRange.value}€`;
    });

    // MaxPrice → synchronise avec slider
    maxPriceInput.addEventListener("input", function() {
        priceRange.value = this.value;
        priceValue.textContent = `${minPriceInput.value || 0}€ - ${this.value}€`;
    });
}

    
    const distanceRange = document.getElementById('distanceRange');
    const distanceValue = document.getElementById('distanceValue');
    if (distanceRange && distanceValue) {
        distanceRange.addEventListener('input', function() {
            distanceValue.textContent = `${this.value} km`;
        });
    }
    
    // Fermer les menus avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.key === 'Esc') {
            const panel = document.getElementById('filterPanel');
            const overlay = document.querySelector('.filter-overlay');
            if (panel && panel.classList.contains('open')) {
                panel.classList.remove('open');
                if (overlay) overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
            
            const sortMenu = document.getElementById('sortMenu');
            if (sortMenu && sortMenu.classList.contains('active')) {
                toggleSortDropdown();
            }
        }
    });
    
    // Fermer le menu de tri en cliquant ailleurs
    document.addEventListener('click', function(event) {
        const sortDropdown = document.querySelector('.sort-dropdown');
        const menu = document.getElementById('sortMenu');
        
        if (sortDropdown && menu && !sortDropdown.contains(event.target) && menu.classList.contains('active')) {
            toggleSortDropdown();
        }
    });
    
    console.log('Filtres initialisés avec succès');
});