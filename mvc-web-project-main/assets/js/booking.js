// ==========================================
// VARIABLES GLOBALES
// ==========================================

let currentSlide = 1;
let currentPaymentIndex = 0;
const totalSlides = 4;

// Données de réservation
const reservationData = {
    id_annonce: null,
    startDate: "",
    endDate: "",
    totalDays: 0,
    totalPrice: 0,
    pricePerDay: 0,
    paymentMethod: "Carte Visa"
};

// ==========================================
// INITIALISATION AU CHARGEMENT
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Page de réservation chargée');

    // Récupérer l'ID de l'annonce depuis l'input hidden
    const idAnnonceInput = document.getElementById('id_annonce');
    if (idAnnonceInput) {
        reservationData.id_annonce = parseInt(idAnnonceInput.value);
    }

    // Récupérer le prix par jour
    const priceElement = document.getElementById('pricePerDay');
    if (priceElement) {
        reservationData.pricePerDay = parseInt(priceElement.textContent.replace('€', ''));
    }

    // Initialiser les dates
    initializeDates();

    // Écouter les changements de dates
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', calculateTotal);
        endDateInput.addEventListener('change', calculateTotal);
    }

    // Initialiser les cartes de paiement
    initializePaymentCards();

    console.log('📊 Données de réservation:', reservationData);
});

// ==========================================
// GESTION DES DATES
// ==========================================

function initializeDates() {
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    const startInput = document.getElementById('startDate');
    const endInput = document.getElementById('endDate');

    if (!startInput || !endInput) return;

    // Format YYYY-MM-DD
    const todayStr = today.toISOString().split('T')[0];
    const tomorrowStr = tomorrow.toISOString().split('T')[0];

    // Définir les valeurs minimales
    startInput.setAttribute('min', todayStr);
    endInput.setAttribute('min', tomorrowStr);

    console.log('📅 Dates initialisées');
}

function calculateTotal() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (!startDate || !endDate) {
        console.log('⚠️ Dates incomplètes');
        return;
    }

    const start = new Date(startDate);
    const end = new Date(endDate);

    // Calculer la différence en jours
    const diffTime = end - start;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays <= 0) {
        alert('❌ La date de fin doit être après la date de début');
        document.getElementById('endDate').value = '';
        return;
    }

    // Mettre à jour les données
    reservationData.startDate = startDate;
    reservationData.endDate = endDate;
    reservationData.totalDays = diffDays;
    reservationData.totalPrice = diffDays * reservationData.pricePerDay;

    // Afficher les résultats
    const totalDaysElement = document.getElementById('totalDays');
    const totalPriceElement = document.getElementById('totalPrice');

    if (totalDaysElement) {
        totalDaysElement.textContent = diffDays + ' jour(s)';
    }

    if (totalPriceElement) {
        totalPriceElement.textContent = reservationData.totalPrice + '€';
    }

    console.log('💰 Prix calculé:', reservationData.totalPrice + '€ pour ' + diffDays + ' jours');
}

// ==========================================
// NAVIGATION ENTRE LES SLIDES
// ==========================================

function nextSlide() {
    // Validation avant de passer au slide suivant
    if (!validateCurrentSlide()) {
        return;
    }

    if (currentSlide < totalSlides) {
        // Retirer la classe active du slide actuel
        const currentSlideElement = document.querySelector(`.slide[data-slide="${currentSlide}"]`);
        if (currentSlideElement) {
            currentSlideElement.classList.remove('active');
        }

        // Retirer la classe active de l'étape actuelle
        const currentStepElement = document.querySelector(`.step[data-step="${currentSlide}"]`);
        if (currentStepElement) {
            currentStepElement.classList.remove('active');
            currentStepElement.classList.add('completed');
        }

        // Passer au slide suivant
        currentSlide++;

        // Ajouter la classe active au nouveau slide
        const nextSlideElement = document.querySelector(`.slide[data-slide="${currentSlide}"]`);
        if (nextSlideElement) {
            nextSlideElement.classList.add('active');
        }

        // Ajouter la classe active à la nouvelle étape
        const nextStepElement = document.querySelector(`.step[data-step="${currentSlide}"]`);
        if (nextStepElement) {
            nextStepElement.classList.add('active');
        }

        // Décaler le slider
        const sliderContainer = document.querySelector('.slider-container');
        if (sliderContainer) {
            sliderContainer.style.transform = `translateX(-${(currentSlide - 1) * 100}%)`;
        }

        // Si on arrive au slide 4 (confirmation), mettre à jour le récapitulatif
        if (currentSlide === 4) {
            updateConfirmation();
        }

        console.log('➡️ Passage au slide', currentSlide);
    }
}

