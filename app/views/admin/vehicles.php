<?php require __DIR__ . '/layout/header.php'; ?>
<link rel="stylesheet" href="/test/assets/css/admin.css">
<script src="/test/assets/js/admin.js" defer></script>

<div class="content-scrollable">

    <div class="page-header">
        <h2>🚗 Véhicules</h2>
    </div>

    <div class="table-card">
        <table class="clients-table">
            <thead>
                <tr>
                    <th>Plaque</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Type</th>
                    <th>Prix / jour</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $v): ?>
                <tr>
                    <td><?= htmlspecialchars($v['plaque']) ?></td>
                    <td><?= htmlspecialchars($v['marque']) ?></td>
                    <td><?= htmlspecialchars($v['modele']) ?></td>
                    <td><?= htmlspecialchars($v['type']) ?></td>
                    <td><?= htmlspecialchars($v['prix_journalier']) ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
