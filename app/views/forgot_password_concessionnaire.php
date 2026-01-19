<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Mot de passe oublié</h1>
                <p>Entrez votre email professionnel pour recevoir un lien de réinitialisation.</p>
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

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=forgot_password_concessionnaire">

                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="form-group">
                    <label>Email professionnel</label>
                    <input type="email" name="email" required>
                </div>

                <button type="submit" class="btn-submit">Envoyer le lien</button>

                <p class="switch-form">
                    <a href="<?= BASE_URL ?>/public/index.php?page=login_concessionnaire">
                        Retour à la connexion
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
