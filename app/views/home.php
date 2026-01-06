<?php require __DIR__ . '/layout/header.php'; ?>

<!-- ================= HERO ================= -->
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
            <form class="booking-form">
                <div class="form-group">
                    <label>Type de voiture</label>
                    <select class="form-select">
                        <option>Sedan</option>
                        <option>Sport</option>
                        <option>SUV</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Lieu de location</label>
                    <select class="form-select">
                        <option>Paris</option>
                        <option>Lyon</option>
                        <option>Marseille</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date de location</label>
                    <input type="date" class="form-input">
                </div>

                <div class="form-group">
                    <label>Date de retour</label>
                    <input type="date" class="form-input">
                </div>

                <button class="btn-book">Réserver maintenant</button>
            </form>
        </div>

    </div>
</section>

<!-- ================= FEATURES ================= -->
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

<!-- ================= STATS ================= -->
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

<?php require __DIR__ . '/layout/footer.php'; ?>
