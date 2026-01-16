<?php require __DIR__ . '/layout/header.php'; ?>

<!--  HERO  -->
<section class="hero">
    <div class="hero-container">

        <div class="hero-content">
            <h1 class="hero-title">Vivez la route comme jamais auparavant</h1>
            <p class="hero-subtitle">
                Uniquement harmonieux style et de la performance.<br>
                Une conception fluide qui allie puissance et élégance.<br>
                Une expérience taillée pour s'adapter à chaque instant.
            </p>

            <a href="<?= BASE_URL ?>/public/index.php?page=vehicles" class="btn-primary">
                Voir toutes les voitures
            </a>
        </div>

        <div class="booking-card">
            <h3 class="booking-title">Réservez votre voiture</h3>
            <form class="booking-form" method="GET" action="<?= BASE_URL ?>/public/index.php" id="bookingForm">
                <input type="hidden" name="page" value="vehicles">
                
                <div class="form-group">
                    <label>Type de voiture <span class="required">*</span></label>
                    <select class="form-select" name="type" id="typeSelect" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="Berline">Berline</option>
                        <option value="Sport">Sport</option>
                        <option value="SUV">SUV</option>
                        <option value="Électrique">Électrique</option>
                    </select>
                    <span class="error-message" id="typeError"></span>
                </div>

                <div class="form-group">
                    <label>Marque</label>
                    <select class="form-select" name="marque" id="marqueSelect">
                        <option value="">Toutes les marques</option>
                        <option value="Mercedes">Mercedes</option>
                        <option value="BMW">BMW</option>
                        <option value="Audi">Audi</option>
                        <option value="Tesla">Tesla</option>
                        <option value="Toyota">Toyota</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date de location <span class="required">*</span></label>
                    <input type="date" class="form-input" name="date_debut" id="dateDebut" required>
                    <span class="error-message" id="dateDebutError"></span>
                </div>

                <div class="form-group">
                    <label>Date de retour <span class="required">*</span></label>
                    <input type="date" class="form-input" name="date_fin" id="dateFin" required>
                    <span class="error-message" id="dateFinError"></span>
                </div>

                <button type="submit" class="btn-book">Réserver maintenant</button>
            </form>
        </div>

    </div>
</section>

<!--  FEATURES  -->
<section class="features">
    <div class="container">

        <div class="feature-card">
            <h3 class="feature-title">Disponibilité</h3>
            <p class="feature-text">
                Une expérience fluide et toujours accessible.
            </p>
        </div>

        <div class="feature-card">
            <h3 class="feature-title">Confort</h3>
            <p class="feature-text">
                Élégance et performance au quotidien.
            </p>
        </div>

        <div class="feature-card">
            <h3 class="feature-title">Économies</h3>
            <p class="feature-text">
                Meilleur rapport qualité-prix.
            </p>
        </div>

    </div>
</section>

<!--  SUGGESTED VEHICLES  -->
<section class="suggested-vehicles">
    <div class="container">
        <h2 class="section-title">Nos voitures populaires</h2>
        <p class="section-subtitle">Découvrez notre sélection de véhicules premium</p>

        <div class="vehicles-grid">
            <?php if (!empty($suggestedVehicles)): ?>
                <?php foreach ($suggestedVehicles as $vehicle): ?>
                    <div class="vehicle-card">
                        <div class="vehicle-image">
                            <img src="<?= BASE_URL ?>/assets/images/vehicles/<?= htmlspecialchars($vehicle['image']) ?>" 
                                 alt="<?= htmlspecialchars($vehicle['marque'] . ' ' . $vehicle['modele']) ?>">
                            <div class="vehicle-badge"><?= htmlspecialchars($vehicle['type']) ?></div>
                        </div>
                        
                        <div class="vehicle-info">
                            <h3 class="vehicle-name">
                                <?= htmlspecialchars($vehicle['marque'] . ' ' . $vehicle['modele']) ?>
                            </h3>
                            
                            <div class="vehicle-details">
                                <span class="detail-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                    </svg>
                                    <?= htmlspecialchars($vehicle['couleur']) ?>
                                </span>
                                <span class="detail-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    <?= htmlspecialchars($vehicle['concession']) ?>
                                </span>
                            </div>
                            
                            <div class="vehicle-footer">
                                <div class="vehicle-price">
                                    <span class="price-amount"><?= number_format($vehicle['prix_journalier'], 0) ?>€</span>
                                    <span class="price-period">/jour</span>
                                </div>
                                <a href="<?= BASE_URL ?>/public/index.php?page=booking&id_annonce=<?= $vehicle['id_annonce'] ?>" 
                                   class="btn-reserve">
                                    Réserver
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-vehicles">Aucun véhicule disponible pour le moment</p>
            <?php endif; ?>
        </div>

        <div class="view-all-container">
            <a href="<?= BASE_URL ?>/public/index.php?page=vehicles" class="btn-view-all">
                Voir tous les véhicules
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<style>
/*  SUGGESTED VEHICLES SECTION  */
.suggested-vehicles {
    padding: 80px 0;
    background: #f9fafb;
}

