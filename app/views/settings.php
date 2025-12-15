<?php
$pageCss = ['style.css']; // ton CSS global
require __DIR__ . '/layout/header.php';
?>

<div class="container">
    <h1>Paramètres du compte</h1>

    <div class="settings-panel">
        <div class="setting-item">
            <label>Nom d'utilisateur</label>
            <input type="text" placeholder="Entrez votre nom">
        </div>

        <div class="setting-item">
            <label>Email</label>
            <input type="email" placeholder="Votre email">
        </div>

        <div class="setting-item">
            <label>Mot de passe</label>
            <input type="password" placeholder="Nouveau mot de passe">
        </div>

        <button class="vehicle-btn">
            Enregistrer
        </button>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
