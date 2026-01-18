<?php 
// Si votre header gère les styles via cette variable, gardez-la, sinon le lien en dur plus bas fait le travail
// $pageCss = ['auth.css']; 
require __DIR__ . '/layout/header.php'; 
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">

<div class="auth-container">
    <div class="auth-wrapper">
        
        <div class="auth-box">
            <div class="auth-header">
                <h1>Connexion</h1>
                <p>Bienvenue ! Connectez-vous à votre compte</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="auth-message error" style="background: #fee2e2; color: #991b1b; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center; border: 1px solid #f87171;">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="auth-message success" style="background: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;">
                    <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=login" id="loginForm" novalidate>
                
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

<script src="<?= BASE_URL ?>/assets/js/auth.js"></script>

<?php 
require __DIR__ . '/layout/footer.php'; 
?>