.section-title {
    font-size: 36px;
    font-weight: 700;
    text-align: center;
    color: #1f2937;
    margin-bottom: 12px;
}

.section-subtitle {
    text-align: center;
    color: #6b7280;
    font-size: 18px;
    margin-bottom: 48px;
}

.vehicles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 32px;
    margin-bottom: 48px;
}

.vehicle-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    transition: all 0.3s ease;
}

.vehicle-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
}

.vehicle-image {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.vehicle-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vehicle-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: rgba(255, 255, 255, 0.95);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.vehicle-info {
    padding: 24px;
}

.vehicle-name {
    font-size: 22px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
}

.vehicle-details {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: #6b7280;
}

.detail-item svg {
    color: #9ca3af;
}

.vehicle-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.vehicle-price {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.price-amount {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
}

.price-period {
    font-size: 14px;
    color: #6b7280;
}

.btn-reserve {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
}

.btn-reserve:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.view-all-container {
    text-align: center;
}

.btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: white;
    color: #374151;
    padding: 14px 32px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    background: #1f2937;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

.no-vehicles {
    grid-column: 1 / -1;
    text-align: center;
    padding: 48px;
    color: #9ca3af;
    font-size: 18px;
}

@media (max-width: 768px) {
    .vehicles-grid {
        grid-template-columns: 1fr;
    }
    
    .section-title {
        font-size: 28px;
    }
}
</style>

<!--  STATS  -->
<section class="stats">
    <div class="container">
        <h2 class="stats-title">Chiffres Clés</h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">540+</div>
                <div class="stat-label">Cars</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">20k+</div>
                <div class="stat-label">Clients</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">25+</div>
                <div class="stat-label">Années</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">20m+</div>
                <div class="stat-label">Km parcourus</div>
            </div>
        </div>
    </div>
</section>

<script>
// ===== VALIDATION DU FORMULAIRE =====
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Réinitialiser les erreurs
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    document.querySelectorAll('.form-select, .form-input').forEach(el => el.classList.remove('error'));
    
    // Validation Type
    const type = document.getElementById('typeSelect');
    if (!type.value) {
        showError(type, 'typeError', 'Veuillez sélectionner un type de voiture');
        isValid = false;
    }
    
    // Validation Date début
    const dateDebut = document.getElementById('dateDebut');
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (!dateDebut.value) {
        showError(dateDebut, 'dateDebutError', 'Veuillez sélectionner une date de location');
        isValid = false;
    } else if (new Date(dateDebut.value) < today) {
        showError(dateDebut, 'dateDebutError', 'La date de location ne peut pas être dans le passé');
        isValid = false;
    }
    
    // Validation Date fin
    const dateFin = document.getElementById('dateFin');
    if (!dateFin.value) {
        showError(dateFin, 'dateFinError', 'Veuillez sélectionner une date de retour');
        isValid = false;
    } else if (dateDebut.value && new Date(dateFin.value) <= new Date(dateDebut.value)) {
        showError(dateFin, 'dateFinError', 'La date de retour doit être après la date de location');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});

function showError(input, errorId, message) {
    input.classList.add('error');
    document.getElementById(errorId).textContent = message;
}

// ===== DATE MINIMUM AUJOURD'HUI =====
const today = new Date().toISOString().split('T')[0];
document.getElementById('dateDebut').setAttribute('min', today);
document.getElementById('dateFin').setAttribute('min', today);
</script>

<?php require __DIR__ . '/layout/footer.php'; ?>
