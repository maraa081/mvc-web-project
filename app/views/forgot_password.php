<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <!-- Formulaire de réinitialisation -->
        <div class="auth-box">
            <div class="auth-header">
                <h1>🔒 Mot de passe oublié</h1>
                <p>Entrez votre email pour recevoir un lien de réinitialisation</p>
            </div>

            <?php if (isset($_SESSION['forgot_success'])): ?>
                <div class="auth-message success">
                    ✅ <?= htmlspecialchars($_SESSION['forgot_success'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['forgot_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['forgot_error'])): ?>
                <div class="auth-message error">
                    ❌ <?= htmlspecialchars($_SESSION['forgot_error'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['forgot_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['reset_link'])): ?>
                <div class="auth-message success">
                    <strong>Mode DEV :</strong> 
                    <a href="<?= htmlspecialchars($_SESSION['reset_link'], ENT_QUOTES, 'UTF-8') ?>" 
                       style="color: #155724; text-decoration: underline;">
                        Cliquez ici pour réinitialiser votre mot de passe
                    </a>
                </div>
                <?php unset($_SESSION['reset_link']); ?>
            <?php endif; ?>

            <form method="POST" 
                  action="<?= BASE_URL ?>/public/index.php?page=forgot_password"
                  id="forgotForm"
                  novalidate>

                <!-- 🔐 Token CSRF -->
                <input type="hidden" name="csrf_token" 
                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                <div class="form-group">
                    <label>Adresse email</label>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="exemple@email.com" 
                        required
                        autocomplete="email"
                        inputmode="email">
                </div>

                <button type="submit" class="btn-submit">Envoyer le lien</button>

                <p class="switch-form">
                    Vous vous souvenez de votre mot de passe ? 
                    <a href="<?= BASE_URL ?>/public/index.php?page=login">Se connecter</a>
                </p>
            </form>
        </div>

        <!-- Image de côté -->
        <div class="auth-image">
            <div class="image-overlay">
                <h2>Récupération sécurisée</h2>
                <p>Nous allons vous envoyer un lien sécurisé pour réinitialiser votre mot de passe</p>
                <div class="features">
                    <div class="feature-item">
                        <span>✓</span> Lien sécurisé
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Expiration 1h
                    </div>
                    <div class="feature-item">
                        <span>✓</span> Protection totale
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
