document.addEventListener('DOMContentLoaded', function() {

    const forms = {
        register: document.getElementById('registerForm'),
        login: document.getElementById('loginForm')
    };

    function setInputError(input, message) {
        const formGroup = input.closest('.form-group');
        let errorDisplay = formGroup.querySelector('.error-msg');
        
        if (!errorDisplay) {
            errorDisplay = document.createElement('small');
            errorDisplay.className = 'error-msg';
            errorDisplay.style.color = '#e11d48';
            errorDisplay.style.fontSize = '0.85rem';
            errorDisplay.style.marginTop = '5px';
            errorDisplay.style.display = 'block';
            formGroup.appendChild(errorDisplay);
        }

        input.style.borderColor = '#e11d48';
        input.style.backgroundColor = '#fff1f2';
        errorDisplay.innerText = message;
        errorDisplay.style.display = 'block';
    }

    function setInputSuccess(input) {
        const formGroup = input.closest('.form-group');
        const errorDisplay = formGroup.querySelector('.error-msg');
        
        input.style.borderColor = '#10b981';
        input.style.backgroundColor = '#fff';
        
        if (errorDisplay) {
            errorDisplay.style.display = 'none';
            errorDisplay.innerText = '';
        }
    }

    const validators = {
        nom: (val) => val.length >= 2 ? null : "2 caractères min.",
        prenom: (val) => val.length >= 2 ? null : "2 caractères min.",
        email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ? null : "Email invalide.",
        password: (val) => val.length >= 8 ? null : "8 caractères min.",
        confirm_password: (val, form) => {
            const pass = form.querySelector('input[name="password"]').value;
            return val === pass ? null : "Mots de passe différents.";
        }
    };

    function validateField(input, form) {
        const name = input.name;
        // LE TRIM EST ICI - C'EST LUI QUI SAUVE LA SITUATION
        const val = input.type === 'checkbox' ? input.checked : input.value.trim();
        
        if (!validators[name]) return true;

        const error = validators[name](val, form);
        if (error) {
            setInputError(input, error);
            return false;
        } else {
            setInputSuccess(input);
            return true;
        }
    }

    // Gestion des événements live
    [forms.register, forms.login].forEach(form => {
        if(!form) return;
        
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input, form));
            input.addEventListener('input', () => {
                if(input.style.borderColor === 'rgb(225, 29, 72)') validateField(input, form);
            });
        });

        form.addEventListener('submit', function(e) {
            let isValid = true;
            inputs.forEach(input => {
                if (!validateField(input, form)) isValid = false;
            });
            
            // Si invalide, on bloque. Sinon, on laisse le PHP prendre le relais.
            if (!isValid) e.preventDefault();
        });
    });
});