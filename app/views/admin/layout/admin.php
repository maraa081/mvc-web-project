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
    <title>VTC Rentium - Admin</title>

    <!-- CSS PAGE (exactement comme vos potes) -->
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
                        <a href="#">
                            <img src="<?= BASE_URL ?>/assets/img/dashboard.png" class="nav-icon">
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= BASE_URL ?>/assets/img/wheel.png" class="nav-icon">
                            Véhicules
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= BASE_URL ?>/assets/img/car.png" class="nav-icon">
                            Réservations
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= BASE_URL ?>/assets/img/calendar.png" class="nav-icon">
                            Calendrier
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <a href="<?= BASE_URL ?>/public/index.php?page=admin_settings" class="nav-link active-settings">
                <img src="<?= BASE_URL ?>/assets/img/paramètre.png" class="nav-icon">
                Paramètres
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main-content">
        
        <!-- TOP BAR -->
        <header class="top-bar">
            <div class="search-wrapper">
                <img src="<?= BASE_URL ?>/assets/img/loupe.png" class="search-icon">
                <input type="text" placeholder="Recherche">
            </div>

            <div class="user-actions">

                <div class="action-container">
                    <button class="notif-btn">
                        <img src="<?= BASE_URL ?>/assets/img/cloche.png" class="icon-img">
                    </button>
                </div>

                <div class="action-container">
                    <div class="user-profile">
                        <img src="<?= BASE_URL ?>/assets/img/Logo App.png" class="avatar-img">
                        <span>Nom du Client</span>
                        <img src="<?= BASE_URL ?>/assets/img/arrow.png" class="dropdown-icon">
                    </div>
                </div>

            </div>
        </header>

        <!-- CONTENU PAGE -->
        <div class="content-scrollable">
            <?= $content ?>
        </div>

    </main>
</div>

<!-- JS PAGE -->
<?php if (!empty($pageJs)): ?>
    <?php foreach ($pageJs as $js): ?>
        <script src="<?= BASE_URL ?>/assets/js/<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
