// ==========================================
// ATTENDRE QUE LA PAGE SOIT COMPLÈTEMENT CHARGÉE
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Page chargée - JavaScript initialisé');
    
    // ==========================================
    // 1. GALERIE D'IMAGES - CARROUSEL
    // ==========================================
    
    const mainImage = document.getElementById("carousel-main");
    const thumbnails = document.querySelectorAll(".thumb");
    let currentIndex = 0;
    let images = [];
    let autoplayInterval;
    
    // Récupérer toutes les images depuis les miniatures
    thumbnails.forEach((thumb, index) => {
        images.push(thumb.dataset.full);
        
        // Clic sur une miniature
        thumb.addEventListener("click", function() {
            currentIndex = index;
            updateImage();
            resetAutoplay(); // Redémarrer l'autoplay
        });
    });
    
    // Fonction pour mettre à jour l'image principale
    function updateImage() {
        if (mainImage && images.length > 0) {
            mainImage.src = images[currentIndex];
            
            // Mettre à jour les miniatures (active/inactive)
            thumbnails.forEach((thumb, index) => {
                if (index === currentIndex) {
                    thumb.classList.add("active");
                } else {
                    thumb.classList.remove("active");
                }
            });
        }
    }
    
    // AUTOPLAY - Changer d'image automatiquement toutes les 3 secondes
    function startAutoplay() {
        autoplayInterval = setInterval(function() {
            currentIndex = (currentIndex + 1) % images.length;
            updateImage();
        }, 6000);
    }
    
    // Redémarrer l'autoplay (après un clic manuel)
    function resetAutoplay() {
        clearInterval(autoplayInterval);
        startAutoplay();
    }
    
    // Démarrer l'autoplay au chargement
    if (images.length > 0) {
        startAutoplay();
        console.log('🎬 Autoplay activé - ' + images.length + ' images');
    }
        
    // ==========================================
    // 3. BOUTON "RENT A CAR" - MODAL
    // ==========================================
    
    const btnRentCar = document.getElementById('btnRentCar');
    
    if (btnRentCar) {
        btnRentCar.addEventListener('click', function() {
            const car = document.querySelector('.image-car-title').textContent;
            const price = document.getElementById('prixParJour').textContent;
             window.location.href = `reservation.html?car=${car}&price=${price}`;
            
            const confirmation = confirm(
                `🚗 Réservation BMW X5\n\n` +
                `📅 Nombre de jours: ${nbJours}\n` +
                `💰 Prix total: ${total}€\n\n` +
                `Voulez-vous confirmer votre réservation?`
            );
            
            if (confirmation) {
                alert('✅ Réservation confirmée!\n\nVous recevrez un email de confirmation sous peu.');
                console.log('✅ Réservation confirmée:', {
                    jours: nbJours,
                    prix: total
                });
            } else {
                console.log('❌ Réservation annulée');
            }
        });
        
        console.log('✅ Bouton Rent a Car initialisé');
    }
    
    
    // ==========================================
    // 4. BOUTONS "VOIR LES DÉTAILS" DES CARTES
    // ==========================================
    
    const btnCards = document.querySelectorAll('.btn-card');
    
    btnCards.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const card = this.closest('.car-card');
            const nomVoiture = card.querySelector('.car-name').textContent;
            const prixVoiture = card.querySelector('.car-price').textContent;
            
            alert(
                `🚗 ${nomVoiture}\n` +
                `💰 ${prixVoiture}\n\n` +
                `Redirection vers la page de détails...`
            );
            
            console.log('🔍 Détails demandés:', nomVoiture, prixVoiture);
            
            // En production, vous redirigeriez vers une page de détails :
            // window.location.href = 'details.html?voiture=' + nomVoiture;
        });
    });
    
    if (btnCards.length > 0) {
        console.log(`✅ ${btnCards.length} boutons "Voir les détails" initialisés`);
    }
    
    
    // ==========================================
    // 5. SMOOTH SCROLL (Navigation fluide)
    // ==========================================
    
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Si c'est un lien vers une ancre (#)
            if (href.startsWith('#')) {
                e.preventDefault();
                
                const targetId = href.substring(1); // Enlever le #
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    console.log('📜 Scroll vers:', targetId);
                }
            }
        });
    });
    
    console.log('✅ Smooth scroll initialisé');
    
    
    // ==========================================
    // 6. EFFET HOVER SUR LES MINIATURES
    // ==========================================
    
    thumbnails.forEach(function(thumb) {
        thumb.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        thumb.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    
    // ==========================================
    // 7. ANIMATION AU SCROLL (Fade-in)
    // ==========================================
    
    const carCards = document.querySelectorAll('.car-card');
    
    // Observer pour détecter quand les cartes entrent dans la vue
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target); // Ne plus observer après l'animation
            }
        });
    }, observerOptions);
    
    // Observer toutes les cartes
    carCards.forEach(function(card) {
        observer.observe(card);
    });
    
    console.log('✅ Animations au scroll initialisées');
    
    
    // ==========================================
    // 8. GESTION DES ERREURS D'IMAGES
    // ==========================================
    
    const allImages = document.querySelectorAll('img');
    
    allImages.forEach(function(img) {
        img.addEventListener('error', function() {
            console.warn('⚠️ Image non trouvée:', this.src);
            this.style.background = '#f0f0f0';
            this.alt = 'Image non disponible';
        });
    });
    
    
    // ==========================================
    // CONSOLE - RÉCAPITULATIF
    // ==========================================
    
    console.log('='.repeat(50));
    console.log('✅ JavaScript complètement chargé !');
    console.log('📊 Statistiques:');
    console.log(`   - ${images.length} images dans le carrousel`);
    console.log(`   - ${carCards.length} voitures affichées`);
    console.log(`   - ${navLinks.length} liens de navigation`);
    console.log('='.repeat(50));
    
}); // Fin du DOMContentLoaded