// auth.js - Version MVC adaptée

// Validation du formulaire d'inscription
function validateRegisterForm(form) {
    const prenom = form.querySelector('input[name="prenom"]').value.trim();
    const nom = form.querySelector('input[name="nom"]').value.trim();
    const email = form.querySelector('input[name="email"]').value.trim();
    const password = form.querySelector('input[name="password"]').value;
    const passwordConfirm = form.querySelector('input[name="password_confirm"]').value;
    const terms = form.querySelector('input[name="terms"]').checked;

    // Validation du prénom et nom
    if (prenom.length < 2) {
        showMessage('Le prénom doit contenir au moins 2 caractères', 'error');
        return false;
    }

    if (nom.length < 2) {
        showMessage('Le nom doit contenir au moins 2 caractères', 'error');
        return false;
    }

    // Validation de l'email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showMessage('Veuillez entrer une adresse email valide', 'error');
        return false;
    }

    // Validation du mot de passe
    if (password.length < 8) {
        showMessage('Le mot de passe doit contenir au moins 8 caractères', 'error');
        return false;
    }

    // Vérification de la correspondance des mots de passe
    if (password !== passwordConfirm) {
        showMessage('Les mots de passe ne correspondent pas', 'error');
        return false;
    }

    // Validation des conditions générales
    if (!terms) {
        showMessage('Vous devez accepter les conditions générales', 'error');
        return false;
    }

    return true;
}

// Validation du formulaire de connexion
function validateLoginForm(form) {
    const email = form.querySelector('input[name="email"]').value.trim();
    const password = form.querySelector('input[name="password"]').value;

    // Validation de l'email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showMessage('Veuillez entrer une adresse email valide', 'error');
        return false;
    }

    // Validation du mot de passe
    if (password.length === 0) {
        showMessage('Veuillez entrer votre mot de passe', 'error');
        return false;
    }

    return true;
}

// Fonction pour afficher les messages
function showMessage(message, type) {
    // Supprimer l'ancien message s'il existe
    const oldMessage = document.querySelector('.auth-message');
    if (oldMessage) {
        oldMessage.remove();
    }

    // Créer le nouveau message
    const messageDiv = document.createElement('div');
    messageDiv.className = `auth-message ${type}`;
    messageDiv.textContent = message;

    // Insérer le message après l'en-tête
    const authBox = document.querySelector('.auth-box');
    const authHeader = authBox.querySelector('.auth-header');
    authHeader.parentNode.insertBefore(messageDiv, authHeader.nextSibling);

    // Supprimer automatiquement après 5 secondes
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Formulaire de connexion
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            if (!validateLoginForm(this)) {
                e.preventDefault();
            }
        });
    }

    // Formulaire d'inscription
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            if (!validateRegisterForm(this)) {
                e.preventDefault();
            }
        });
    }

    // Gestion du bouton Google (optionnel)
    const googleButtons = document.querySelectorAll('.btn-google');
    googleButtons.forEach(button => {
        button.addEventListener('click', function() {
            showMessage('L\'authentification Google n\'est pas encore configurée', 'error');
        });
    });
});