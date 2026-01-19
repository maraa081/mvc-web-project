<?php

class StaticController
{
    public function blog()
    {
        require __DIR__ . '/../views/static/blog.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/static/about.php';
    }

    public function contact()
    {
        ob_start();
        require __DIR__ . '/../views/static/contact.php'; // On charge juste le contenu central
        $content = ob_get_clean(); // On le stocke dans une variable

        // On construit la page complète
        require __DIR__ . '/../views/layout/header.php'; // 1. Le Header
        echo $content;                                   // 2. Le Contenu
        require __DIR__ . '/../views/layout/footer.php'; // 3. Le Footer
    }

    public function faq() {
        // Titre de la page pour le <title> HTML
        $pageTitle = "Foire Aux Questions - Rentium";
        
        ob_start();
        require __DIR__ . '/../views/static/faq.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/layout/header.php';
        echo $content;
        require __DIR__ . '/../views/layout/footer.php';
    }
    
    public function cgu() {
        $pageTitle = "Conditions Générales d'Utilisation - Rentium";

        ob_start();
        require __DIR__ . '/../views/static/cgu.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/layout/header.php';
        echo $content;
        require __DIR__ . '/../views/layout/footer.php';
    }
}
