<?php
session_start();
require_once 'car.php';

$controller = new CarController();
$voitures = $controller->index();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles - Rentium</title>
    <link rel="stylesheet" href="style.css">
</head>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const profileSection = document.querySelector(".profile-section");
    const dropdown = document.getElementById("profileMenu");

    profileSection.addEventListener("click", () => {
        dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
    });

    // Clique extérieur → referme le menu
    document.addEventListener("click", (e) => {
        if (!profileSection.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none";
        }
    });
});
</script>

<script src="filter.js"></script>

<body>
    <header>
        <div class="header-content">
            <div class="logo_rentium">
    <img src="rentium_modifié.png" alt="Logo Rentium" class="logo_rentium-icon">
    <span>VTC Rentium</span>
</div>

            <nav>
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Véhicules</a></li>
                    <li><a href="#">Détails</a></li>
                    <li><a href="#">À propos de nous</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                </ul>
            </nav>
            <div class="header-icons">
                <div class="icon-circle">
                    <img src="coeur.png" alt="Favoris">
                </div>
                <div class="icon-circle">
                    <img src="cloche.png" alt="Notifications">
                </div>
                <div class="icon-circle">
                    <img src="ecrou.png" alt="Parametre">
                </div>
                <div class="profile-section">
                    <div class="profile-logo">
                        <img src="rentium_modifié.png" alt="Rentium Logo">
                    </div>
                    <span class="profile-name">
			<?= isset($_SESSION['user_nom']) ? $_SESSION['user_nom'] : 'Invité'; ?>
		   </span>
                    <span class="dropdown-icon">▼</span>
                </div>
<div class="profile-dropdown" id="profileMenu">
    <button onclick="window.location.href='profil.html'">Profil</button>
    <button onclick="window.location.href='logout.php'">Déconnexion</button>
</div>
            </div>
        </div>
    </header>


    <div class="container">
        <h1>Sélectionnez un groupe de véhicules</h1>
        <!-- Boutons filtres -->
<div class="filter-buttons">
    <button class="filter-btn active" onclick="filterByType('')">
        <span>✓</span>
        Tout voir
    </button>
    <button class="filter-btn" onclick="filterByType('Berline')">
        🚗 Berline
    </button>
    <button class="filter-btn" onclick="filterByType('Cabriolet')">
        🚙 Cabriolet
    </button>
    <button class="filter-btn" onclick="filterByType('SUV')">
        🚐 SUV
    </button>
    <button class="filter-btn" onclick="filterByType('Citadine')">
        🚗 Citadine
    </button>
    <button class="filter-btn" onclick="filterByType('Van')">
        🚌 Van
    </button>
            <button class="filter-btn filter-advanced-btn" onclick="toggleFilterPanel()">
                <span>⚙️</span>
                Filtres avancés
            </button>
        </div>

<!-- Panneau filtres avancés -->
<div class="filter-panel" id="filterPanel">
    <div class="filter-panel-header">
        <h3>Filtres avancés</h3>
        <button class="close-filter-btn" onclick="toggleFilterPanel()">✕</button>
    </div>

    <div class="filter-panel-content">
        <!-- Prix -->
        <div class="filter-section">
            <label class="filter-label">Prix journalier (€)</label>
            <div class="price-inputs">
                <input type="number" id="minPrice" placeholder="Min" min="0">
                <span>-</span>
                <input type="number" id="maxPrice" placeholder="Max" min="0">
            </div>
            <div class="price-range">
                <input type="range" id="priceRange" min="0" max="200" value="200" step="10">
                <span id="priceValue">0€ - 200€</span>
            </div>
        </div>

        <!-- Marque -->
