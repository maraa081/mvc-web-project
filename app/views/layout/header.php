<?php
if (!defined('BASE_URL')) {
    die('BASE_URL non défini');
}
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

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

    <!-- CSS PAGE -->
    <?php if (!empty($pageCss)): ?>
        <?php foreach ($pageCss as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="nav-logo">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                <circle cx="20" cy="20" r="18" fill="#1a5f3d"/>
            </svg>
            <span class="logo-text">VTC Rentium</span>
        </div>

        <ul class="nav-menu">
            <li><a href="<?= BASE_URL ?>/public/index.php?page=home" class="nav-link">Accueil</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=vehicles" class="nav-link">Véhicules</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=blog" class="nav-link">Blog</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=about" class="nav-link">À propos</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=contact" class="nav-link">Contact</a></li>
        </ul>

        <div class="nav-buttons">
            <a href="<?= BASE_URL ?>/public/index.php?page=login" class="btn-login">Login</a>
            <a href="<?= BASE_URL ?>/public/index.php?page=register" class="btn-register">Se connecter</a>
        </div>
    </div>
</nav>
