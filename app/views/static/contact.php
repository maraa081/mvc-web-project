<section class="static-page">
    <div class="container">
        <h1>Contactez-nous</h1>
        <p>Une question ? Une demande spécifique ? Notre équipe est à votre écoute 24h/24 et 7j/7.</p>

        <div class="contact-grid">
            <div class="contact-form-wrapper">
                <form action="#" method="POST" class="contact-form">
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" placeholder="Votre nom" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="votre@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <select id="subject" name="subject">
                            <option value="booking">Réservation</option>
                            <option value="support">Service client</option>
                            <option value="pro">Espace professionnel</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Envoyer le message</button>
                </form>
            </div>

            <div class="contact-info">
                <div class="info-box">
                    <h3>Nos Coordonnées</h3>
                    <ul class="simple-list">
                        <li>📍 <strong>Siège :</strong> 12 Avenue des Champs-Élysées, 75008 Paris</li>
                        <li>📞 <strong>Téléphone :</strong> +33 1 23 45 67 89</li>
                        <li>✉️ <strong>Email :</strong> contact@rentium.fr</li>
                    </ul>
                </div>

                <div class="info-box muted">
                    <h3>Horaires d'ouverture</h3>
                    <p>Notre service de réservation en ligne est ouvert 24h/24.</p>
                    <p>Support téléphonique : Lun-Ven 9h-18h</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .contact-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        margin-top: 30px;
    }
    
    .contact-form-wrapper {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .contact-form .form-group {
        margin-bottom: 20px;
    }

    .contact-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .contact-form input, 
    .contact-form select, 
    .contact-form textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: inherit;
    }

    .btn-submit {
        background-color: #1a5f3d;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-submit:hover {
        background-color: #144a2f;
    }

    .simple-list {
        list-style: none;
        padding: 0;
    }
    
    .simple-list li {
        margin-bottom: 15px;
        font-size: 1.05em;
    }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>