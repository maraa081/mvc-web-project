<?php 
require_once __DIR__ . '/layout/header.php'; 
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/param_clients.css">

<style>
    .sidebar, .top-bar, .app-container { display: none !important; }
</style>

<div class="settings-wrapper">
    
    <div class="page-card">
        
        <?php if (isset($message)): ?>
            <div class="alert" style="padding: 15px; background: #d1fae5; color: #065f46; border-radius: 6px; margin-bottom: 20px; border: 1px solid #a7f3d0;">
                <?= $message ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert" style="padding: 15px; background: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 20px; border: 1px solid #fecaca;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <h1>Paramètres</h1>

        <div class="tabs-menu">
            <a href="#" class="tab-link <?= $activeTab === 'infos' ? 'active' : '' ?>" data-tab="infos">Mes informations</a>
            <a href="#" class="tab-link <?= $activeTab === 'profil' ? 'active' : '' ?>" data-tab="profil">Profil</a>
            <a href="#" class="tab-link <?= $activeTab === 'password' ? 'active' : '' ?>" data-tab="password">Mot de passe</a>
            <a href="#" class="tab-link <?= $activeTab === 'email' ? 'active' : '' ?>" data-tab="email">E-mail</a>
            <a href="#" class="tab-link <?= $activeTab === 'notification' ? 'active' : '' ?>" data-tab="notification">Notification</a>
        </div>

        <div id="content-infos" class="tab-content <?= $activeTab === 'infos' ? 'active-content' : '' ?>">
            <div class="section-header">
                <h2>Informations du compte</h2>
                <p>Données techniques liées à votre contrat VTC Rentium.</p>
            </div>
            <hr class="divider">
            
            <div class="profile-form">
                <div class="form-grid">
                    <div class="input-group">
                        <label>ID Client (Unique)</label>
                        <div class="input-icon-wrapper plain-input">
                            <input type="text" value="CUST-<?= htmlspecialchars($client['id_user'] ?? '0000') ?>-XJ" readonly style="background-color: #f9fafb; color: #6b7280;">
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Date d'inscription</label>
                        <div class="input-icon-wrapper plain-input">
                            <?php 
                                $dateInscription = 'Date inconnue';
                                if (!empty($client['created_at'])) {
                                    $dateInscription = date('d F Y', strtotime($client['created_at']));
                                } elseif (!empty($client['date_creation'])) {
                                    $dateInscription = date('d F Y', strtotime($client['date_creation']));
                                }
                            ?>
                            <input type="text" value="<?= $dateInscription ?>" readonly style="background-color: #f9fafb; color: #6b7280;">
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
                    
                    <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=settings" style="display:inline;">
                        <input type="hidden" name="action_type" value="export_json">
                        <button type="submit" class="btn-outlined">Télécharger mes données (JSON)</button>
                    </form>
                </div>
            </div> </div>

        <div id="content-profil" class="tab-content <?= $activeTab === 'profil' ? 'active-content' : '' ?>">
            <div class="section-header">
                <h2>Profil</h2>
                <p>Mettez à jour votre photo et vos informations personnelles ici.</p>
            </div>
            <hr class="divider">

            <form class="profile-form" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action_type" value="profil">

                <input type="hidden" name="delete_avatar" id="delete_avatar_flag" value="0">

                <div class="form-grid">
                    <div class="input-group">
                        <label>Ville</label>
                        <div class="input-icon-wrapper">
                            <img src="<?= BASE_URL ?>/assets/images/home.png" alt="Maison" class="input-img">
                            <input type="text" name="ville" value="<?= htmlspecialchars($client['ville'] ?? '') ?>" placeholder="ex: Paris">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Code postal</label>
                        <div class="input-icon-wrapper">
                            <img src="<?= BASE_URL ?>/assets/images/home.png" alt="Adresse" class="input-img">
                            <input type="text" name="code_postal" value="<?= htmlspecialchars($client['code_postal'] ?? '') ?>" placeholder="ex: 75006">
                        </div>
                    </div>
                </div>

                <div class="input-group full-width">
                    <label>Téléphone</label>
                    <div class="input-icon-wrapper">
                        <img src="<?= BASE_URL ?>/assets/images/phone.png" alt="Phone" class="input-img">
                        <input type="tel" name="telephone" value="<?= htmlspecialchars($client['telephone'] ?? '') ?>" placeholder="06 12 34 56 78">
                    </div>
                </div>


                <?php 
                    // Calcul des dates limites
                    $dateAujourdhui = date('Y-m-d'); // Date actuelle (Max)
                    $dateMinimale = date('Y-m-d', strtotime('-95 years')); // Il y a 95 ans (Min)
                ?>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Date de naissance</label>
                        <div class="input-icon-wrapper">
                            <img src="<?= BASE_URL ?>/assets/images/cake_birth.png" alt="Date" class="input-img">
                            
                            <input type="date" 
                                name="date_naissance" 
                                value="<?= htmlspecialchars($client['date_naissance'] ?? '') ?>"
                                max="<?= $dateAujourdhui ?>" 
                                min="<?= $dateMinimale ?>">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Genre</label>
                        <div class="input-icon-wrapper">
                            <img src="<?= BASE_URL ?>/assets/images/<?= ($client['genre'] ?? 'Homme') === 'Femme' ? 'woman.png' : 'man.png' ?>" 
                                 alt="Genre" 
                                 class="input-img" 
                                 id="genre-icon">
                            
                            <select name="genre" id="genre-select" 
                                    style="width: 100%; 
                                           padding: 14px 15px 14px 45px; 
                                           border: 1px solid #e5e7eb; 
                                           border-radius: 8px; 
                                           background-color: #fff; 
                                           outline: none; 
                                           color: #1f2937; 
                                           font-size: 14px; 
                                           cursor: pointer;
                                           height: auto;">
                                <option value="Homme" <?= ($client['genre'] ?? '') === 'Homme' ? 'selected' : '' ?>>Homme</option>
                                <option value="Femme" <?= ($client['genre'] ?? '') === 'Femme' ? 'selected' : '' ?>>Femme</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <div class="photo-section">
                    <div class="photo-info">
                        <h3>Votre photo</h3>
                        <p>Elle sera mise à jour lorsque vous enregistrerez le profil.</p>
                    </div>
                    <div class="photo-preview">
                        <div class="avatar-circle">
                            <?php 
                                $defaultAvatar = BASE_URL . '/assets/images/Logo App.png';
                                $currentAvatar = !empty($client['avatar_url']) 
                                    ? BASE_URL . '/' . $client['avatar_url'] 
                                    : $defaultAvatar;
                            ?>
                            <img src="<?= $currentAvatar ?>" 
                                alt="Avatar" 
                                class="preview-img" 
                                id="avatar-preview" 
                                data-default-src="<?= $defaultAvatar ?>"
                                style="object-fit:cover; width:100%; height:100%;">
                        </div>
                    </div>

                    <div class="photo-actions">
                        <button type="button" class="btn-text delete" id="btn-delete-photo">
                            Supprimer
                        </button>

                        <input type="file" name="avatar_file" id="real-file-input" style="display: none;" accept="image/*">
                        
                        <button type="button" class="btn-text update" onclick="document.getElementById('real-file-input').click();">
                            Choisir une photo
                        </button>
                    </div>
                </div>

                <hr class="divider">

                <div class="social-section">
                    <div class="social-label">
                        <h3>Profils sociaux</h3>
                    </div>
                    <div class="social-inputs">
                        <div class="input-group">
                            <label>Facebook</label>
                            <div class="input-icon-wrapper">
                                <img src="<?= BASE_URL ?>/assets/images/facebook.png" alt="FB" class="input-img">
                                <input type="text" name="facebook" value="<?= htmlspecialchars($client['facebook'] ?? '') ?>" placeholder="facebook.com/votre.profil">
                            </div>
                        </div>

                        <div class="input-group">
                            <label>X (Twitter)</label>
                            <div class="input-icon-wrapper">
                                <img src="<?= BASE_URL ?>/assets/images/twitter.png" alt="X" class="input-img">
                                <input type="text" name="twitter" value="<?= htmlspecialchars($client['twitter'] ?? '') ?>" placeholder="x.com/votre.profil">
                            </div>
                        </div>

                        <div class="input-group">
                            <label>LinkedIn</label>
                            <div class="input-icon-wrapper">
                                <img src="<?= BASE_URL ?>/assets/images/linkedin.png" alt="IN" class="input-img">
                                <input type="text" name="linkedin" value="<?= htmlspecialchars($client['linkedin'] ?? '') ?>" placeholder="linkedin.com/in/votre.profil">
                            </div>
                        </div>
                    </div>
                </div>
                 
                <div class="form-actions-right">
                    <button type="submit" class="btn-primary">Enregistrer le profil</button>
                </div>
            </form>
        </div>

        <div id="content-password" class="tab-content <?= $activeTab === 'password' ? 'active-content' : '' ?>">
            <div class="section-header">
                <h2>Sécurité</h2>
                <p>Modifiez votre mot de passe pour sécuriser votre compte.</p>
            </div>
            <hr class="divider">
            
            <form class="profile-form" method="POST" action="">
                <input type="hidden" name="action_type" value="password">
                
                <div class="input-group full-width">
                    <label>Mot de passe actuel</label>
                    <div class="input-icon-wrapper plain-input">
                        <input type="password" name="old_password" placeholder="•••••••••">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nouveau mot de passe</label>
                        <div class="input-icon-wrapper plain-input">
                            <input type="password" name="new_password" placeholder="8 caractères min.">
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Confirmer le mot de passe</label>
                        <div class="input-icon-wrapper plain-input">
                            <input type="password" name="confirm_password" placeholder="Répéter le mot de passe">
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
                    <button type="submit" class="btn-primary">Changer le mot de passe</button>
                </div>
            </form>
        </div>
        
        <div id="content-email" class="tab-content <?= $activeTab === 'email' ? 'active-content' : '' ?>">
            <div class="section-header">
                <h2>Gestion des e-mails</h2>
                <p>Gérez l'adresse de connexion et l'adresse de secours.</p>
            </div>
            <hr class="divider">
            
            <form class="profile-form" method="POST" action="">
                <input type="hidden" name="action_type" value="email_management">
                
                <div class="input-group full-width">
                    <label>Adresse e-mail principale (Connexion)</label>
                    <div class="input-icon-wrapper">
                        <img src="<?= BASE_URL ?>/assets/images/mail.png" class="input-img">
                        <input type="email" name="email_main" value="<?= htmlspecialchars($client['email']) ?>">
                    </div>
                    <p class="input-hint">Un email de confirmation sera envoyé en cas de modification.</p>
                </div>

                <div class="input-group full-width">
                    <label>Adresse e-mail de secours</label>
                    <div class="input-icon-wrapper">
                        <img src="<?= BASE_URL ?>/assets/images/mail.png" class="input-img">
                        <input type="email" name="email_secours" value="<?= htmlspecialchars($client['email_secours'] ?? '') ?>" placeholder="ex: secours@gmail.com">
                    </div>
                    <p class="input-hint">Utilisée uniquement si vous perdez l'accès à votre boite principale.</p>
                </div>

                <div class="form-actions-right">
                    <button type="submit" class="btn-primary">Enregistrer les emails</button>
                </div>
            </form>
        </div>

        <div id="content-notification" class="tab-content <?= $activeTab === 'notification' ? 'active-content' : '' ?>">
            <div class="section-header">
                <h2>Préférences de contact</h2>
                <p>Choisissez ce que vous souhaitez recevoir.</p>
            </div>
            <hr class="divider">
            
            <form class="profile-form" method="POST" action="">
                <input type="hidden" name="action_type" value="notification">
                
                <div class="notification-list">
                    <div class="notif-item">
                        <div class="notif-text">
                            <h4>Notifications de réservation</h4>
                            <p>Recevoir une alerte quand une voiture est réservée ou rendue.</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="notif_email" <?= ($client['notif_email'] ?? 1) ? 'checked' : '' ?>>
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
                            <input type="checkbox" name="notif_sms" <?= ($client['notif_sms'] ?? 0) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="form-actions-right">
                    <button type="submit" class="btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/p_script.js"></script>

<?php 
require_once __DIR__ . '/layout/footer.php'; 
?>