function prevSlide() {
    if (currentSlide > 1) {
        // Retirer la classe active du slide actuel
        const currentSlideElement = document.querySelector(`.slide[data-slide="${currentSlide}"]`);
        if (currentSlideElement) {
            currentSlideElement.classList.remove('active');
        }

        // Retirer la classe active de l'étape actuelle
        const currentStepElement = document.querySelector(`.step[data-step="${currentSlide}"]`);
        if (currentStepElement) {
            currentStepElement.classList.remove('active');
        }

        // Revenir au slide précédent
        currentSlide--;

        // Ajouter la classe active au slide précédent
        const prevSlideElement = document.querySelector(`.slide[data-slide="${currentSlide}"]`);
        if (prevSlideElement) {
            prevSlideElement.classList.add('active');
        }

        // Ajouter la classe active à l'étape précédente
        const prevStepElement = document.querySelector(`.step[data-step="${currentSlide}"]`);
        if (prevStepElement) {
            prevStepElement.classList.add('active');
            prevStepElement.classList.remove('completed');
        }

        // Décaler le slider
        const sliderContainer = document.querySelector('.slider-container');
        if (sliderContainer) {
            sliderContainer.style.transform = `translateX(-${(currentSlide - 1) * 100}%)`;
        }

        console.log('⬅️ Retour au slide', currentSlide);
    }
}

// ==========================================
// VALIDATION DES SLIDES
// ==========================================

function validateCurrentSlide() {
    switch(currentSlide) {
        case 1:
            // Slide 1 : Toujours valide
            return true;

        case 2:
            // Slide 2 : Vérifier que les dates sont sélectionnées
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            if (!startDate || !endDate) {
                alert('⚠️ Veuillez sélectionner les dates de début et de fin');
                return false;
            }

            if (reservationData.totalDays <= 0) {
                alert('⚠️ Veuillez sélectionner des dates valides');
                return false;
            }

            return true;

        case 3:
            // Slide 3 : Vérifier qu'une méthode de paiement est sélectionnée
            return true;

        default:
            return true;
    }
}

// ==========================================
// CARROUSEL DE PAIEMENT
// ==========================================

function initializePaymentCards() {
    const paymentCards = document.querySelectorAll('.payment-card');

    paymentCards.forEach((card, index) => {
        card.addEventListener('click', function() {
            // Retirer la classe active de toutes les cartes
            paymentCards.forEach(c => c.classList.remove('active'));

            // Ajouter la classe active à la carte cliquée
            this.classList.add('active');

            // Mettre à jour la méthode de paiement
            currentPaymentIndex = index;
            const paymentMethod = this.querySelector('h3').textContent;
            reservationData.paymentMethod = paymentMethod;

            const selectedPaymentTextElement = document.getElementById('selectedPaymentText');
            if (selectedPaymentTextElement) {
                selectedPaymentTextElement.textContent = paymentMethod;
            }

            console.log('💳 Méthode de paiement sélectionnée:', paymentMethod);
        });
    });
}

function nextPayment() {
    const paymentOptions = document.querySelector('.payment-options');
    const paymentCards = document.querySelectorAll('.payment-card');

    if (!paymentOptions || !paymentCards.length) return;

    if (currentPaymentIndex < paymentCards.length - 1) {
        currentPaymentIndex++;

        // Scroll vers la carte suivante
        const cardWidth = paymentCards[0].offsetWidth + 20; // +20 pour le gap
        paymentOptions.scrollLeft = currentPaymentIndex * cardWidth;

        // Activer la carte
        paymentCards.forEach(c => c.classList.remove('active'));
        paymentCards[currentPaymentIndex].classList.add('active');

        const paymentMethod = paymentCards[currentPaymentIndex].querySelector('h3').textContent;
        reservationData.paymentMethod = paymentMethod;

        const selectedPaymentTextElement = document.getElementById('selectedPaymentText');
        if (selectedPaymentTextElement) {
            selectedPaymentTextElement.textContent = paymentMethod;
        }

        console.log('➡️ Méthode suivante:', paymentMethod);
    }
}

