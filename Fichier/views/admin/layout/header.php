<?php
if (!defined('BASE_URL')) {
    die('No direct access');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | VTC Rentium</title>

    <?php if (!empty($pageCss)): ?>
        <?php foreach ($pageCss as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<div class="app-container">

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-top">
        <div class="logo-area">
            <img src="<?= BASE_URL ?>/assets/img/Logo App.png" class="logo-img">
            <span class="brand-name">VTC Rentium</span>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="<?= BASE_URL ?>/public/index.php?page=admin_clients">
                        <img src="<?= BASE_URL ?>/assets/img/clients.png" class="nav-icon">
                        Clients
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/public/index.php?page=admin_settings">
                        <img src="<?= BASE_URL ?>/assets/img/paramètre.png" class="nav-icon">
                        Paramètres
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- CONTENU PRINCIPAL -->
<main class="main-content">

<header class="top-bar">
    <div class="search-wrapper">
        <img src="<?= BASE_URL ?>/assets/img/loupe.png" class="search-icon">
        <input type="text" placeholder="Recherche">
    </div>

    <div class="user-actions">
        <div class="user-profile">
            <img src="<?= BASE_URL ?>/assets/img/Logo App.png" class="avatar-img">
            <span>Administrateur</span>
        </div>
    </div>
</header>

<div class="content-scrollable">
