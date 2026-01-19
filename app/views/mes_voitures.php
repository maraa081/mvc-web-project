<?php
$pageCss = ['dashboard.css'];
require __DIR__ . '/layout/header.php';
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>🚗 Mes Véhicules</h1>
        <a href="<?= BASE_URL ?>/public/index.php?page=ajouter_voiture" class="btn-primary">
            ➕ Ajouter un véhicule
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            ✅ <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            ❌ <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="vehicles-grid">
        <?php if (empty($voitures)): ?>
            <div class="empty-state">
                <p>😕 Vous n'avez pas encore ajouté de véhicules.</p>
                <a href="<?= BASE_URL ?>/public/index.php?page=ajouter_voiture" class="btn-primary">
                    Ajouter mon premier véhicule
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($voitures as $voiture): ?>
                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <?php if (!empty($voiture['image'])): ?>
                            <?php 
                            // Construire le bon chemin d'image
                            $imagePath = $voiture['image'];
                            
                            // Si le chemin contient déjà 'http', c'est une URL complète
                            if (str_starts_with($imagePath, 'http')) {
                                // Extraire juste le nom du fichier après uploads/
                                $imagePath = basename($imagePath);
                                $imagePath = BASE_URL . '/public/uploads/' . $imagePath;
                            } 
                            // Si le chemin commence par 'uploads/', on ajoute BASE_URL
                            elseif (str_starts_with($imagePath, 'uploads/')) {
                                $imagePath = BASE_URL . '/public/' . $imagePath;
                            }
                            // Si c'est juste un nom de fichier
                            else {
                                $imagePath = BASE_URL . '/public/uploads/' . $imagePath;
                            }
                            ?>
                            <img src="<?= htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8') ?>" 
                                 alt="<?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele'], ENT_QUOTES, 'UTF-8') ?>"
                                 onerror="this.parentElement.innerHTML='<div class=\'no-image\'>📷 Image non trouvée<br><small><?= htmlspecialchars(basename($imagePath)) ?></small></div>'">
                        <?php else: ?>
                            <div class="no-image">📷 Pas d'image</div>
                        <?php endif; ?>
                    </div>

                    <div class="vehicle-info">
                        <h3><?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele'], ENT_QUOTES, 'UTF-8') ?></h3>
                        
                        <div class="vehicle-details">
                            <p><strong>Plaque:</strong> <?= htmlspecialchars($voiture['plaque'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Type:</strong> <?= htmlspecialchars($voiture['type'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Couleur:</strong> <?= htmlspecialchars($voiture['couleur'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="price"><strong>Prix:</strong> <?= number_format($voiture['prix_journalier'], 2) ?>€/jour</p>
                        </div>

                        <div class="vehicle-actions">
                            <a href="<?= BASE_URL ?>/public/index.php?page=modifier_voiture&id=<?= $voiture['id_voiture'] ?>" 
                            class="btn-edit">
                                ✏️ Modifier
                            </a>
                            <a href="<?= BASE_URL ?>/public/index.php?page=supprimer_voiture&id=<?= $voiture['id_voiture'] ?>" 
                            class="btn-delete"
                            onclick="return confirmerSuppression('<?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele'], ENT_QUOTES, 'UTF-8') ?>')">
                                🗑️ Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmerSuppression(nomVehicule) {
    return confirm(
        '⚠️ ATTENTION !\n\n' +
        'Voulez-vous vraiment supprimer ce véhicule ?\n\n' +
        '📌 Véhicule : ' + nomVehicule + '\n\n' +
        '❌ Cette action est irréversible !\n' +
        '🖼️ L\'image sera également supprimée.\n\n' +
        'Continuer ?'
    );
}
</script>


<?php require __DIR__ . '/layout/footer.php'; ?>