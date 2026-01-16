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

    <!-- CSS externe -->
    <?php if (!empty($pageCss)): ?>
        <?php foreach ($pageCss as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f9fafb;
            color: #1f2937;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
        }

        .sidebar-top {
            flex: 1;
            padding: 24px 16px;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            padding: 0 12px;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }

        .sidebar-nav ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            background: #f3f4f6;
            color: #1f2937;
        }

        .sidebar-nav a.active {
            background: #ecfdf5;
            color: #059669;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
        }

        .sidebar-bottom {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
        }

        .sidebar-bottom a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-bottom a:hover {
            background: #f3f4f6;
            color: #1f2937;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        /* TOP BAR */
        .top-bar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f9fafb;
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            min-width: 320px;
        }

        .search-icon {
            width: 18px;
            height: 18px;
            opacity: 0.5;
        }

        .search-wrapper input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            flex: 1;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notif-btn {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .notif-btn:hover {
            background: #f3f4f6;
        }

        .icon-img {
            width: 20px;
            height: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile:hover {
            background: #f3f4f6;
        }

        .avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .user-profile span {
            font-size: 14px;
            font-weight: 500;
        }

        .dropdown-icon {
            width: 16px;
            height: 16px;
        }

        /* CONTENT */
        .content-scrollable {
            flex: 1;
            overflow-y: auto;
            background: #f9fafb;
        }
    </style>
</head>

<body>

<div class="app-container">
    
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo-area">
                <img src="<?= BASE_URL ?>/assets/images/avatar-default.png" class="logo-img" alt="Logo">
                <span class="brand-name">VTC Rentium</span>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="<?= BASE_URL ?>/public/index.php?page=admin_dashboard" class="<?= ($_GET['page'] ?? '') === 'admin_dashboard' ? 'active' : '' ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/public/index.php?page=admin_vehicles" class="<?= ($_GET['page'] ?? '') === 'admin_vehicles' ? 'active' : '' ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                            Véhicules
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/public/index.php?page=admin_orders" class="<?= ($_GET['page'] ?? '') === 'admin_orders' ? 'active' : '' ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M9 3v18"/>
                            </svg>
                            Réservations
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/public/index.php?page=admin_clients">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            Clients
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <a href="<?= BASE_URL ?>/public/index.php?page=admin_settings">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M12 1v6m0 6v6m7.071-14.071l-4.243 4.243m0 5.656l4.243 4.243M1 12h6m6 0h6m-14.071 7.071l4.243-4.243m5.656 0l4.243 4.243"/>
                </svg>
                Paramètres
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main-content">
        
        <!-- TOP BAR -->
        <header class="top-bar">
            <div class="search-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" placeholder="Recherche">
            </div>

            <div class="user-actions">
                <button class="notif-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </button>

                <div class="user-profile">
                    <img src="<?= BASE_URL ?>/assets/images/avatar-default.png" class="avatar-img" alt="Avatar">
                    <span><?= $_SESSION['admin']['nom'] ?? 'Administrateur' ?></span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
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
