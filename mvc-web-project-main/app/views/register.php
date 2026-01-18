<?php 
// Si vous avez un tableau $pageCss dans votre header pour charger les styles, décommentez la ligne suivante
// $pageCss = ['auth.css']; 
require __DIR__ . '/layout/header.php'; 
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">

<div class="auth-container">
    <div class="auth-wrapper">
        
        <div class="auth-box">
            <div class="auth-header">
                <h1>Inscription</h1>
                <p>Créez votre compte pour commencer</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="auth-message error" style="background: #fee2e2; color: #991b1b; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center; border: 1px solid #f87171;">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=register" id="registerForm" novalidate>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" name="prenom" placeholder="Votre prénom" required>
                        </div>

                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" placeholder="Votre nom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="exemple@email.com" required>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="Au moins 8 caractères" required>
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password" placeholder="Confirmez votre mot de passe" required>
                </div>

                <label class="checkbox-label">
                    <input type="checkbox" name="terms" required>
                    <span>J'accepte les <a href="index.php?page=cgu">conditions générales</a></span>
                </label>

                <button type="submit" class="btn-submit">S'inscrire</button>

                <div class="divider">
                    <span>OU</span>
                </div>

                <button type="button" class="btn-google">
                    <img src="https://www.google.com/favicon.ico" alt="Google" width="20">
                    Continuer avec Google
                </button>

                <p class="switch-form">
                    Vous avez déjà un compte ? 
                    <a href="<?= BASE_URL ?>/public/index.php?page=login">Connectez-vous</a>
                </p>
            </form>
        </div>

        <div class="auth-image">
            <div class="image-overlay">
                <h2>Rejoignez VTC Rentium</h2>
                <p>Créez votre compte et accédez à tous nos services premium</p>
                <div class="features">
                    <div class="feature-item">
                        <span>✓</span> Inscription rapide
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Gestion simplifiée
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Offres exclusives
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