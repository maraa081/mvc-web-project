<?php
$pageCss = ['admin.css'];
$pageJs  = ['admin.js'];
require __DIR__ . '/../layout/header.php';
?>
<div class="page-card">
    <h1>Paramètres</h1>

    <div class="tabs-menu">
        <a class="tab-link active">Profil</a>
        <a class="tab-link">Mot de passe</a>
        <a class="tab-link">Notifications</a>
    </div>

    <div class="tab-content active-content">
        <form class="profile-form">
            <div class="input-group full-width">
                <label>Email</label>
                <input type="email" value="admin@vtcrentium.com">
            </div>

            <div class="form-actions-right">
                <button class="btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
