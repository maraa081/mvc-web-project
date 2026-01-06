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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

    <!-- CSS SPÉCIFIQUE À LA PAGE -->
    <?php if (isset($pageCss) && is_array($pageCss)): ?>
        <?php foreach ($pageCss as $css): ?>
            <link
                rel="stylesheet"
                href="<?= BASE_URL ?>/assets/css/<?= htmlspecialchars($css, ENT_QUOTES, 'UTF-8') ?>"
            >
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">

        <!-- LOGO -->
        <a href="<?= BASE_URL ?>/public/index.php?page=home" class="nav-logo">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" aria-hidden="true">
                <circle cx="20" cy="20" r="18" fill="#1a5f3d"/>
            </svg>
            <span class="logo-text">VTC Rentium</span>
        </a>

        <!-- MENU -->
        <ul class="nav-menu">
            <li><a href="<?= BASE_URL ?>/public/index.php?page=home">Accueil</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=vehicles">Véhicules</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=blog">Blog</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=about">À propos</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=contact">Contact</a></li>
        </ul>

        <!-- ACTIONS UTILISATEUR -->
        <div class="nav-buttons">

            <?php if (!$user): ?>

                <!-- UTILISATEUR NON CONNECTÉ -->
                <a href="<?= BASE_URL ?>/public/index.php?page=login" class="btn-login">
                    Login
                </a>
                <a href="<?= BASE_URL ?>/public/index.php?page=register" class="btn-register">
                    Se connecter
                </a>

            <?php else: ?>

                <!-- UTILISATEUR CONNECTÉ -->
                <div class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr(htmlspecialchars($user['nom']), 0, 1)) ?>
                    </div>
                    <span class="user-name">
                        <?= htmlspecialchars($user['nom']) ?>
                    </span>
                </div>

                <a
                    href="<?= BASE_URL ?>/public/index.php?page=settings"
                    class="btn-gear"
                    title="Paramètres"
                >
                    ⚙️
                </a>

                <a
                    href="<?= BASE_URL ?>/public/index.php?page=logout"
                    class="btn-logout"
                >
                    Déconnexion
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>
