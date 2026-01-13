<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <!-- Formulaire de Login -->
        <div class="auth-box">
            <div class="auth-header">
                <h1>Connexion</h1>
                <p>Bienvenue ! Connectez-vous à votre compte</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="auth-message error">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="auth-message success">
                    <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['confirm_link'])): ?>
                <div class="auth-message success">
                    <strong>Mode DEV :</strong> 
                    <a href="<?= htmlspecialchars($_SESSION['confirm_link'], ENT_QUOTES, 'UTF-8') ?>" 
                       style="color: #155724; text-decoration: underline;">
                        Cliquez ici pour confirmer votre compte
                    </a>
                </div>
                <?php unset($_SESSION['confirm_link']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=login" id="loginForm">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="exemple@email.com" required>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="Entrez votre mot de passe" required>
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="<?= BASE_URL ?>/public/index.php?page=forgot_password" class="forgot-password">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-submit">Se connecter</button>

                <div class="divider">
                    <span>OU</span>
                </div>

                <button type="button" class="btn-google">
                    <img src="https://www.google.com/favicon.ico" alt="Google" width="20">
                    Continuer avec Google
                </button>

                <p class="switch-form">
                    Vous n'avez pas de compte ? 
                    <a href="<?= BASE_URL ?>/public/index.php?page=register">Inscrivez-vous</a>
                </p>
            </form>
        </div>

        <!-- Image de côté -->
        <div class="auth-image">
            <div class="image-overlay">
                <h2>Réservez votre véhicule en quelques clics</h2>
                <p>Accédez à notre flotte premium et profitez d'un service exceptionnel</p>
                <div class="features">
                    <div class="feature-item">
                        <span>✓</span> Réservation rapide
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Véhicules premium
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Service 24/7
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$pageJs = ['auth.js'];
require __DIR__ . '/layout/footer.php'; 
?>