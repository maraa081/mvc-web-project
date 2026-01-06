<?php
$pageCss = ['style.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="container">
    <h1>Paramètres du compte</h1>

    <div class="settings-panel">

        <div class="setting-item">
            <label>Nom d'utilisateur</label>
            <input type="text" value="<?= htmlspecialchars($_SESSION['user']['nom']) ?>">
        </div>

        <div class="setting-item">
            <label>Email</label>
            <input type="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>">
        </div>

        <div class="setting-item">
            <label>Nouveau mot de passe</label>
            <input type="password" placeholder="••••••••">
        </div>

        <button class="vehicle-btn">
            Enregistrer
        </button>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
