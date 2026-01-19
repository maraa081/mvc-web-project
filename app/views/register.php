<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <!-- Formulaire d'Inscription -->
        <div class="auth-box">
            <div class="auth-header">
                <h1>Inscription</h1>
                <p>Créez votre compte pour commencer</p>
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
                    <a href="<?= htmlspecialchars($_SESSION['confirm_link'], ENT_QUOTES, 'UTF-8') ?>">
                    Cliquez ici pour confirmer votre compte
                    </a>
                </div>
                <?php unset($_SESSION['confirm_link']); ?>
            <?php endif; ?>


            <form method="POST" 
                  action="<?= BASE_URL ?>/public/index.php?page=register" 
                  id="registerForm" 
                  novalidate>

                <!-- 🔐 Token CSRF -->
                <input type="hidden" name="csrf_token" 
                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input 
                            type="text" 
                            name="prenom" 
                            placeholder="Votre prénom" 
                            required 
                            minlength="2"
                            autocomplete="given-name">
                    </div>

                    <div class="form-group">
                        <label>Nom</label>
                        <input 
                            type="text" 
                            name="nom" 
                            placeholder="Votre nom" 
                            required 
                            minlength="2"
                            autocomplete="family-name">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="exemple@email.com" 
                        required 
                        autocomplete="email"
                        inputmode="email">
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Au moins 8 caractères" 
                        required 
                        minlength="8"
                        autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input 
                        type="password" 
                        name="password_confirm" 
                        placeholder="Confirmez votre mot de passe" 
                        required 
                        minlength="8"
                        autocomplete="new-password">
                </div>

                <label class="checkbox-label">
                    <input type="checkbox" name="terms" required>
                    <span>J'accepte les <a href="#">conditions générales</a></span>
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

        <!-- Image de côté -->
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

<?php 
$pageJs = ['auth.js'];
require __DIR__ . '/layout/footer.php'; 
?>
