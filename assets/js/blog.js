document.addEventListener('DOMContentLoaded', () => {
    
    // --- GESTION DE LA BARRE DE PROGRESSION ---
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        
        // Sécurité division par zéro
        let scrolled = 0;
        if (height > 0) {
            scrolled = (winScroll / height) * 100;
        }
        
        const progressBar = document.getElementById("progressBar");
        if(progressBar) {
            progressBar.style.width = scrolled + "%";
        }
    });

});

// --- GESTION DES VOTES ---
// Variable globale pour stocker le timer du message (pour pouvoir l'annuler si on reclique vite)
let messageTimeout;

function vote(articleId, type, btnClicked) {
    const msg = document.getElementById('vote-message');
    
    // On désactive temporairement les boutons pour éviter le spam pendant la requête
    const allButtons = document.querySelectorAll('.btn-rate');
    allButtons.forEach(btn => btn.disabled = true);

    fetch('index.php?page=blog_rate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: articleId, type: type })
    })
    .then(response => response.json())
    .then(data => {
        // On réactive les boutons
        allButtons.forEach(btn => btn.disabled = false);

        if (data.status === 'success') {
            // 1. MISE À JOUR VISUELLE (Avec les vrais chiffres de la BDD -> Pas d'infini !)
            document.getElementById('count-like').innerText = data.totals.likes;
            document.getElementById('count-dislike').innerText = data.totals.dislikes;

            // 2. GESTION DES COULEURS DES BOUTONS
            const likeBtn = document.querySelector('.btn-rate.like');
            const dislikeBtn = document.querySelector('.btn-rate.dislike');

            // On reset tout d'abord
            likeBtn.classList.remove('active');
            dislikeBtn.classList.remove('active');

            // On remet la couleur si le vote est actif
            if (data.action !== 'removed') {
                if (type === 'like') likeBtn.classList.add('active');
                else dislikeBtn.classList.add('active');
            }

            // 3. GESTION DU MESSAGE (2 SECONDES)
            // On annule le précédent timer s'il y en a un
            if (messageTimeout) clearTimeout(messageTimeout);

            if (data.action === 'removed') {
                // Si on enlève le vote : PAS DE MESSAGE (ou on l'efface)
                msg.innerText = "";
            } else {
                // Si on ajoute ou change : MESSAGE "MERCI"
                msg.innerText = "Merci pour votre vote !";
                msg.style.color = "#10b981"; // Vert
                msg.style.opacity = "1";

                // Disparaît après 2 secondes
                messageTimeout = setTimeout(() => {
                    msg.style.transition = "opacity 0.5s";
                    msg.style.opacity = "0";
                    // On vide le texte après la transition pour être propre
                    setTimeout(() => { msg.innerText = ""; }, 500);
                }, 2000);
            }

        } else {
            // Erreur (ex: non connecté)
            msg.innerText = data.message;
            msg.style.color = "#ef4444"; // Rouge
            msg.style.opacity = "1";
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        allButtons.forEach(btn => btn.disabled = false);
    });
}