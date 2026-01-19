<?php 
// Logique de compatibilité : on récupère les données du contrôleur
$client = isset($profile) ? $profile : (isset($client) ? $client : []);
// Onglet par défaut
$activeTab = $activeTab ?? 'infos';

require_once __DIR__ . '/layout/header.php'; 
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/param_clients.css">

<style>
    /* --- CORRECTIF DE CENTRAGE --- */
    /* On force le body à se comporter normalement pour cette page */
    body {
        display: block !important; 
        background-color: #f3f4f6; /* Couleur de fond douce */
    }

    /* On cache les barres latérales qui pourraient pousser le contenu */
    .sidebar, .top-bar, .app-container { 
        display: none !important; 
    }
    
    /* Conteneur principal centré */
    .settings-wrapper { 
        max-width: 900px; 
        width: 95%; /* Prend presque toute la largeur sur mobile */
        margin: 40px auto !important; /* LE SECRET : auto à gauche et à droite centre le bloc */
        padding: 0;
        display: block;
        position: relative;
    }

    /* --- VOS STYLES DECO (Adaptés pour éviter les conflits) --- */
    .page-card { 
        background: white; 
        padding: 30px; 
        border-radius: 12px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
    }

    /* Styles des onglets */
    .tabs-menu { display: flex; gap: 20px; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 10px; overflow-x: auto; }
    .tab-link { text-decoration: none; color: #666; font-weight: 500; padding: 10px 5px; border-bottom: 2px solid transparent; transition: all 0.3s; white-space: nowrap; }
    .tab-link:hover { color: #1a5f3d; }
    .tab-link.active { color: #1a5f3d; border-bottom-color: #1a5f3d; }
    
    /* Contenu des onglets */
    .tab-content { display: none; animation: fadeIn 0.4s ease; }
    .tab-content.active-content { display: block; }
    
    /* Formulaires */
    .input-group { margin-bottom: 20px; }
    .input-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #333; }
    .input-icon-wrapper { position: relative; display: flex; align-items: center; }
    .input-img { width: 20px; height: 20px; position: absolute; left: 15px; opacity: 0.6; }
    .input-icon-wrapper input, .input-icon-wrapper select { width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #e1e1e1; border-radius: 8px; font-size: 15px; transition: border 0.3s; }
    .input-icon-wrapper.plain-input input { padding-left: 15px; } 
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { width: 100%; }
    
    /* Boutons */
    .btn-primary { background: #1a5f3d; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s; }
    .btn-primary:hover { background: #144a2f; }
    .btn-outlined { background: transparent; border: 1px solid #1a5f3d; color: #1a5f3d; padding: 8px 15px; border-radius: 6px; cursor: pointer; }
    
    /* Avatar */
    .avatar-circle { width: 100px; height: 100px; border-radius: 50%; overflow: hidden; margin-right: 20px; border: 3px solid #f0f0f0; }
    .photo-section { display: flex; align-items: center; justify-content: space-between; padding: 20px 0; }
    .photo-preview { display: flex; align-items: center; }
    .photo-actions .btn-text { background: none; border: none; cursor: pointer; font-weight: 500; margin-left: 15px; }
    .btn-text.delete { color: #dc2626; }
    .btn-text.update { color: #1a5f3d; }
    
    /* Switchs et autres */
    .switch { position: relative; display: inline-block; width: 50px; height: 26px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: #1a5f3d; }
    input:checked + .slider:before { transform: translateX(24px); }
    .notification-list .notif-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f5f5f5; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .photo-section { flex-direction: column; text-align: center; gap: 15px; } }
</style>

<div class="settings-wrapper">
    
    <div class="page-card">
        
        <?php if (isset($message) && !empty($message)): ?>
            <div class="alert" style="padding: 15px; background: #d1fae5; color: #065f46; border-radius: 6px; margin-bottom: 20px; border: 1px solid #a7f3d0;">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error) || (isset($messageType) && $messageType === 'error')): ?>
            <div class="alert" style="padding: 15px; background: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 20px; border: 1px solid #fecaca;">
                <?= htmlspecialchars($error ?? $message) ?>
            </div>
        <?php endif; ?>

        <h1>Paramètres</h1>

        <div class="tabs-menu">
            <a href="#" class="tab-link active" data-tab="infos" onclick="switchTab(event, 'infos')">Mes informations</a>
            <a href="#" class="tab-link" data-tab="profil" onclick="switchTab(event, 'profil')">Profil</a>
            <a href="#" class="tab-link" data-tab="password" onclick="switchTab(event, 'password')">Mot de passe</a>
            <a href="#" class="tab-link" data-tab="email" onclick="switchTab(event, 'email')">E-mail</a>
            <a href="#" class="tab-link" data-tab="notification" onclick="switchTab(event, 'notification')">Notification</a>
        </div>

        <div id="content-infos" class="tab-content active-content">
            <div class="section-header">
                <h2>Informations du compte</h2>
                <p>Données techniques liées à votre contrat VTC Rentium.</p>
            </div>
            <hr class="divider" style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            
            <div class="profile-form">
                <div class="form-grid">
                    <div class="input-group">
                        <label>ID Client (Unique)</label>
                        <div class="input-icon-wrapper plain-input">
                            <input type="text" value="CUST-<?= htmlspecialchars($client['id_user'] ?? $client['id'] ?? '0000') ?>-XJ" readonly style="background-color: #f9fafb; color: #6b7280;">
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

                <div class="info-box-gdpr" style="margin-top: 20px; padding: 15px; border: 1px solid #eee; border-radius: 8px;">
                    <h3 style="margin-bottom: 10px;">Export des données</h3>
                    <p style="margin-bottom: 15px; color: #666;">Vous pouvez télécharger une copie de vos données personnelles conformément au RGPD.</p>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="action_type" value="export_json">
                        <button type="button" class="btn-outlined" onclick="alert('Fonctionnalité d\'export bientôt disponible.')">Télécharger mes données (JSON)</button>
                    </form>
                </div>
            </div> 
        </div>

        <div id="content-profil" class="tab-content">
            <div class="section-header">
                <h2>Profil</h2>
                <p>Mettez à jour votre photo et vos informations personnelles ici.</p>
            </div>
            <hr class="divider" style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

            <form class="profile-form" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="update_profile" value="1"> 
                <input type="hidden" name="delete_avatar" id="delete_avatar_flag" value="0">

                <div class="form-grid">
                    <div class="input-group">
                        <label>Prénom</label>
                        <div class="input-icon-wrapper plain-input">
                            <input type="text" name="prenom" value="<?= htmlspecialchars($client['prenom'] ?? '') ?>" placeholder="Votre prénom">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Ville</label>
                        <div class="input-icon-wrapper">
                            <img src="<?= BASE_URL ?>/assets/images/home.png" alt="Maison" class="input-img" onerror="this.style.display='none'">
                            <input type="text" name="ville" value="<?= htmlspecialchars($client['ville'] ?? '') ?>" placeholder="ex: Paris">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Code postal</label>
                        <div class="input-icon-wrapper">
                            <img src="<?= BASE_URL ?>/assets/images/home.png" alt="Adresse" class="input-img" onerror="this.style.display='none'">
                            <input type="text" name="code_postal" value="<?= htmlspecialchars($client['code_postal'] ?? '') ?>" placeholder="ex: 75006">
                        </div>
                    </div>
                </div>

                <div class="input-group full-width">
                    <label>Téléphone</label>
                    <div class="input-icon-wrapper">
                        <img src="<?= BASE_URL ?>/assets/images/phone.png" alt="Phone" class="input-img" onerror="this.style.display='none'">
                        <input type="tel" name="telephone" id="input-phone" 
                               value="<?= htmlspecialchars($client['telephone'] ?? '') ?>" 
                               placeholder="0612345678"
                               maxlength="10" 
                               pattern="^0[0-9]{9}$"
                               title="Le numéro doit comporter 10 chiffres et commencer par 0">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Date de naissance</label>
                        <div class="input-icon-wrapper">
                            <img src="<?= BASE_URL ?>/assets/images/cake_birth.png" alt="Date" class="input-img" onerror="this.style.display='none'">
                            <input type="date" name="date_naissance" 
                                   value="<?= htmlspecialchars($client['date_naissance'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Genre</label>
                        <div class="input-icon-wrapper">
                            <?php $genre = $client['genre'] ?? 'Homme'; ?>
                            <img src="<?= BASE_URL ?>/assets/images/<?= $genre === 'Femme' ? 'woman.png' : 'man.png' ?>" 
                                 alt="Genre" class="input-img" id="genre-icon" onerror="this.style.display='none'">
                            <select name="genre" id="genre-select" onchange="updateGenreIcon(this)" style="width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #e1e1e1; border-radius: 8px; background-color: #fff;">
                                <option value="Homme" <?= $genre === 'Homme' ? 'selected' : '' ?>>Homme</option>
                                <option value="Femme" <?= $genre === 'Femme' ? 'selected' : '' ?>>Femme</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="divider" style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

                <div class="photo-section">
                    <div class="photo-info">
                        <h3>Votre photo</h3>
                        <p style="color:#666; font-size:0.9em;">Elle sera mise à jour lorsque vous enregistrerez le profil.</p>
                    </div>
                    <div class="photo-preview">
                        <div class="avatar-circle">
                            <?php 
                                $defaultAvatar = BASE_URL . '/assets/images/Logo App.png';
                                $currentAvatar = !empty($client['avatar_url']) ? BASE_URL . '/' . $client['avatar_url'] : $defaultAvatar;
                            ?>
                            <img src="<?= $currentAvatar ?>" alt="Avatar" id="avatar-preview" style="object-fit:cover; width:100%; height:100%;">
                        </div>
                    </div>
                    <div class="photo-actions">
                        <input type="file" name="avatar" id="real-file-input" style="display: none;" accept="image/*" onchange="previewAvatar(this)">
                        <button type="button" class="btn-text update" onclick="document.getElementById('real-file-input').click();">Choisir une photo</button>
                    </div>
                </div>

                <hr class="divider" style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

                <div class="social-section">
                    <div class="social-label"><h3 style="margin-bottom:15px;">Profils sociaux</h3></div>
                    <div class="social-inputs">
                        <div class="input-group">
                            <label>Facebook</label>
                            <div class="input-icon-wrapper">
                                <img src="<?= BASE_URL ?>/assets/images/facebook.png" alt="FB" class="input-img" onerror="this.style.display='none'">
                                <input type="text" name="facebook" value="<?= htmlspecialchars($client['facebook'] ?? '') ?>" placeholder="facebook.com/votre.profil">
                            </div>
                        </div>
                        <div class="input-group">
                            <label>X (Twitter)</label>
                            <div class="input-icon-wrapper">
                                <img src="<?= BASE_URL ?>/assets/images/twitter.png" alt="X" class="input-img" onerror="this.style.display='none'">
                                <input type="text" name="twitter" value="<?= htmlspecialchars($client['twitter'] ?? '') ?>" placeholder="x.com/votre.profil">
                            </div>
                        </div>
                        <div class="input-group">
                            <label>LinkedIn</label>
                            <div class="input-icon-wrapper">
                                <img src="<?= BASE_URL ?>/assets/images/linkedin.png" alt="IN" class="input-img" onerror="this.style.display='none'">
                                <input type="text" name="linkedin" value="<?= htmlspecialchars($client['linkedin'] ?? '') ?>" placeholder="linkedin.com/in/votre.profil">
                            </div>
                        </div>
                    </div>
                </div>
                 
                <div class="form-actions-right" style="text-align: right; margin-top: 20px;">
                    <button type="submit" class="btn-primary">Enregistrer le profil</button>
                </div>
            </form>
        </div>

        <div id="content-password" class="tab-content">
            <div class="section-header">
                <h2>Sécurité</h2>
                <p>Modifiez votre mot de passe pour sécuriser votre compte.</p>
            </div>
            <hr class="divider" style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            
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

                <div class="form-actions-right" style="text-align: right; margin-top: 20px;">
                    <button type="submit" class="btn-primary" name="update_password">Changer le mot de passe</button>
                </div>
            </form>
        </div>
        
        <div id="content-email" class="tab-content">
            <div class="section-header">
                <h2>Gestion des e-mails</h2>
                <p>Gérez l'adresse de connexion et l'adresse de secours.</p>
            </div>
            <hr class="divider" style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            
            <form class="profile-form" method="POST" action="">
                <input type="hidden" name="update_profile" value="1">
                
                <div class="input-group full-width">
                    <label>Adresse e-mail principale (Connexion)</label>
                    <div class="input-icon-wrapper">
                        <img src="<?= BASE_URL ?>/assets/images/mail.png" class="input-img" onerror="this.style.display='none'">
                        <input type="email" value="<?= htmlspecialchars($client['email'] ?? '') ?>" disabled style="background:#f9fafb;">
                    </div>
                    <p class="input-hint" style="font-size: 12px; color: #888; margin-top: 5px;">L'email principal ne peut pas être modifié ici.</p>
                </div>

                <div class="input-group full-width">
                    <label>Adresse e-mail de secours</label>
                    <div class="input-icon-wrapper">
                        <img src="<?= BASE_URL ?>/assets/images/mail.png" class="input-img" onerror="this.style.display='none'">
                        <input type="email" name="email_secours" value="<?= htmlspecialchars($client['email_secours'] ?? '') ?>" placeholder="ex: secours@gmail.com">
                    </div>
                </div>

                <div class="form-actions-right" style="text-align: right; margin-top: 20px;">
                    <button type="submit" class="btn-primary">Enregistrer les emails</button>
                </div>
            </form>
        </div>

        <div id="content-notification" class="tab-content">
            <div class="section-header">
                <h2>Préférences de contact</h2>
                <p>Choisissez ce que vous souhaitez recevoir.</p>
            </div>
            <hr class="divider" style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            
            <form class="profile-form" method="POST" action="">
                <input type="hidden" name="update_notifications" value="1">
                
                <div class="notification-list">
                    <div class="notif-item">
                        <div class="notif-text">
                            <h4>Notifications par Email</h4>
                            <p style="color:#666; font-size:0.9em;">Recevoir les confirmations de réservation par email.</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="notif_email" value="1" <?= (isset($client['notif_email']) && $client['notif_email'] == 1) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    
                    <div class="notif-item">
                        <div class="notif-text">
                            <h4>Rappels par SMS</h4>
                            <p style="color:#666; font-size:0.9em;">Recevoir un SMS avant le début d'une réservation.</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="notif_sms" value="1" <?= (isset($client['notif_sms']) && $client['notif_sms'] == 1) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="form-actions-right" style="text-align: right; margin-top: 20px;">
                    <button type="submit" class="btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function switchTab(evt, tabName) {
    evt.preventDefault();
    var tabContents = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove("active-content");
        tabContents[i].style.display = "none";
    }
    var tabLinks = document.getElementsByClassName("tab-link");
    for (var i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
    }
    document.getElementById("content-" + tabName).style.display = "block";
    setTimeout(() => {
        document.getElementById("content-" + tabName).classList.add("active-content");
    }, 10);
    evt.currentTarget.classList.add("active");
}

function updateGenreIcon(select) {
    var icon = document.getElementById('genre-icon');
    if(select.value === 'Femme') {
        icon.src = '<?= BASE_URL ?>/assets/images/woman.png';
    } else {
        icon.src = '<?= BASE_URL ?>/assets/images/man.png';
    }
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<script src="<?= BASE_URL ?>/assets/js/p_script.js"></script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>