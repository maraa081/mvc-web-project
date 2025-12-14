<?php require __DIR__ . '/layout/header.php'; ?>

<div class="content-scrollable">

    <div class="page-header">
        <h2>📦 Commandes</h2>
    </div>

    <div class="table-card">
        <table class="clients-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r): ?>
                <tr>
                    <td>#<?= $r['id_reservation'] ?></td>
                    <td><?= $r['date_debut'] ?></td>
                    <td><?= $r['date_fin'] ?></td>
                    <td><?= $r['statut'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
