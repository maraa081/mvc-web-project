<?php
$pageCss = ['auth.css'];
$pageJs  = ['auth.js'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">

        <div class="auth-box">
            <div class="auth-header">
                <h1>Connexion</h1>
                <p>Bienvenue ! Connectez-vous à votre compte</p>
            </div>

            <form>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="exemple@email.com" required>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" placeholder="Entrez votre mot de passe" required>
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-submit">Se connecter</button>

                <div class="divider"><span>OU</span></div>

                <button type="button" class="btn-google">
                    <img src="https://www.google.com/favicon.ico" width="20">
                    Continuer avec Google
                </button>

                <p class="switch-form">
                    Vous n'avez pas de compte ?
                    <a href="<?= BASE_URL ?>/public/index.php?page=register">Inscrivez-vous</a>
                </p>
            </form>
        </div>

        <div class="auth-image">
            <div class="image-overlay">
                <h2>Réservez votre véhicule en quelques clics</h2>
                <p>Accédez à notre flotte premium</p>
                <div class="features">
                    <div class="feature-item"><span>✓</span> Réservation rapide</div>
                    <div class="feature-item"><span>✓</span> Véhicules premium</div>
                    <div class="feature-item"><span>✓</span> Service 24/7</div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
