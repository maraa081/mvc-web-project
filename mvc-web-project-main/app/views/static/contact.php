<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/contact.css">

<div class="contact-hero">
    <div class="container">
        <h1>Contactez-nous</h1>
        <p>Une question ? Un projet ? Notre équipe est à votre écoute.</p>
    </div>
</div>

<div class="container contact-wrapper">
    
    <div class="contact-info">
        <div class="info-card">
            <div class="icon">
                <img src="<?= BASE_URL ?>/assets/images/location.png" alt="Adresse">
            </div>
            <h3>Notre Siège</h3>
            <p>12 Avenue des Champs-Élysées<br>75008 Paris, France</p>
        </div>
        
        <div class="info-card">
            <div class="icon">
                <img src="<?= BASE_URL ?>/assets/images/phone.png" alt="Téléphone">
            </div>
            <h3>Téléphone</h3>
            <p><strong>Service Client :</strong> 01 23 45 67 89<br>
            <span class="sub-text">Du Lundi au Vendredi, 9h-18h</span></p>
        </div>

        <div class="info-card">
            <div class="icon">
                <img src="<?= BASE_URL ?>/assets/images/mail.png" alt="E-mail">
            </div>
            <h3>E-mail</h3>
            <p>support@rentium.com<br>pro@rentium.com</p>
        </div>

        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.142047744348!2d2.292292615554866!3d48.87442277928921!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc4f8f8f8f7%3A0x9876543210!2sChamps-%C3%89lys%C3%A9es!5e0!3m2!1sfr!2sfr!4v1610000000000!5m2!1sfr!2sfr" 
                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </div>

    <div class="contact-form-container">
        <h2>Envoyez-nous un message</h2>
        
        <?php if (isset($message)): ?>
            <div class="alert success"><?= $message ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <form action="index.php?page=contact" method="POST" id="contactForm">
            
            <div class="form-row">
                <div class="form-group">
                    <label>Nom complet *</label>
                    <input type="text" name="nom" required placeholder="Votre nom">
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required placeholder="votre@email.com">
                </div>
            </div>

            <div class="form-group">
                <label>Objet de la demande *</label>
                <select name="sujet" id="subject-select" required>
                    <option value="" disabled selected>Choisissez une option...</option>
                    <option value="info">Demande d'information générale</option>
                    <option value="reservation">Problème avec une réservation</option>
                    <option value="technique">Support Technique (Site web)</option>
                    <option value="partenaire">Devenir Partenaire / Chauffeur</option>
                </select>
            </div>

            <div id="field-reservation" class="dynamic-field" style="display:none;">
                <div class="form-group">
                    <label>Numéro de réservation (ex: #12345)</label>
                    <input type="text" name="ref_booking" placeholder="#...">
                </div>
            </div>

            <div id="field-company" class="dynamic-field" style="display:none;">
                <div class="form-group">
                    <label>Nom de votre société / Statut</label>
                    <input type="text" name="company" placeholder="Ex: VTC Paris Ltd">
                </div>
            </div>

            <div class="form-group">
                <label>Votre message *</label>
                <textarea name="message" rows="5" required placeholder="Dites-nous en plus..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Envoyer le message</button>
        </form>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/contact.js"></script>
