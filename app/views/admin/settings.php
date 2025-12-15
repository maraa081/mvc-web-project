<?php
$pageCss = ['param_clients.css'];
$pageJs  = ['p_script.js'];

ob_start();
?>

<div class="page-card">
    <h1>Paramètres</h1>

    <div class="tabs-menu">
        <a href="#" class="tab-link" data-tab="infos">Mes informations</a>
        <a href="#" class="tab-link active" data-tab="profil">Profil</a>
        <a href="#" class="tab-link" data-tab="password">Mot de passe</a>
        <a href="#" class="tab-link" data-tab="email">E-mail</a>
        <a href="#" class="tab-link" data-tab="notification">Notification</a>
    </div>

    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTC Rentium - Paramètres</title>
    <link rel="stylesheet" href="param_clients.css">
</head>
<body>

<div class="app-container">
    
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo-area">
                <img src="img/Logo App.png" alt="Logo VTC" class="logo-img">
                <span class="brand-name">VTC Rentium</span>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="#">
                            <img src="img/dashboard.png" alt="Dashboard" class="nav-icon">
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="img/wheel.png" alt="Véhicules" class="nav-icon">
                            Véhicules
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="img/car.png" alt="Réservations" class="nav-icon">
                            Réservations
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="img/calendar.png" alt="Calendrier" class="nav-icon">
                            Calendrier
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <a href="#" class="nav-link active-settings">
                <img src="img/paramètre.png" alt="Paramètres" class="nav-icon">
                Paramètres
            </a>
        </div>
    </aside>

    <main class="main-content">
        
        <header class="top-bar">
            <div class="search-wrapper">
                <img src="img/loupe.png" alt="Recherche" class="search-icon">
                <input type="text" placeholder="Recherche">
            </div>
            
            <div class="user-actions">
                
                <div class="action-container">
                    <button class="notif-btn" id="notif-btn">
                        <img src="img/cloche.png" alt="Notifications" class="icon-img">
                    </button>
                    
                    <div class="dropdown-menu notif-dropdown" id="notif-menu">
                        <div class="dropdown-header">Notifications</div>
                        <div class="dropdown-content empty-state">
                            <p>Aucune nouvelle notification.</p>
                        </div>
                    </div>
                </div>

                <div class="action-container">
                    <div class="user-profile" id="user-profile-btn">
                        <img src="img/Logo App.png" alt="Avatar" class="avatar-img" id="header-avatar">
                        <span>Nom du Client</span>
                        <img src="img/arrow.png" alt="Menu" class="dropdown-icon">
                    </div>

                    <div class="dropdown-menu profile-dropdown" id="user-menu">
                        <ul>
                            <li><a href="#">Mon Profil</a></li>
                            <li><a href="#">Paramètres</a></li>
                            <li class="divider-li"></li>
                            <li><a href="#" class="logout-link">Déconnexion</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </header>

        <div class="content-scrollable">
            <div class="page-card">
                <h1>Paramètres</h1>

                <div class="tabs-menu">
                    <a href="#" class="tab-link" data-tab="infos">Mes informations</a>
                    <a href="#" class="tab-link active" data-tab="profil">Profil</a>
                    <a href="#" class="tab-link" data-tab="password">Mot de passe</a>
                    <a href="#" class="tab-link" data-tab="email">E-mail</a>
                    <a href="#" class="tab-link" data-tab="notification">Notification</a>
                </div>

                <div id="content-infos" class="tab-content">
                    <div class="section-header">
                        <h2>Informations du compte</h2>
                        <p>Données techniques liées à votre contrat VTC Rentium.</p>
                    </div>
                    <hr class="divider">
                    
                    <form class="profile-form">
                        <div class="form-grid">
                            <div class="input-group">
                                <label>ID Client (Unique)</label>
                                <div class="input-icon-wrapper plain-input">
                                    <input type="text" value="CUST-8842-XJ" readonly style="background-color: #f9fafb; color: #6b7280;">
                                </div>
                            </div>
                            <div class="input-group">
                                <label>Date d'inscription</label>
                                <div class="input-icon-wrapper plain-input">
                                    <input type="text" value="12 Janvier 2023" readonly style="background-color: #f9fafb; color: #6b7280;">
                                </div>
                            </div>
                        </div>

                        <div class="input-group full-width">
                            <label>Type de contrat</label>
                            <div class="input-icon-wrapper plain-input">
                                <input type="text" value="Premium - Location Longue Durée" readonly style="background-color: #f9fafb; color: #6b7280;">
                            </div>
                        </div>

                        <div class="info-box-gdpr">
                            <h3>Export des données</h3>
                            <p>Vous pouvez télécharger une copie de vos données personnelles conformément au RGPD.</p>
                            <button class="btn-outlined">Télécharger mes données (JSON)</button>
                        </div>
                    </form>
                </div>

                <div id="content-profil" class="tab-content active-content">
                    <div class="section-header">
                        <h2>Profil</h2>
                        <p>Mettez à jour votre photo et vos informations personnelles ici.</p>
                    </div>

                    <hr class="divider">

                    <form class="profile-form">
                        
                        <div class="form-grid">
                            <div class="input-group">
                                <label>Lieu de résidence</label>
                                <div class="input-icon-wrapper">
                                    <img src="img/home.png" alt="Maison" class="input-img">
                                    <input type="text" value="Paris, 75001">
                                </div>
                            </div>

                            <div class="input-group">
                                <label>Adresse postale</label>
                                <div class="input-icon-wrapper">
                                    <img src="img/home.png" alt="Adresse" class="input-img">
                                    <input type="text" value="75001">
                                </div>
                            </div>
                        </div>

                        <div class="input-group full-width">
                            <label>Adresse e-mail</label>
                            <div class="input-icon-wrapper">
                                <img src="img/mail.png" alt="Email" class="input-img">
                                <input type="email" value="client@example.com">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="input-group">
                                <label>Date de naissance</label>
                                <div class="input-icon-wrapper">
                                    <img src="img/cake_birth.png" alt="Date" class="input-img">
                                    <input type="text" value="15/05/1990">
                                </div>
                            </div>

                            <div class="input-group">
                                <label>Genre</label>
                                <div class="input-icon-wrapper">
                                    <img src="img/man.png" alt="Genre" class="input-img">
                                    <input type="text" value="Homme">
                                </div>
                            </div>
                        </div>


                        <hr class="divider">

                        <div class="photo-section">
                            <div class="photo-info">
                                <h3>Votre photo</h3>
                                <p>Elle sera affichée sur votre profil.</p>
                            </div>
                            <div class="photo-preview">
                                <div class="avatar-circle">
                                    <img src="img/Logo App.png" alt="Logo VTC" class="preview-img" id="avatar-preview">
                                </div>
                            </div>
                            <div class="photo-actions">
                                <button type="button" class="btn-text delete" id="btn-delete-photo">Supprimer</button>
                                <input type="file" id="file-upload-input" style="display: none;" accept="image/*">
                                <button type="button" class="btn-text update" id="btn-update-photo">Mettre à jour</button>
                            </div>
                        </div>

                        <hr class="divider">

                        <div class="social-section">
                            <div class="social-label">
                                <h3>Profils sociaux</h3>
                            </div>
                            <div class="social-inputs">
                                <div class="input-group">
                                    <div class="input-icon-wrapper plain-input">
                                        <input type="text" value="facebook.com/">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-icon-wrapper plain-input">
                                        <input type="text" value="twitter.com/">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="content-password" class="tab-content">
                    <div class="section-header">
                        <h2>Sécurité</h2>
                        <p>Modifiez votre mot de passe pour sécuriser votre compte.</p>
                    </div>
                    <hr class="divider">
                    
                    <form class="profile-form">
                        <div class="input-group full-width">
                            <label>Mot de passe actuel</label>
                            <div class="input-icon-wrapper plain-input">
                                <input type="password" placeholder="•••••••••">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="input-group">
                                <label>Nouveau mot de passe</label>
                                <div class="input-icon-wrapper plain-input">
                                    <input type="password" placeholder="8 caractères min.">
                                </div>
                            </div>
                            <div class="input-group">
                                <label>Confirmer le mot de passe</label>
                                <div class="input-icon-wrapper plain-input">
                                    <input type="password" placeholder="Répéter le mot de passe">
                                </div>
                            </div>
                        </div>

                        <div class="password-requirements">
                            <h4>Exigences de sécurité :</h4>
                            <ul>
                                <li>Au moins 8 caractères</li>
                                <li>Au moins une majuscule et un chiffre</li>
                            </ul>
                        </div>

                        <div class="form-actions-right">
                            <button class="btn-primary">Changer le mot de passe</button>
                        </div>
                    </form>
                </div>

                <div id="content-email" class="tab-content">
                    <div class="section-header">
                        <h2>Gestion des E-mails</h2>
                        <p>Gérez l'adresse de connexion et l'adresse de secours.</p>
                    </div>
                    <hr class="divider">
                    
                    <form class="profile-form">
                        <div class="input-group full-width">
                            <label>Adresse e-mail principale (Connexion)</label>
                            <div class="input-icon-wrapper">
                                <img src="img/mail.png" class="input-img">
                                <input type="email" value="vtcrentium@gmail.com">
                            </div>
                            <p class="input-hint">Un email de confirmation sera envoyé en cas de modification.</p>
                        </div>

                        <div class="input-group full-width">
                            <label>Adresse e-mail de secours</label>
                            <div class="input-icon-wrapper">
                                <img src="img/mail.png" class="input-img">
                                <input type="email" placeholder="ex: secours@gmail.com">
                            </div>
                            <p class="input-hint">Utilisée uniquement si vous perdez l'accès à votre boite principale.</p>
                        </div>

                        <div class="form-actions-right">
                            <button class="btn-primary">Enregistrer les emails</button>
                        </div>
                    </form>
                </div>

                <div id="content-notification" class="tab-content">
                    <div class="section-header">
                        <h2>Préférences de contact</h2>
                        <p>Choisissez ce que vous souhaitez recevoir.</p>
                    </div>
                    <hr class="divider">
                    
                    <div class="notification-list">
                        <div class="notif-item">
                            <div class="notif-text">
                                <h4>Notifications de réservation</h4>
                                <p>Recevoir une alerte quand une voiture est réservée ou rendue.</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="notif-item">
                            <div class="notif-text">
                                <h4>Alertes de sécurité</h4>
                                <p>Connexions suspectes ou changement de mot de passe.</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked disabled> <span class="slider round disabled"></span>
                            </label>
                        </div>
                        <div class="notif-item">
                            <div class="notif-text">
                                <h4>Offres commerciales & News</h4>
                                <p>Codes promo et nouveautés sur la flotte VTC.</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="notif-item">
                            <div class="notif-text">
                                <h4>Rappels par SMS</h4>
                                <p>Recevoir un SMS 1h avant le début d'une réservation.</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
<script src="p_script.js"></script>
</body>
</html>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout/admin.php';
