<?php
$pageCss = ['dashboard.css', 'form.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="dashboard-container">
    <h1>✏️ Modifier un véhicule</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            ❌ <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" 
              action="<?= BASE_URL ?>/public/index.php?page=modifier_voiture&id=<?= $voiture['id_voiture'] ?>" 
              enctype="multipart/form-data">

            <div class="form-row">
                <div class="form-group">
                    <label>Marque *</label>
                    <input type="text" 
                           name="marque" 
                           value="<?= htmlspecialchars($voiture['marque'], ENT_QUOTES, 'UTF-8') ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Modèle *</label>
                    <input type="text" 
                           name="modele" 
                           value="<?= htmlspecialchars($voiture['modele'], ENT_QUOTES, 'UTF-8') ?>"
                           required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Type *</label>
                    <select name="type" required>
                        <option value="">Sélectionner</option>
                        <option value="Berline" <?= $voiture['type'] === 'Berline' ? 'selected' : '' ?>>Berline</option>
                        <option value="SUV" <?= $voiture['type'] === 'SUV' ? 'selected' : '' ?>>SUV</option>
                        <option value="Citadine" <?= $voiture['type'] === 'Citadine' ? 'selected' : '' ?>>Citadine</option>
                        <option value="Électrique" <?= $voiture['type'] === 'Électrique' ? 'selected' : '' ?>>Électrique</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Couleur *</label>
                    <input type="text" 
                           name="couleur" 
                           value="<?= htmlspecialchars($voiture['couleur'], ENT_QUOTES, 'UTF-8') ?>"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label>Prix journalier (€) *</label>
                <input type="number" 
                       name="prix_journalier" 
                       step="0.01" 
                       min="1"
                       value="<?= $voiture['prix_journalier'] ?>"
                       required>
            </div>

            <div class="form-group">
                <label>Image actuelle</label>
                <?php if (!empty($voiture['image'])): ?>
                    <?php
                    $imagePath = $voiture['image'];
                    if (strpos($imagePath, 'uploads/') === 0) {
                        $imageUrl = BASE_URL . '/public/' . $imagePath;
                    } else {
                        $imageUrl = BASE_URL . '/assets/images/vehicles/' . $imagePath;
                    }
                    ?>
                    <img src="<?= htmlspecialchars($imageUrl) ?>" 
                         alt="Image actuelle" 
                         style="max-width: 300px; border-radius: 8px; margin: 10px 0;">
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Changer l'image (optionnel)</label>
                <input type="file" name="image" accept=".jpg">
                <small>Format JPG uniquement. Nom attendu : <?= strtolower($voiture['marque'] . '_' . $voiture['modele']) ?>.jpg</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">💾 Enregistrer les modifications</button>
                <a href="<?= BASE_URL ?>/public/index.php?page=mes_voitures" class="btn-secondary">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>