<div class="filter-section">
    <label class="filter-label">Marque</label>
    <div class="checkbox-group">
        <label><input type="checkbox" name="marque" value="Kia"> Kia</label>
        <label><input type="checkbox" name="marque" value="Toyota"> Toyota</label>
        <label><input type="checkbox" name="marque" value="Mercedes"> Mercedes</label>
        <label><input type="checkbox" name="marque" value="Peugeot"> Peugeot</label>
        <label><input type="checkbox" name="marque" value="Hyundai"> Hyundai</label>
        <label><input type="checkbox" name="marque" value="Renault"> Renault</label>
        <label><input type="checkbox" name="marque" value="BMW"> BMW</label>
        <label><input type="checkbox" name="marque" value="Audi"> Audi</label>
        <label><input type="checkbox" name="marque" value="Tesla"> Tesla</label>
        <label><input type="checkbox" name="marque" value="Volkswagen"> Volkswagen</label>
        <label><input type="checkbox" name="marque" value="Skoda"> Skoda</label>
        <label><input type="checkbox" name="marque" value="Lexus"> Lexus</label>
    </div>
</div>

        <!-- Couleur -->
<div class="filter-section">
    <label class="filter-label">Couleur</label>
    <div class="color-grid">
        <label><input type="checkbox" name="couleur" value="Noire"> <span class="color-box" style="background:#000"></span> Noire</label>
        <label><input type="checkbox" name="couleur" value="Blanche"> <span class="color-box" style="background:#fff"></span> Blanche</label>
        <label><input type="checkbox" name="couleur" value="Grise"> <span class="color-box" style="background:#808080"></span> Grise</label>
        <label><input type="checkbox" name="couleur" value="Rouge"> <span class="color-box" style="background:#DC143C"></span> Rouge</label>
    </div>
</div>

<!-- Distance de la concession -->
                <div class="filter-section">
                    <label class="filter-label">Distance maximale de la concession</label>
                    <div class="distance-control">
                        <input type="range" id="distanceRange" min="5" max="100" value="50" step="5">
                        <span id="distanceValue">50 km</span>
                    </div>
                    <div class="location-input">
                        <input type="text" id="userLocation" placeholder="Votre adresse ou code postal">
                        <button class="btn-locate" onclick="getUserLocation()">📍 Me localiser</button>
                    </div>
                </div>

                <!-- Concession spécifique -->
                <div class="filter-section">
                    <label class="filter-label">Concession</label>
                    <select id="concessionSelect" class="filter-select">
                        <option value="">Toutes les concessions</option>
                        <option value="3">Luxembourg Centre</option>
                        <option value="1">Paris 15ème</option>
                        <option value="2">Nice</option>
                    </select>
                </div>
            </div>

            <div class="filter-panel-footer">
                <button class="btn-reset" onclick="resetFilters()">Réinitialiser</button>
                <button class="btn-apply" onclick="applyFilters()">Appliquer les filtres</button>
            </div>
        </div>

<!-- Bouton Trier par -->
<div class="sort-dropdown">
    <button class="filter-btn sort-btn" onclick="toggleSortDropdown()">
        <span>⇅</span>
        Trier par
        <span class="dropdown-arrow">▼</span>
    </button>
    <div class="sort-menu" id="sortMenu">
        <div class="sort-menu-header">Trier par</div>
        <button class="sort-option" onclick="applySorting('price_asc')">
            <span class="sort-icon">💰</span>
            <div>
                <div class="sort-label">Prix croissant</div>
                <div class="sort-sublabel">Du moins cher au plus cher</div>
            </div>
        </button>
        <button class="sort-option" onclick="applySorting('price_desc')">
            <span class="sort-icon">💎</span>
            <div>
                <div class="sort-label">Prix décroissant</div>
                <div class="sort-sublabel">Du plus cher au moins cher</div>
            </div>
        </button>
        <button class="sort-option" onclick="applySorting('recent')">
            <span class="sort-icon">🆕</span>
            <div>
                <div class="sort-label">Plus récent</div>
                <div class="sort-sublabel">Dernières annonces</div>
            </div>
        </button>
        <button class="sort-option" onclick="applySorting('oldest')">
            <span class="sort-icon">📅</span>
            <div>
                <div class="sort-label">Plus ancien</div>
                <div class="sort-sublabel">Anciennes annonces</div>
            </div>
        </button>
        <button class="sort-option" onclick="applySorting('brand_asc')">
            <span class="sort-icon">🔤</span>
            <div>
                <div class="sort-label">Marque (A-Z)</div>
                <div class="sort-sublabel">Ordre alphabétique</div>
            </div>
        </button>
        <button class="sort-option" onclick="applySorting('brand_desc')">
            <span class="sort-icon">🔡</span>
            <div>
                <div class="sort-label">Marque (Z-A)</div>
                <div class="sort-sublabel">Ordre inverse</div>
            </div>
        </button>
    </div>
