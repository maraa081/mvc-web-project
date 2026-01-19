<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Connexion Concessionnaire</h1>
                <p>Accédez à votre espace professionnel</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="auth-message error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="auth-message success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=login_concessionnaire" id="loginForm" novalidate>

                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                <div class="form-group">
                    <label>Email professionnel</label>
                    <input type="email" name="email" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" required minlength="8">
                </div>
                
                <p class="forgot-password">
                    <a href="<?= BASE_URL ?>/public/index.php?page=forgot_password_concessionnaire">
                        Mot de passe oublié ?
                    </a>
                </p>

                <button type="submit" class="btn-submit">Connexion</button>

                <p class="switch-form">
                    Vous êtes un client ?
                    <a href="<?= BASE_URL ?>/public/index.php?page=login">Connexion client</a>
                </p>
            </form>
        </div>

        <div class="auth-image">
            <div class="image-overlay">
                <h2>Espace Pro</h2>
                <p>Gérez vos véhicules et vos annonces</p>
            </div>
        </div>
    </div>
</div>

<?php 
$pageJs = ['auth.js'];
require __DIR__ . '/layout/footer.php';
?>
