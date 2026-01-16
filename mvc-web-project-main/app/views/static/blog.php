<?php
$pageCss = [];
require __DIR__ . '/../layout/header.php';
?>

<section class="static-page">
    <div class="container">
        <h1>Notre Blog</h1>

        <p>
            Bienvenue sur le blog de <strong>VTC Rentium</strong>.
            Vous trouverez ici des articles autour de la mobilité,
            de la location de véhicules et des conseils pour vos déplacements.
        </p>

        <ul class="simple-list">
            <li>🚗 Comment choisir le bon véhicule pour vos besoins</li>
            <li>📍 Les meilleures destinations à découvrir en voiture</li>
            <li>💡 Conseils pour une location sereine</li>
        </ul>

        <p class="muted">
            De nouveaux articles arrivent bientôt.
        </p>
    </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
