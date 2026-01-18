document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.cgu-section');
    const navLinks = document.querySelectorAll('.cgu-nav a');

    window.addEventListener('scroll', () => {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            // Si on a scrollé jusqu'à cette section (avec un petit décalage de 150px)
            if (scrollY >= (sectionTop - 150)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes(current)) {
                link.classList.add('active');
            }
        });
    });
});