<?php
$pageCss = ['auth.css'];
$pageJs  = ['auth.js'];
require __DIR__ . '/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-wrapper">

        <div class="auth-box">
            <div class="auth-header">
                <h1>Inscription</h1>
                <p>Créez votre compte pour commencer</p>
            </div>

            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" placeholder="Prénom" required>
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" placeholder="Nom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="exemple@email.com" required>
                </div>

                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="tel" placeholder="+33 6 XX XX XX XX" required>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" placeholder="Minimum 8 caractères" required>
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" required>
                </div>

                <label class="checkbox-label">
                    <input type="checkbox" required>
                    <span>J'accepte les conditions</span>
                </label>

                <button type="submit" class="btn-submit">S'inscrire</button>

                <div class="divider"><span>OU</span></div>

                <button type="button" class="btn-google">
                    <img src="https://www.google.com/favicon.ico" width="20">
                    Continuer avec Google
                </button>

                <p class="switch-form">
                    Déjà un compte ?
                    <a href="<?= BASE_URL ?>/public/index.php?page=login">Connectez-vous</a>
                </p>
            </form>
        </div>

        <div class="auth-image">
            <div class="image-overlay">
                <h2>Rejoignez VTC Rentium</h2>
                <p>Accédez à nos services premium</p>
                <div class="features">
                    <div class="feature-item"><span>✓</span> Inscription rapide</div>
                    <div class="feature-item"><span>✓</span> Gestion simplifiée</div>
                    <div class="feature-
