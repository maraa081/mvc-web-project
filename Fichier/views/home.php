<?php require __DIR__ . '/layout/header.php'; ?>

<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="hero-title">Vivez la route comme jamais auparavant</h1>
            <p class="hero-subtitle">
                Uniquement harmonieux style et de la performance.<br>
                Une conception fluide qui allie puissance et élégance.<br>
                Une expérience taillée pour s'adapter à chaque instant.
            </p>

            <a href="index.php?page=vehicles" class="btn-primary">
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

                <button type="submit" class="btn-book">Réserver maintenant</button>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
