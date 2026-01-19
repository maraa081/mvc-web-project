<?php
$pageCss = ['auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Inscription Concessionnaire</h1>
                <p>Publiez vos véhicules sur VTC Rentium</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="auth-message error">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="auth-message success">
                    <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/public/index.php?page=register_concessionnaire" id="registerForm" novalidate>

                <input type="hidden" name="csrf_token" 
                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                <div class="form-group">
                    <label>Nom de l'entreprise</label>
                    <input type="text" name="entreprise" required minlength="2">
                </div>

                <div class="form-group">
    <label>SIRET (14 chiffres)</label>
    <input 
        type="text" 
        name="siret" 
        required 
        minlength="14" 
        maxlength="14"
        pattern="[0-9]{14}"
        placeholder="12345678901234">
</div>


<div class="form-group">
    <label>Adresse du concessionnaire *</label>
    <input type="text" 
           name="adresse" 
           id="adresse"
           required 
           minlength="10"
           placeholder="123 rue de la Paix, 75001 Paris">
    <small>Saisissez l'adresse complète</small>
</div>

<!-- Champs cachés pour les coordonnées -->
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

<!-- Bouton de géolocalisation -->
<div class="form-group">
    <button type="button" 
            onclick="geolocateAddress()" 
            class="btn-geolocate">
        📍 Géolocaliser l'adresse
    </button>
    <div id="geo-status" style="margin-top: 10px;"></div>
</div>

<!-- Carte preview (optionnel) -->
<div id="map-preview" style="height: 300px; display: none; margin: 20px 0; border-radius: 8px;"></div>

<!-- Script de géolocalisation -->
<script>
let map = null;
let marker = null;

/**
 * Géolocaliser une adresse avec l'API Nominatim (OpenStreetMap)
 */
async function geolocateAddress() {
    const adresse = document.getElementById('adresse').value.trim();
    const statusDiv = document.getElementById('geo-status');
    
    if (!adresse) {
        statusDiv.innerHTML = '<span style="color: red;">⚠️ Veuillez saisir une adresse</span>';
        return;
    }
    
    statusDiv.innerHTML = '<span style="color: blue;">🔄 Géolocalisation en cours...</span>';
    
    try {
        // Utiliser l'API Nominatim (gratuite)
        const response = await fetch(
            `https://nominatim.openstreetmap.org/search?` +
            `format=json&q=${encodeURIComponent(adresse)}&limit=1`
        );
        
        const data = await response.json();
        
        if (data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);
            
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;
            
            statusDiv.innerHTML = `
                <span style="color: green;">✅ Adresse géolocalisée avec succès !</span><br>
                <small>📍 Coordonnées : ${lat.toFixed(6)}, ${lon.toFixed(6)}</small>
            `;
            
            // Afficher la carte preview
            showMapPreview(lat, lon);
        } else {
            statusDiv.innerHTML = '<span style="color: red;">❌ Adresse introuvable. Vérifiez la saisie.</span>';
        }
    } catch (error) {
        console.error('Erreur géolocalisation:', error);
        statusDiv.innerHTML = '<span style="color: red;">❌ Erreur lors de la géolocalisation</span>';
    }
}

/**
 * Afficher une carte preview avec Leaflet
 */
function showMapPreview(lat, lon) {
    const mapDiv = document.getElementById('map-preview');
    mapDiv.style.display = 'block';
    
    // Initialiser la carte si pas encore fait
    if (!map) {
        map = L.map('map-preview').setView([lat, lon], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        marker = L.marker([lat, lon]).addTo(map);
    } else {
        // Mettre à jour la position
        map.setView([lat, lon], 15);
        marker.setLatLng([lat, lon]);
    }
}
</script>

                <div class="form-group">
                    <label>Email professionnel</label>
                    <input type="email" name="email" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" required minlength="8">
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirm" required minlength="8">
                </div>
                
                <button type="submit" class="btn-submit">Créer mon compte pro</button>

                <p class="switch-form">
                    Vous êtes un client ?
                    <a href="<?= BASE_URL ?>/public/index.php?page=register">Inscription client</a>
                </p>
            </form>
        </div>

        <div class="auth-image">
            <div class="image-overlay">
                <h2>Espace Concessionnaire</h2>
                <p>Publiez vos véhicules et gérez vos annonces</p>
            </div>
        </div>
    </div>
</div>

<?php 
$pageJs = ['auth.js'];
require __DIR__ . '/layout/footer.php'; 
?>
