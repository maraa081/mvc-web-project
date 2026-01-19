<div class="blog-hero">
    <div class="container">
        <h1>Le Magazine Rentium</h1>
        <p>Actualités, conseils et guide de voyage pour vos déplacements.</p>
    </div>
</div>

<div class="container blog-container">
    <div class="blog-grid">
        <?php foreach ($articles as $art): ?>
            <article class="blog-card">
                <div class="blog-img-wrapper">
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($art['image_url']) ?>" alt="<?= htmlspecialchars($art['titre']) ?>">
                    <span class="blog-category"><?= htmlspecialchars($art['categorie']) ?></span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">
                        <span class="date"><?= date('d M Y', strtotime($art['date_creation'])) ?></span>
                        <span class="author">Par <?= htmlspecialchars($art['auteur']) ?></span>
                    </div>
                    <a href="index.php?page=blog&id=<?= $art['id_article'] ?>" class="blog-title-link">
                        <h3><?= htmlspecialchars($art['titre']) ?></h3>
                    </a>
                    <p class="blog-excerpt"><?= htmlspecialchars($art['accroche']) ?></p>
                    <a href="index.php?page=blog&id=<?= $art['id_article'] ?>" class="read-more">Lire l'article &rarr;</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/blog.css">

