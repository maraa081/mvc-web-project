<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';

$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTC Rentium</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <?php if (isset($pageCss) && is_array($pageCss)): ?>
        <?php foreach ($pageCss as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= htmlspecialchars($css, ENT_QUOTES, 'UTF-8') ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">

        <a href="<?= BASE_URL ?>/public/index.php?page=home" class="nav-logo">
            <img src="<?= BASE_URL ?>/assets/images/Logo App.png" alt="Logo VTC Rentium" class="logo-img" onerror="this.style.display='none'">
            <span class="logo-text">VTC Rentium</span>
        </a>

        <ul class="nav-menu">
            <li><a href="<?= BASE_URL ?>/public/index.php?page=home">Accueil</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=vehicles">Véhicules</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=carte">Carte Agences</a></li> <li><a href="<?= BASE_URL ?>/public/index.php?page=blog">Blog</a></li> <li><a href="<?= BASE_URL ?>/public/index.php?page=about">À propos</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=contact">Contact</a></li>
        </ul>

        <div class="nav-buttons">

            <?php if (!$user): ?>

                <div class="dropdown">
                    <button class="btn-login">Connexion</button>
                    <div class="dropdown-content">
                        <a href="<?= BASE_URL ?>/public/index.php?page=login">Client</a>
                        <a href="<?= BASE_URL ?>/public/index.php?page=login_concessionnaire">Concessionnaire</a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn-register">Inscription</button>
                    <div class="dropdown-content">
                        <a href="<?= BASE_URL ?>/public/index.php?page=register">Client</a>
                        <a href="<?= BASE_URL ?>/public/index.php?page=register_concessionnaire">Concessionnaire</a>
                    </div>
                </div>

            <?php else: ?>

                <div class="user-info">
                    <div class="user-avatar" style="width:35px; height:35px; border-radius:50%; overflow:hidden; background:#eee; display:flex; align-items:center; justify-content:center;">
                        <?php if (!empty($user['avatar_url'])): ?>
                            <img src="<?= BASE_URL . '/' . htmlspecialchars($user['avatar_url']) ?>" 
                                alt="Avatar" 
                                style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <?= strtoupper(substr(htmlspecialchars($user['nom']), 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                    <span class="user-name"><?= htmlspecialchars($user['nom']) ?></span>
                </div>

                <?php if (isset($user['role']) && $user['role'] === 'concessionnaire'): ?>
                    
                    <a href="<?= BASE_URL ?>/public/index.php?page=dashboard_concessionnaire" class="btn-dashboard" title="Tableau de bord Pro">
                        📊
                    </a>
                    <?php else: ?>
                    
                    <a href="<?= BASE_URL ?>/public/index.php?page=settings" class="btn-gear" title="Paramètres Compte">
                        ⚙️
                    </a>

                <?php endif; ?>

                <a href="<?= BASE_URL ?>/public/index.php?page=logout" class="btn-logout" onclick="return confirm('Se déconnecter ?');">Déconnexion</a>

            <?php endif; ?>

        </div>
    </div>
</nav>