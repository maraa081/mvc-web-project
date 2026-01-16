<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">

        <div class="auth-box">
            <div class="auth-header">
                <h1>Inscription</h1>
                <p>Créez votre compte en quelques secondes</p>
            </div>

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=register">

                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="nom" placeholder="Votre nom" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="exemple@email.com" required>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirm" placeholder="Confirmez le mot de passe" required>
                </div>

                <label class="checkbox-label">
                    <input type="checkbox" required>
                    <span>
                        J'accepte les <a href="#">conditions d'utilisation</a>
                    </span>
                </label>

                <button type="submit" class="btn-submit">
                    Créer mon compte
                </button>

                <p class="switch-form">
                    Déjà un compte ?
                    <a href="<?= BASE_URL ?>/public/index.php?page=login">
                        Connectez-vous
                    </a>
                </p>
            </form>
        </div>

        <div class="auth-image">
            <div class="image-overlay">
                <h2>Rejoignez VTC Rentium</h2>
                <p>Une expérience premium de location</p>

                <div class="features">
                    <div class="feature-item"><span>✓</span> Inscription rapide</div>
                    <div class="feature-item"><span>✓</span> Véhicules premium</div>
                    <div class="feature-item"><span>✓</span> Support 24/7</div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
