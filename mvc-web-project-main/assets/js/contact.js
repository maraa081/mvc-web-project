document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('subject-select');
    const fieldResa = document.getElementById('field-reservation');
    const fieldComp = document.getElementById('field-company');

    select.addEventListener('change', function() {
        // 1. On cache tout d'abord
        fieldResa.style.display = 'none';
        fieldComp.style.display = 'none';

        // 2. On affiche selon le choix
        if(this.value === 'reservation') {
            fieldResa.style.display = 'block';
            fieldResa.classList.add('fade-in');
        } 
        else if(this.value === 'partenaire') {
            fieldComp.style.display = 'block';
            fieldComp.classList.add('fade-in');
        }
    });
});