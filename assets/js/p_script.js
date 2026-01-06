document.addEventListener('DOMContentLoaded', () => {

    /* ============================================================
       1. GESTION DU SOUS-MENU "TOUR DE CONTRÔLE" (SIDEBAR)
       ============================================================ */
    const submenuToggle = document.getElementById('submenu-toggle'); // Le lien
    const dashboardSubmenu = document.getElementById('dashboard-submenu'); // La liste
    const chevronArrow = document.getElementById('chevron-arrow'); // La flèche

    // On vérifie que les éléments existent avant d'ajouter le clic
    if (submenuToggle && dashboardSubmenu) {
        submenuToggle.addEventListener('click', (e) => {
            e.preventDefault(); // Empêche le site de remonter en haut de page
            
            // Affiche ou cache le menu
            dashboardSubmenu.classList.toggle('open');
            
            // Fait tourner la flèche si elle existe
            if (chevronArrow) {
                chevronArrow.classList.toggle('rotate');
            }
        });
    }

    /* ============================================================
       2. MENUS DÉROULANTS (NOTIFICATIONS & PROFIL)
       ============================================================ */
    const notifBtn = document.getElementById('notif-btn');
    const notifMenu = document.getElementById('notif-menu');
    const profileBtn = document.getElementById('profile-btn');
    const profileMenu = document.getElementById('profile-menu');

    // Fonction pour fermer tous les menus
    function closeAllMenus() {
        if (notifMenu) notifMenu.classList.remove('show');
        if (profileMenu) profileMenu.classList.remove('show');
    }

    // Clic sur Notification
    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Empêche la fermeture immédiate
            if (profileMenu) profileMenu.classList.remove('show'); // Ferme l'autre menu
            notifMenu.classList.toggle('show'); // Bascule l'affichage
        });
    }

    // Clic sur Profil
    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (notifMenu) notifMenu.classList.remove('show');
            profileMenu.classList.toggle('show');
        });
    }

    // Clic n'importe où ailleurs sur la page pour fermer
    window.addEventListener('click', () => {
        closeAllMenus();
    });

    /* ============================================================
       3. RECHERCHE DYNAMIQUE (FILTRAGE)
       ============================================================ */
    const searchInput = document.getElementById('table-search');
    const tableRows = document.querySelectorAll('#clients-table tbody tr');

    if (searchInput) {
        searchInput.addEventListener('keyup', (e) => {
            const text = e.target.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.innerText.toLowerCase();
                // Affiche la ligne si elle contient le texte, sinon la cache
                row.style.display = rowText.includes(text) ? '' : 'none';
            });
        });
    }

    /* ============================================================
       4. BADGES ACTIF/INACTIF (INTERACTIF)
       ============================================================ */
    const badges = document.querySelectorAll('.badge');

    badges.forEach(badge => {
        badge.addEventListener('click', () => {
            if (badge.classList.contains('badge-active')) {
                badge.classList.remove('badge-active');
                badge.classList.add('badge-inactive');
                badge.textContent = 'Inactive';
            } else {
                badge.classList.remove('badge-inactive');
                badge.classList.add('badge-active');
                badge.textContent = 'Active';
            }
        });
    });

    /* ============================================================
       5. PAGINATION ET AFFICHAGE DES ENTRÉES (DYNAMIQUE)
       ============================================================ */
    const pageBtns = document.querySelectorAll('.page-btn');
    const entriesInfo = document.getElementById('entries-info');
    const table_Rows = document.querySelectorAll('#clients-table tbody tr'); // On compte les vraies lignes

    // CONFIGURATION : Combien de clients veux-tu par page ?
    const itemsPerPage = 8; 
    const totalEntries = table_Rows.length; // Nombre total de clients dans le HTML

    // Fonction pour mettre à jour le texte
    function updatePaginationText(pageNumber) {
        if (!entriesInfo) return;

        // Calcul mathématique
        // Exemple pour Page 1 : (1 - 1) * 5 + 1 = 1
        // Exemple pour Page 2 : (2 - 1) * 5 + 1 = 6
        const start = (pageNumber - 1) * itemsPerPage + 1;
        
        // La fin est soit (Page * 5), soit le total si on dépasse le total
        let end = pageNumber * itemsPerPage;
        if (end > totalEntries) end = totalEntries;

        // Si le début est plus grand que le total (page vide), on ajuste
        const displayStart = (start > totalEntries) ? totalEntries : start;

        // Mise à jour du texte
        entriesInfo.textContent = `Affichage des données de ${displayStart} à ${end} sur ${totalEntries} entrées`;
    }

    // Gestion du clic sur les boutons
    pageBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const btnText = e.target.textContent.trim();

            // Gestion simple pour les chiffres (on ignore < et > pour cet exemple simple)
            if (!isNaN(btnText)) {
                // 1. Visuel bouton
                pageBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                // 2. Mise à jour du texte
                const pageNum = parseInt(btnText);
                updatePaginationText(pageNum);
            }
        });
    });

    // Initialisation au chargement de la page (Page 1 par défaut)
    updatePaginationText(1);
    
    

    /* ============================================================
       6. GESTION DU TRI (AVEC FLÈCHE QUI TOURNE)
       ============================================================ */
    const sortBtn = document.getElementById('sort-btn');
    const sortMenu = document.getElementById('sort-menu');
    const currentSortLabel = document.getElementById('current-sort');
    const sortOptions = document.querySelectorAll('.sort-option');
    const sortArrow = document.getElementById('sort-arrow'); // La flèche

    // 1. Ouvrir/Fermer le menu de tri au clic
    if (sortBtn && sortMenu) {
        sortBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Bascule l'affichage du menu
            sortMenu.classList.toggle('show');
            
            // Bascule la rotation de la flèche
            if (sortArrow) {
                sortArrow.classList.toggle('rotate');
            }
        });
    }

    // 2. Sélectionner une option
    sortOptions.forEach(option => {
        option.addEventListener('click', (e) => {
            const text = e.target.textContent;
            
            // Mise à jour du texte
            if (currentSortLabel) {
                currentSortLabel.textContent = "Trier par : " + text;
            }
            
            // Fermer le menu
            sortMenu.classList.remove('show');
            
            // Remettre la flèche à l'endroit
            if (sortArrow) sortArrow.classList.remove('rotate');
        });
    });

    // 3. Fermer le menu si on clique ailleurs
    window.addEventListener('click', (e) => {
        if (sortMenu && !sortBtn.contains(e.target)) {
            // Fermer le menu
            sortMenu.classList.remove('show');
            
            // Remettre la flèche à l'endroit
            if (sortArrow) sortArrow.classList.remove('rotate');
        }
        });

});