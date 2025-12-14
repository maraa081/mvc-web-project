<?php
$pageCss = ['reservation.css'];
$pageJs  = ['reservation.js'];
require __DIR__ . '/layout/header.php';
?>

<div class="reservation-container">
    
    <!-- Indicateurs d'étapes -->
    <div class="steps-indicator">
        <div class="step active" data-step="1">
            <div class="step-circle">1</div>
            <span>Détails</span>
        </div>
        <div class="step-line"></div>
        <div class="step" data-step="2">
            <div class="step-circle">2</div>
            <span>Dates</span>
        </div>
        <div class="step-line"></div>
        <div class="step" data-step="3">
            <div class="step-circle">3</div>
            <span>Paiement</span>
        </div>
        <div class="step-line"></div>
        <div class="step" data-step="4">
            <div class="step-circle">4</div>
            <span>Confirmation</span>
        </div>
    </div>

    <!-- Slider -->
    <div class="slider-wrapper">
        <div class="slider-container">

            <!-- SLIDE 1 -->
            <div class="slide active" data-slide="1">
                <div class="slide-content">
                    <div class="slide-header">
                        <h2>🚗 Détails du véhicule</h2>
                        <p>Vérifiez les informations de votre véhicule</p>
                    </div>

                    <div class="car-details-card">
                        <div class="car-image-container">
                            <img src="<?= BASE_URL ?>/assets/images/X5.png" class="car-detail-image">
                        </div>

                        <div class="car-info">
                            <h3 class="car-title">BMW X5</h3>
                            <span class="car-category">🔵 SUV Premium</span>

                            <div class="car-specs-list">
                                <div class="spec-badge">⚙️ Automatique</div>
                                <div class="spec-badge">⛽ Essence</div>
                                <div class="spec-badge">👥 5 Places</div>
                                <div class="spec-badge">❄️ Climatisation</div>
                            </div>

                            <div class="price-display">
                                <span class="price-label">Prix par jour</span>
                                <span class="price-value">25€</span>
                            </div>
                        </div>
                    </div>

                    <button class="btn-next" onclick="nextSlide()">Continuer →</button>
                </div>
            </div>

            <!-- SLIDE 2 -->
            <div class="slide" data-slide="2">
                <div class="slide-content">
                    <div class="slide-header">
                        <h2>📅 Sélection des dates</h2>
                        <p>Choisissez vos dates de location</p>
                    </div>

                    <div class="dates-card">
                        <input type="date" id="startDate">
                        <span>→</span>
                        <input type="date" id="endDate">
                    </div>

                    <div class="buttons-group">
                        <button class="btn-back-slide" onclick="prevSlide()">← Retour</button>
                        <button class="btn-next" onclick="nextSlide()">Continuer →</button>
                    </div>
                </div>
            </div>

            <!-- SLIDE 3 -->
            <div class="slide" data-slide="3">
                <div class="slide-content">
                    <div class="slide-header">
                        <h2>💳 Méthode de paiement</h2>
                    </div>

                    <div class="payment-options">
                        <div class="payment-card active">Carte Visa</div>
                        <div class="payment-card">PayPal</div>
                        <div class="payment-card">Apple Pay</div>
                        <div class="payment-card">Google Pay</div>
                    </div>

                    <div class="buttons-group">
                        <button class="btn-back-slide" onclick="prevSlide()">← Retour</button>
                        <button class="btn-next" onclick="nextSlide()">Continuer →</button>
                    </div>
                </div>
            </div>

            <!-- SLIDE 4 -->
            <div class="slide" data-slide="4">
                <div class="slide-content">
                    <div class="slide-header">
                        <h2>✅ Confirmation</h2>
                    </div>

                    <div class="confirmation-card">
                        <p>BMW X5</p>
                        <p>Merci pour votre réservation</p>
                        <strong>Total : 0€</strong>
                    </div>

                    <button class="btn-confirm" onclick="confirmReservation()">🎉 Confirmer</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