</div>

<!-- Overlay pour le menu de tri -->
<div class="sort-overlay" id="sortOverlay" onclick="toggleSortDropdown()"></div>

        <div class="vehicle-grid">
    <!-- Ligne 1 -->
   
        <?php foreach ($voitures as $car): ?>
            <div class="vehicle-card">
                <div class="vehicle-image">

                    <?php 
                        // Nom de l'image : plaque_modele.png
                        // On remplace les espaces dans le modèle par des _
                        $modelClean = str_replace(' ', '_', $car['modele']);
                        $imageName = $car['plaque'] . '_' . $modelClean . '.png';

                        // Si tu veux gérer plusieurs extensions, tu peux ajouter la vérification
                        $extensions = ['png', 'jpg', 'jpeg', 'gif'];
                        foreach ($extensions as $ext) {
                            if (file_exists("images/{$car['plaque']}_{$modelClean}.{$ext}")) {
                                $imageName = "{$car['plaque']}_{$modelClean}.{$ext}";
                                break;
                            }
                        }
                    ?>

                    <img src="<?= htmlspecialchars($imageName) ?>" 
                         alt="<?= htmlspecialchars($car['marque'] . ' ' . $car['modele']) ?>">

                </div>

                <div class="vehicle-info">

                    <div class="vehicle-header">
                        <span class="vehicle-name">
                            <?= htmlspecialchars($car['marque'] . ' ' . $car['modele']) ?>
                        </span>

                        <span class="vehicle-price">
                            <?= htmlspecialchars($car['prix_journalier']) ?>€/jour
                        </span>
                    </div>

                    <div class="vehicle-features">
                        <div class="feature">🚗 Type : <?= htmlspecialchars($car['type']) ?></div>
                        <div class="feature">🎨 Couleur : <?= htmlspecialchars($car['couleur']) ?></div>
                        <div class="feature">📍 Concession : <?= htmlspecialchars($car['id_concess']) ?></div>
                    </div>

                    <button class="vehicle-btn">Voir les détails</button>
                </div>
            </div>
        <?php endforeach; ?>
    
</div>

            
        <div class="brand-logos">
        <div class="brand-logo">
        <img src="toyota.png" alt="Toyota">
    </div>
    <div class="brand-logo">
        <img src="ford.png" alt="Ford">
    </div>
    <div class="brand-logo">
        <img src="mercedes.png" alt="Mercedes">
    </div>
    <div class="brand-logo">
        <img src="jeep.png" alt="Jeep">
    </div>
    <div class="brand-logo">
        <img src="bmw.png" alt="BMW">
    </div>
    <div class="brand-logo">
        <img src="audi.png" alt="Audi">
    </div>
</div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>🚗 Car Rental</h3>
                <p>Choisir notre site c'est votre pour vivre un séjour durable. Soyez l'usagé et bienvenue dans nos agences ou chaque instant.</p>
                <div class="social-icons">
                    <div class="social-icon">f</div>
                    <div class="social-icon">in</div>
                    <div class="social-icon">📺</div>
                    <div class="social-icon">X</div>
                </div>
            </div>

            <div class="footer-section">
                <h3>✅ Notre site</h3>
                <ul>
                    <li><a href="#">À propos</a></li>
                    <li><a href="#">Destinations</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Clients</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>📢 Véhicules</h3>
                <ul>
                    <li><a href="#">Uber</a></li>
                    <li><a href="#">Taxi</a></li>
                    <li><a href="#">Minibus</a></li>
                    <li><a href="#">Limousines</a></li>
                    <li><a href="#">Voitures</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>📞 0352 74 69 45 18</h3>
                <p>VTC.rentium@gmail.com</p>
            </div>
        </div>

        <div class="copyright">
            © Copyright VTC Rentium 2025
        </div>
    </footer>
</body>
</html>

<!-- Fichier style.css à créer séparément (voir ci-dessous) -->