function prevPayment() {
    const paymentOptions = document.querySelector('.payment-options');
    const paymentCards = document.querySelectorAll('.payment-card');

    if (!paymentOptions || !paymentCards.length) return;

    if (currentPaymentIndex > 0) {
        currentPaymentIndex--;

        // Scroll vers la carte précédente
        const cardWidth = paymentCards[0].offsetWidth + 20;
        paymentOptions.scrollLeft = currentPaymentIndex * cardWidth;

        // Activer la carte
        paymentCards.forEach(c => c.classList.remove('active'));
        paymentCards[currentPaymentIndex].classList.add('active');

        const paymentMethod = paymentCards[currentPaymentIndex].querySelector('h3').textContent;
        reservationData.paymentMethod = paymentMethod;

        const selectedPaymentTextElement = document.getElementById('selectedPaymentText');
        if (selectedPaymentTextElement) {
            selectedPaymentTextElement.textContent = paymentMethod;
        }

        console.log('⬅️ Méthode précédente:', paymentMethod);
    }
}

// ==========================================
// MISE À JOUR DE LA CONFIRMATION
// ==========================================

function updateConfirmation() {
    // Voiture
    const carNameElement = document.getElementById('carName');
    const confirmCarElement = document.getElementById('confirmCar');
    if (carNameElement && confirmCarElement) {
        confirmCarElement.textContent = carNameElement.textContent;
    }

    // Dates
    if (reservationData.startDate && reservationData.endDate) {
        const startDate = new Date(reservationData.startDate);
        const endDate = new Date(reservationData.endDate);

        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const startStr = startDate.toLocaleDateString('fr-FR', options);
        const endStr = endDate.toLocaleDateString('fr-FR', options);

        const confirmDatesElement = document.getElementById('confirmDates');
        if (confirmDatesElement) {
            confirmDatesElement.textContent = `Du ${startStr} au ${endStr}`;
        }

        const confirmDurationElement = document.getElementById('confirmDuration');
        if (confirmDurationElement) {
            confirmDurationElement.textContent = `${reservationData.totalDays} jour(s)`;
        }
    }

    // Paiement
    const confirmPaymentElement = document.getElementById('confirmPayment');
    if (confirmPaymentElement) {
        confirmPaymentElement.textContent = reservationData.paymentMethod;
    }

    // Total
    const confirmTotalElement = document.getElementById('confirmTotal');
    if (confirmTotalElement) {
        confirmTotalElement.textContent = reservationData.totalPrice + '€';
    }

    console.log('✅ Confirmation mise à jour');
}

// ==========================================
// CONFIRMATION FINALE
// ==========================================

function confirmReservation() {
    console.log('🎉 Tentative de réservation:', reservationData);

    // Validation finale
    if (!reservationData.id_annonce || !reservationData.startDate || !reservationData.endDate) {
        alert("⚠️ Données de réservation incomplètes");
        return;
    }

    // Envoi au serveur
    fetch(`${BASE_URL}/public/index.php?page=booking_store`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            id_annonce: reservationData.id_annonce,
            date_debut: reservationData.startDate,
            date_fin: reservationData.endDate
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('📤 Réponse serveur:', data);

        if (data.success) {
            // Afficher le modal de succès
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.classList.add('show');
            }

            // Générer un numéro de confirmation aléatoire
            const confirmationNumber = 'RNT-' + new Date().getFullYear() + '-' + Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            const confirmationNumberElement = document.querySelector('.confirmation-number strong');
            if (confirmationNumberElement) {
                confirmationNumberElement.textContent = '#' + confirmationNumber;
            }
        } else {
            alert(data.error || "❌ Erreur lors de la réservation");
        }
    })
    .catch(error => {
        console.error('❌ Erreur AJAX:', error);
        alert("❌ Erreur réseau");
    });
}

// ==========================================
// FERMER LE MODAL
// ==========================================

function closeModal() {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.classList.remove('show');
    }

    // Rediriger vers la page d'accueil
    setTimeout(() => {
        window.location.href = `${BASE_URL}/public/index.php?page=home`;
    }, 300);
}

// ==========================================
// RACCOURCIS CLAVIER
// ==========================================

document.addEventListener('keydown', function(e) {
    // Flèche droite = Slide suivant
    if (e.key === 'ArrowRight') {
        if (currentSlide < totalSlides) {
            nextSlide();
        }
    }

    // Flèche gauche = Slide précédent
    if (e.key === 'ArrowLeft') {
        if (currentSlide > 1) {
            prevSlide();
        }
    }

    // Échap = Fermer le modal
    if (e.key === 'Escape') {
        const modal = document.getElementById('successModal');
        if (modal && modal.classList.contains('show')) {
            closeModal();
        }
    }
});

console.log('✅ JavaScript de réservation chargé');
console.log('💡 Astuce: Utilisez les flèches ← → pour naviguer entre les slides');
