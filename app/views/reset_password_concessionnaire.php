<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Nouveau mot de passe</h1>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="auth-message error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=reset_password_concessionnaire&token=<?= htmlspecialchars($_GET['token']) ?>">

                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="password" required minlength="8">
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirm" required minlength="8">
                </div>

                <button type="submit" class="btn-submit">Réinitialiser</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
