<div class="scroll-progress-container">
    <div class="scroll-progress-bar" id="progressBar"></div>
</div>

<div class="article-wrapper">
    <div class="container">
        <a href="index.php?page=blog" class="back-link">&larr; Retour aux articles</a>
        
        <header class="article-header">
            <span class="badge-cat"><?= htmlspecialchars($article['categorie']) ?></span>
            <h1><?= htmlspecialchars($article['titre']) ?></h1>
            <div class="meta-info">
                <img src="<?= BASE_URL ?>/assets/images/avatar-default.png" alt="Auteur" class="author-avatar">
                <div>
                    <span class="author-name"><?= htmlspecialchars($article['auteur']) ?></span>
                    <span class="publish-date">Publié le <?= date('d/m/Y', strtotime($article['date_creation'])) ?></span>
                </div>
            </div>
        </header>

        <div class="article-featured-img">
            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($article['image_url']) ?>" alt="Image principale">
        </div>

        <div class="article-body">
            <?= html_entity_decode($article['contenu']) ?>
        </div>

        <div class="rating-section">
            <p>Cet article vous a été utile ?</p>
            <div class="rating-buttons">
                <button class="btn-rate like <?= ($userVote === 'like') ? 'active' : '' ?>" 
                        onclick="vote(<?= $article['id_article'] ?>, 'like', this)">
                    👍 <span id="count-like"><?= $article['likes'] ?></span>
                </button>
                
                <button class="btn-rate dislike <?= ($userVote === 'dislike') ? 'active' : '' ?>" 
                        onclick="vote(<?= $article['id_article'] ?>, 'dislike', this)">
                    👎 <span id="count-dislike"><?= $article['dislikes'] ?></span>
                </button>
            </div>
            <p id="vote-message" style="font-size: 0.9rem; margin-top: 10px; min-height: 20px; font-weight:500;"></p>
        </div>

        <div class="article-footer">
            <h3>Partager cet article</h3>
            <div class="share-buttons">
                <button class="btn-share facebook">Partager</button>
                <button class="btn-share twitter">Tweeter</button>
                <button class="btn-share copy" onclick="navigator.clipboard.writeText(window.location.href); alert('Lien copié !')">Copier le lien</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/blog.css">
<script src="<?= BASE_URL ?>/assets/js/blog.js"></script>