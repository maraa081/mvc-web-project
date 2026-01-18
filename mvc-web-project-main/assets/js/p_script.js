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
       3. GESTION DE LA PHOTO DE PROFIL 
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



    // --- 3. VALIDATION DU FORMULAIRE (TEMPS RÉEL) ---
    const form = document.getElementById('settingsForm');
    
    // Inputs à vérifier
    const inputs = {
        email: document.getElementById('input-email'),
        phone: document.getElementById('input-phone'),
        newPass: document.getElementById('input-new-pass'),
        confirmPass: document.getElementById('input-confirm-pass')
    };

    // Fonction générique pour attacher les événements
    function attachLiveValidation(input, validatorFn) {
        if(!input) return;
        
        // Vérifie quand on quitte le champ (blur)
        input.addEventListener('blur', () => validatorFn(input));
        
        // Vérifie pendant la frappe (input) pour enlever l'erreur si corrigé
        input.addEventListener('input', () => {
            // Si le champ est déjà en erreur, on revérifie tout de suite pour enlever le rouge
            if(input.parentElement.classList.contains('error')) {
                validatorFn(input);
            }
        });
    }

    // Attacher les écouteurs
    attachLiveValidation(inputs.email, validateEmail);
    attachLiveValidation(inputs.phone, validatePhone);
    
    // Cas spécial pour les mots de passe (on doit vérifier les deux ensemble)
    if(inputs.newPass && inputs.confirmPass) {
        inputs.newPass.addEventListener('input', () => {
            if(inputs.newPass.value !== "") validatePassword(inputs.newPass, inputs.confirmPass);
            else setSuccess(inputs.newPass); // Reset si vide
        });
        inputs.confirmPass.addEventListener('input', () => {
            if(inputs.newPass.value !== "") validatePassword(inputs.newPass, inputs.confirmPass);
        });
    }

    // Validation à la soumission (Bloque l'envoi si erreur)
    if(form) {
        form.addEventListener('submit', (e) => {
            let isValid = true;

            if (!validateEmail(inputs.email)) isValid = false;
            if (!validatePhone(inputs.phone)) isValid = false;

            if (inputs.newPass && inputs.newPass.value.trim() !== "") {
                if (!validatePassword(inputs.newPass, inputs.confirmPass)) isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll vers la première erreur
                const firstError = document.querySelector('.form-group.error');
                if(firstError) firstError.scrollIntoView({behavior: 'smooth', block: 'center'});
            }
        });
    }

    // --- FONCTIONS DE VALIDATION ---

    function setError(input, message) {
        const formGroup = input.closest('.input-group') || input.parentElement;
        let small = formGroup.parentElement.querySelector('.error-msg'); 
        // Note: Dans votre HTML, le <small> est APRES le .input-group, donc on remonte au parent
        
        if(!small) {
            // Fallback si la structure HTML est différente
            small = formGroup.querySelector('.error-msg');
        }

        if(!small) {
            // Création dynamique si inexistant
            small = document.createElement('small');
            small.className = 'error-msg';
            small.style.color = '#e11d48';
            small.style.fontSize = '0.85rem';
            small.style.marginTop = '5px';
            small.style.display = 'block';
            formGroup.parentNode.insertBefore(small, formGroup.nextSibling);
        }
        
        small.innerText = message;
        small.style.opacity = "1";
        
        // Bordure rouge sur l'input
        input.style.borderColor = "#e11d48";
        input.style.backgroundColor = "#fff1f2";
    }

    function setSuccess(input) {
        const formGroup = input.closest('.input-group') || input.parentElement;
        let small = formGroup.parentElement.querySelector('.error-msg');
        if(!small) small = formGroup.querySelector('.error-msg');
        
        if(small) {
            small.innerText = '';
            small.style.opacity = "0";
        }

        input.style.borderColor = "#10b981"; // Vert
        input.style.backgroundColor = "#fff";
    }

    // Validation EMAIL (Regex stricte)
    function validateEmail(input) {
        if(!input) return true;
        const val = input.value.trim();
        
        // Regex standard pour email : texte + @ + texte + . + texte (2-4 chars)
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (val === '') {
            setError(input, 'L\'adresse email est obligatoire.');
            return false;
        } else if (!re.test(val)) {
            setError(input, 'Format invalide (ex: nom@domaine.com)');
            return false;
        } else {
            setSuccess(input);
            return true;
        }
    }

    // Validation TÉLÉPHONE (10 chiffres, commence par 0)
    function validatePhone(input) {
        if(!input) return true;
        const val = input.value.trim();
        const re = /^0[0-9]{9}$/;

        if (val !== '' && !re.test(val)) {
            setError(input, 'Le numéro doit commencer par 0 et avoir 10 chiffres.');
            return false;
        } else {
            if(val !== '') setSuccess(input); // Vert seulement si rempli
            else { // Si vide et optionnel, on reset le style
                input.style.borderColor = "#e5e7eb";
                input.style.backgroundColor = "#fff";
            }
            return true;
        }
    }

    // Validation MOT DE PASSE
    function validatePassword(pass1, pass2) {
        if(!pass1 || !pass2) return true;
        
        const val1 = pass1.value;
        const val2 = pass2.value;
        let valid = true;

        // Si champ vide, on reset
        if(val1 === "") {
            setSuccess(pass1);
            setSuccess(pass2);
            return true;
        }

        // Règle : 8 caractères minimum
        if (val1.length < 8) {
            setError(pass1, '8 caractères minimum requis.');
            valid = false;
        } 
        // Règle : Au moins un chiffre
        else if (!/[0-9]/.test(val1)) {
            setError(pass1, 'Le mot de passe doit contenir un chiffre.');
            valid = false;
        }
        else {
            setSuccess(pass1);
        }

        // Confirmation
        if (val1 !== val2) {
            setError(pass2, 'Les mots de passe ne correspondent pas.');
            valid = false;
        } else if(val1 !== "") {
            setSuccess(pass2);
        }

        return valid;
    }

    // --- ATTACHEMENT DES ÉVÉNEMENTS (Live Validation) ---

    function attachListeners(input, validator) {
        if(!input) return;
        
        // Validation quand on quitte le champ
        input.addEventListener('blur', () => validator(input));
        
        // Validation pendant la frappe (pour enlever l'erreur)
        input.addEventListener('input', () => {
            // On valide en live seulement si le champ était déjà en erreur pour ne pas agresser le user
            if(input.style.borderColor === 'rgb(225, 29, 72)') { // Couleur rouge #e11d48
                validator(input);
            }
        });
    }

    attachListeners(inputs.email, validateEmail);
    attachListeners(inputs.phone, validatePhone);

    // Pour les mots de passe, c'est spécial (liés)
    if(inputs.newPass && inputs.confirmPass) {
        inputs.newPass.addEventListener('input', () => validatePassword(inputs.newPass, inputs.confirmPass));
        inputs.confirmPass.addEventListener('input', () => validatePassword(inputs.newPass, inputs.confirmPass));
    }

    // --- INTERCEPTION DU SUBMIT ---
    
    // Fonction générique pour bloquer l'envoi si erreur
    function handleFormSubmit(e, formInputs) {
        let isValid = true;

        // Vérif Email si présent dans ce formulaire
        if (formInputs.email && document.contains(formInputs.email)) {
            if (!validateEmail(formInputs.email)) isValid = false;
        }

        // Vérif Tel si présent
        if (formInputs.phone && document.contains(formInputs.phone)) {
            if (!validatePhone(formInputs.phone)) isValid = false;
        }

        // Vérif Passwords si présents
        if (formInputs.newPass && document.contains(formInputs.newPass)) {
            // On ne valide que si l'utilisateur a écrit quelque chose
            if(formInputs.newPass.value.trim() !== "") {
                if (!validatePassword(formInputs.newPass, formInputs.confirmPass)) isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault(); // STOP !
            // Petit effet visuel pour dire "Regarde les erreurs"
            const errorElement = document.querySelector('.error-msg[style*="opacity: 1"]');
            if(errorElement) errorElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    }

    // On attache la validation au submit de chaque formulaire s'il existe
    if(settingsForm) settingsForm.addEventListener('submit', (e) => handleFormSubmit(e, inputs));
    if(emailForm) emailForm.addEventListener('submit', (e) => handleFormSubmit(e, inputs));
    if(profileForm) profileForm.addEventListener('submit', (e) => handleFormSubmit(e, inputs));

