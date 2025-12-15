<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation | Rentium</title>

    <!-- CSS BOOKING UNIQUEMENT -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/booking.css">
</head>

<body class="booking-page">

<div class="reservation-container">

    <!-- STEPS -->
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

    <!-- SLIDER -->
    <div class="slider-wrapper">
        <div class="slider-container">

            <!-- SLIDE 1 -->
            <div class="slide active" data-slide="1">
                <h2>🚗 Détails du véhicule</h2>
                <p>BMW X5</p>
                <button class="btn-next" onclick="nextSlide()">Continuer →</button>
            </div>

            <!-- SLIDE 2 -->
            <div class="slide" data-slide="2">
                <h2>📅 Dates</h2>

                <input type="date" id="startDate">
                <input type="date" id="endDate">

                <p>Jours : <span id="totalDays">0</span></p>
                <p>Total : <span id="totalPrice">0€</span></p>

                <button class="btn-back-slide" onclick="prevSlide()">← Retour</button>
                <button class="btn-next" onclick="nextSlide()">Continuer →</button>
            </div>

            <!-- SLIDE 3 -->
            <div class="slide" data-slide="3">
                <h2>💳 Paiement</h2>

                <button class="btn-back-slide" onclick="prevSlide()">← Retour</button>
                <button class="btn-next" onclick="nextSlide()">Continuer →</button>
            </div>

            <!-- SLIDE 4 -->
            <div class="slide" data-slide="4">
                <h2>✅ Confirmation</h2>
                <button class="btn-confirm" onclick="confirmReservation()">Confirmer</button>
            </div>

        </div>
    </div>

</div>

<!-- MODAL -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <h2>Réservation confirmée 🎉</h2>
        <button onclick="closeModal()">Retour accueil</button>
    </div>
</div>

<!-- JS BOOKING UNIQUEMENT -->
<script src="<?= BASE_URL ?>/assets/js/booking.js"></script>

</body>
</html>
