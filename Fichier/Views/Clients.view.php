<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTC Rentium - Clients</title>
    <link rel="stylesheet" href="assets/css/suivi-clients.css">
</head>
<body>

<div class="app-container">
    
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo-area">
                <img src="assets/img/Logo App.png" alt="Logo" class="logo-img">
                <span class="brand-name">VTC Rentium</span>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="submenu-toggle">
                            <div class="nav-left">
                                <img src="assets/img/table-de-controle.png" alt="Icon" class="nav-icon">
                                <span>Tour de contrôle</span>
                            </div>
                            <img src="assets/img/expand.png" alt="Expand" class="chevron-icon" id="chevron-arrow">
                        </a>
                        <ul class="submenu" id="dashboard-submenu">
                            <li><a href="#"><img src="assets/img/dashboard.png" class="sub-icon"> Dashboard</a></li>
                            <li><a href="#"><img src="assets/img/analyse.png" class="sub-icon"> Analyses</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <div class="nav-left">
                                <img src="assets/img/box.png" alt="Cmd" class="nav-icon">
                                <span>Les commandes</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <div class="nav-left">
                                <img src="assets/img/car.png" alt="Auto" class="nav-icon">
                                <span>Véhicules</span>
                            </div>
                            <img src="assets/img/expand.png" alt="Expand" class="chevron-icon">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active-link">
                            <div class="nav-left">
                                <img src="assets/img/clients.png" alt="Clients" class="nav-icon">
                                <span>Clients</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <main class="main-content">
        
        <header class="top-bar">
            <div class="search-wrapper">
                <img src="assets/img/loupe.png" alt="Search" class="search-icon">
                <input type="text" placeholder="Recherche" >
            </div>
            
            <div class="user-actions">
                <div class="action-container">
                    <button class="notif-btn" id="notif-btn">
                        <img src="assets/img/cloche.png" alt="Notif">
                    </button>
                    <div class="dropdown-menu notif-dropdown-style" id="notif-menu">
                        <div class="dropdown-header">Notifications</div>
                        <div class="dropdown-body empty-state">
                            Aucune nouvelle notification.
                        </div>
                    </div>
                </div>

                <div class="action-container">
                    <div class="user-profile" id="profile-btn">
                        <img src="assets/img/Logo App.png" alt="Avatar" class="avatar-img">
                        <span>Administrateur</span>
                        <img src="assets/img/arrow.png" alt="Menu" class="dropdown-icon">
                    </div>
                    <div class="dropdown-menu profile-dropdown-style" id="profile-menu">
                        <ul>
                            <li><a href="#" class="menu-link">Mon Profil</a></li>
                            <li><a href="parametres.php" class="menu-link">Paramètres</a></li>
                            <li class="menu-separator"></li>
                            <li><a href="#" class="menu-link logout-link">Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-scrollable">
            
            <div class="page-header">
                <h2>
                    <img src="assets/img/bullet-list.png" class="header-icon">
                    Clients
                </h2>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon-circle green-bg">
                        <img src="assets/img/customer.png" alt="Users">
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Total Customers</span>
                        <div class="stat-number">5,423</div>
                        <div class="stat-trend trend-up">
                            <img src="assets/img/fleche_haut.png" alt="Up">
                            <span>16%</span> this month
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-circle green-light-bg">
                        <img src="assets/img/member.png" alt="Members">
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Members</span>
                        <div class="stat-number">1,893</div>
                        <div class="stat-trend trend-down">
                            <img src="assets/img/fleche_bas.png" alt="Down">
                            <span>1%</span> this month
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-circle green-light-bg">
                        <img src="assets/img/active.png" alt="Active">
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Active Now</span>
                        <div class="stat-number">189</div>
                    </div>
                </div>
            </div>

            <div class="table-card">
                
                <div class="table-header-row">
                    <div class="titles">
                        <h3>Tous les clients</h3>
                        <span class="subtitle">Membres actifs</span>
                    </div>
                    <div class="controls">
                        <div class="small-search">
                            <img src="assets/img/loupe.png" alt="Search">
                            <input type="text" placeholder="Recherche nom, email..." id="table-search">
                        </div>
                        
                        <div class="sort-wrapper">
                            <div class="sort-dropdown" id="sort-btn">
                                <span id="current-sort">Trier par : Plus récent</span>
                                <img src="assets/img/expand.png" alt="Sort" id="sort-arrow" class="chevron-icon">
                            </div>
                            
                            <div class="sort-menu-list" id="sort-menu">
                                <div class="sort-option" data-value="recent">Plus récent</div>
                                <div class="sort-option" data-value="ancien">Plus ancien</div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="clients-table" id="clients-table">
                    <thead>
                        <tr>
                            <th>Nom du client</th>
                            <th>ID</th>
                            <th>Numéro de Tél</th>
                            <th>E-mail</th>
                            <th>ID de la resv</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($clients)): ?>
                            <?php foreach ($clients as $client): ?>
                                <?php 
                                    // Détermine la classe du badge selon le statut
                                    $badgeClass = ($client['statut'] === 'Active') ? 'badge-active' : 'badge-inactive'; 
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($client['nom_complet']) ?></td>
                                    <td><?= htmlspecialchars($client['client_id_ref']) ?></td>
                                    <td><?= htmlspecialchars($client['telephone']) ?></td>
                                    <td><?= htmlspecialchars($client['email']) ?></td>
                                    <td><?= htmlspecialchars($client['reservation_id']) ?></td>
                                    <td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($client['statut']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align:center; padding:20px;">Aucun client trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="table-footer">
                    <span class="entries-info" id="entries-info">Affichage des données</span>
                    <div class="pagination">
                        <button class="page-btn">&lt;</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">&gt;</button>
                    </div>
                </div>

            </div>            

        </div>
    </main>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>