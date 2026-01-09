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
            e.stopPropagation(); 
            if (profileMenu) profileMenu.classList.remove('show');
            notifMenu.classList.toggle('show');
        });
    }

    // Gestion du clic sur Profil
    if(profileBtn && profileMenu) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (notifMenu) notifMenu.classList.remove('show');
            profileMenu.classList.toggle('show');
        });
    }

    // Fermeture des menus si on clique ailleurs
    window.addEventListener('click', (e) => {
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
       3. GESTION DE LA PHOTO DE PROFIL (VERSION PHP/MVC)
       ============================================================ */
    
    const fileInput = document.getElementById('real-file-input');
    const previewImg = document.getElementById('avatar-preview');
    const deleteBtn = document.getElementById('btn-delete-photo');
    const deleteFlag = document.getElementById('delete_avatar_flag');

    // A. Prévisualisation de l'image lors de la sélection
    if (fileInput) {
        fileInput.onchange = function (evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function () {
                    if (previewImg) {
                        previewImg.src = fr.result;
                    }
                    // On annule le flag de suppression si on met une nouvelle photo
                    if (deleteFlag) {
                        deleteFlag.value = "0";
                    }
                }
                fr.readAsDataURL(files[0]);
            }
        };
    }

    // B. Gestion du bouton supprimer (visuel + flag)
    if (deleteBtn) {
        deleteBtn.onclick = function() {
            // Remettre l'image par défaut (récupérée via l'attribut data-default-src)
            if (previewImg && previewImg.dataset.defaultSrc) {
                previewImg.src = previewImg.dataset.defaultSrc;
            }

            // Vider l'input file pour ne pas envoyer d'image
            if (fileInput) {
                fileInput.value = "";
            }

            // Activer le flag pour dire au contrôleur de supprimer l'avatar en BDD
            if (deleteFlag) {
                deleteFlag.value = "1";
            }
        };
    }

    /* ============================================================
       4. EFFETS VISUELS INPUTS (Simulation sauvegarde)
       ============================================================ */
    const inputs = document.querySelectorAll('input:not([type="file"])');
    inputs.forEach(input => {
        input.addEventListener('change', (e) => {
            const originalBorder = e.target.style.borderColor;
            e.target.style.borderColor = "#10b981"; // Vert
            setTimeout(() => {
                e.target.style.borderColor = originalBorder;
            }, 800);
        });
    });

    /* ============================================================
       5. AUTO-DISPARITION DES MESSAGES (ALERTS)
       ============================================================ */
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 500);
            });
        }, 2000); // 2 secondes avant de disparaître
    }

});

/* ============================================================
       6. GESTION DU GENRE (ICÔNE DYNAMIQUE)
    ============================================================ */
    const genreSelect = document.getElementById('genre-select');
    const genreIcon = document.getElementById('genre-icon');

    if (genreSelect && genreIcon) {
        genreSelect.addEventListener('change', function() {
            // Récupère le chemin du dossier images (tout ce qui est avant le nom du fichier)
            const basePath = genreIcon.src.substring(0, genreIcon.src.lastIndexOf('/') + 1);
            
            if (this.value === 'Femme') {
                genreIcon.src = basePath + 'woman.png';
            } else {
                genreIcon.src = basePath + 'man.png';
            }
        });
    }