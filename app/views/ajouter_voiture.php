<?php
$pageCss = ['dashboard.css', 'auth.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="dashboard-container">

    <aside class="dashboard-sidebar">
        <h2>Concessionnaire</h2>
        <ul>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=dashboard_concessionnaire">🏠 Tableau de bord</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=ajouter_voiture" class="active">➕ Ajouter un véhicule</a></li>
            <li><a href="<?= BASE_URL ?>/public/index.php?page=mes_voitures">🚗 Mes véhicules</a></li>
        </ul>
    </aside>

    <main class="dashboard-main">
        <h1>Ajouter un véhicule</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="auth-message error"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div class="form-group">
                <label>Plaque d'immatriculation</label>
                <input type="text" name="plaque" required>
            </div>

            <select name="marque" required>
                <option value="">-- Choisir une marque --</option>
                <option value="Audi">Audi</option>
                <option value="BMW">BMW</option>
                <option value="Mercedes">Mercedes</option>
                <option value="Peugeot">Peugeot</option>
                <option value="Renault">Renault</option>
            </select>


            <div class="form-group">
                <label>Modèle</label>
                <input type="text" name="modele" required>
            </div>

            <select name="type" required>
                <option value="">-- Choisir un type --</option>
                <option value="Berline">Berline</option>
                <option value="SUV">SUV</option>
                <option value="Citadine">Citadine</option>
                <option value="Coupé">Coupé</option>
                <option value="Électrique">Électrique</option>
            </select>


            <select name="couleur" required>
                <option value="">-- Choisir une couleur --</option>
                <option value="Noir">Noir</option>
                <option value="Blanc">Blanc</option>
                <option value="Rouge">Rouge</option>
                <option value="Bleu">Bleu</option>
                <option value="Gris">Gris</option>
            </select>

            <div class="form-group">
                <label>Prix journalier (€)</label>
                <input type="number" name="prix_journalier" required min="1">
            </div>

            <div class="form-group">
                <label>Image du véhicule</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn-primary">Publier le véhicule</button>
        </form>
    </main>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
