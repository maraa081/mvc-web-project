document.addEventListener('DOMContentLoaded', () => {
    
    /* ============================================================
       1. GESTION DES MENUS DÉROULANTS (NOTIFICATIONS & PROFIL)
       ============================================================ */
    
    const notifBtn = document.getElementById('notif-btn');
    const notifMenu = document.getElementById('notif-menu');
    const profileBtn = document.getElementById('user-profile-btn');
    const profileMenu = document.getElementById('user-menu');

    // Fonction pour tout fermer
    function closeAllMenus() {
        if(notifMenu) notifMenu.classList.remove('show');
        if(profileMenu) profileMenu.classList.remove('show');
    }

    // Gestion du clic sur Notifications
    if(notifBtn && notifMenu) {
        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Empêche la fermeture immédiate
            // Ferme l'autre menu s'il est ouvert
            if (profileMenu) profileMenu.classList.remove('show');
            // Bascule le menu notif
            notifMenu.classList.toggle('show');
        });
    }

    // Gestion du clic sur Profil
    if(profileBtn && profileMenu) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            // Ferme l'autre menu s'il est ouvert
            if (notifMenu) notifMenu.classList.remove('show');
            // Bascule le menu profil
            profileMenu.classList.toggle('show');
        });
    }

    // Fermeture des menus si on clique n'importe où ailleurs sur la page
    window.addEventListener('click', (e) => {
        // Si on ne clique ni sur les boutons, ni dans les menus
        if (notifMenu && !notifMenu.contains(e.target) && !notifBtn.contains(e.target) && 
            profileMenu && !profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
            closeAllMenus();
        }
    });

    /* ============================================================
       2. GESTION DES ONGLETS (TABS)
       ============================================================ */
    
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    tabLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            // 1. Visuel des boutons
            tabLinks.forEach(t => t.classList.remove('active'));
            link.classList.add('active');

            // 2. Affichage du contenu
            const targetId = link.getAttribute('data-tab');
            const targetContent = document.getElementById('content-' + targetId);

            // Masquer tout
            tabContents.forEach(content => {
                content.classList.remove('active-content');
            });

            // Afficher le bon
            if (targetContent) {
                targetContent.classList.add('active-content');
            }
        });
    });

    /* ============================================================
       3. GESTION DE LA PHOTO DE PROFIL (UPLOAD & DELETE)
       ============================================================ */
    
    const btnUpdate = document.getElementById('btn-update-photo');
    const btnDelete = document.getElementById('btn-delete-photo');
    const fileInput = document.getElementById('file-upload-input');
    const previewImg = document.getElementById('avatar-preview');
    const headerAvatar = document.getElementById('header-avatar');
    
    // Image par défaut si on supprime
    const defaultImage = "logo App.png";
    const defaultHeaderAvatar = "logo App.png";

    // 1. Clic sur le bouton "Mettre à jour" -> Déclenche l'input caché
    if(btnUpdate && fileInput) {
        btnUpdate.addEventListener('click', () => {
            fileInput.click();
        });
    }

    // 2. Quand un fichier est choisi
    if(fileInput) {
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Mise à jour de l'image centrale
                    if(previewImg) {
                        previewImg.src = e.target.result;
                        previewImg.style.width = "100%";
                        previewImg.style.height = "100%";
                        previewImg.style.objectFit = "cover";
                    }
                    // Mise à jour de l'avatar en haut à droite
                    if(headerAvatar) {
                        headerAvatar.src = e.target.result;
                    }
                };
                
                reader.readAsDataURL(file);
            }
        });
    }

    // 3. Clic sur "Supprimer"
    if(btnDelete) {
        btnDelete.addEventListener('click', () => {
            // Petite confirmation
            if(confirm("Voulez-vous vraiment supprimer votre photo ?")) {
                if(previewImg) {
                    previewImg.src = defaultImage;
                    previewImg.style.width = "30px";
                    previewImg.style.height = "auto";
                }
                if(headerAvatar) {
                    headerAvatar.src = defaultHeaderAvatar;
                }
                if(fileInput) fileInput.value = ""; // Reset du fichier
            }
        });
    }

    /* ============================================================
       4. SIMULATION DE SAUVEGARDE (INPUTS)
       ============================================================ */
    const inputs = document.querySelectorAll('input:not([type="file"])');
    inputs.forEach(input => {
        input.addEventListener('change', (e) => {
            // Petit effet visuel vert pour dire "Sauvegardé"
            const originalBorder = e.target.style.borderColor;
            e.target.style.borderColor = "#10b981"; // Vert
            setTimeout(() => {
                e.target.style.borderColor = originalBorder;
            }, 800);
            console.log(`Champ ${e.target.name || 'inconnu'} sauvegardé.`);
        });
    });

});