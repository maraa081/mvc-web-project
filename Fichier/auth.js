// auth.js

// Fonction d'inscription
async function register(event) {
    event.preventDefault();
    
    const form = event.target;
    const inputs = form.querySelectorAll('input[type="text"]');
    const prenom = inputs[0].value;
    const nom = inputs[1].value;
    const email = form.querySelector('input[type="email"]').value;
    const passwords = form.querySelectorAll('input[type="password"]');
    const motDePasse = passwords[0].value;
    const confirmerMotDePasse = passwords[1].value;
    const accepteConditions = form.querySelector('input[type="checkbox"]').checked;
    
    // Validation
    if (!accepteConditions) {
        showMessage('Vous devez accepter les conditions générales', 'error');
        return;
    }
    
    if (motDePasse.length < 8) {
        showMessage('Le mot de passe doit contenir au moins 8 caractères', 'error');
        return;
    }
    
    if (motDePasse !== confirmerMotDePasse) {
        showMessage('Les mots de passe ne correspondent pas', 'error');
        return;
    }
    
    // Préparation des données
    const userData = {
        nom: `${prenom} ${nom}`,
        email: email,
        mot_de_passe: motDePasse,
        confirmer_mot_de_passe: confirmerMotDePasse
    };
    
    try {
        const response = await fetch('register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(userData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            showMessage(data.message, 'success');
            setTimeout(() => {
                window.location.href = 'connexion.html';
            }, 2000);
        } else {
            showMessage(data.message, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showMessage('Une erreur est survenue. Vérifiez que le serveur PHP fonctionne.', 'error');
    }
}

// Fonction de connexion
async function login(event) {
    event.preventDefault();
    
    const form = event.target;
    const email = form.querySelector('input[type="email"]').value;
    const motDePasse = form.querySelector('input[type="password"]').value;
    
    // Validation
    if (!email || !motDePasse) {
        showMessage('Veuillez remplir tous les champs', 'error');
        return;
    }
    
    // Préparation des données
    const loginData = {
        email: email,
        mot_de_passe: motDePasse
    };
    
    try {
        const response = await fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(loginData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            showMessage(data.message, 'success');
            localStorage.setItem('user', JSON.stringify(data.user));
            setTimeout(() => {
                window.location.href = 'inedx.php';
            }, 1000);
        } else {
            showMessage(data.message, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showMessage('Une erreur est survenue. Vérifiez que le serveur PHP fonctionne.', 'error');
    }
}

// Fonction pour afficher les messages
function showMessage(message, type) {
    const oldMessage = document.querySelector('.auth-message');
    if (oldMessage) {
        oldMessage.remove();
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `auth-message ${type}`;
    messageDiv.textContent = message;
    
    const authBox = document.querySelector('.auth-box');
    const authHeader = authBox.querySelector('.auth-header');
    authHeader.parentNode.insertBefore(messageDiv, authHeader.nextSibling);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.auth-box form');
    if (loginForm) {
        const pageTitle = document.querySelector('.auth-header h1').textContent;
        
        if (pageTitle === 'Connexion') {
            loginForm.addEventListener('submit', login);
        } else if (pageTitle === 'Inscription') {
            loginForm.addEventListener('submit', register);
        }
    }
});