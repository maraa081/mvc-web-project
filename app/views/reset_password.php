<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <!-- Formulaire de nouveau mot de passe -->
        <div class="auth-box">
            <div class="auth-header">
                <h1>🔑 Nouveau mot de passe</h1>
                <p>Choisissez un nouveau mot de passe sécurisé</p>
            </div>

            <?php if (isset($_SESSION['reset_error'])): ?>
                <div class="auth-message error">
                    ❌ <?= htmlspecialchars($_SESSION['reset_error'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['reset_error']); ?>
            <?php endif; ?>

            <form method="POST" 
                  action="<?= BASE_URL ?>/public/index.php?page=reset_password&token=<?= htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                  id="resetForm"
                  novalidate>

                <!-- 🔐 Token CSRF -->
                <input type="hidden" name="csrf_token" 
                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Minimum 8 caractères" 
                        required 
                        minlength="8"
                        autocomplete="new-password">
                    <small style="color: #666; font-size: 12px;">Au moins 8 caractères</small>
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input 
                        type="password" 
                        name="password_confirm" 
                        placeholder="Retapez votre mot de passe" 
                        required 
                        minlength="8"
                        autocomplete="new-password">
                </div>

                <button type="submit" class="btn-submit">Réinitialiser le mot de passe</button>

                <p class="switch-form">
                    <a href="<?= BASE_URL ?>/public/index.php?page=login">Retour à la connexion</a>
                </p>
            </form>
        </div>

        <!-- Image de côté -->
        <div class="auth-image">
            <div class="image-overlay">
                <h2>Sécurité renforcée</h2>
                <p>Votre nouveau mot de passe sera crypté et sécurisé</p>
                <div class="features">
                    <div class="feature-item">
                        <span>✓</span> Chiffrement BCrypt
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Stockage sécurisé
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Vérification double
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
