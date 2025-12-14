<?php
$users = $users ?? [];
?>

<?php require __DIR__ . '/layout/header.php'; ?>
<link rel="stylesheet" href="/test/assets/css/admin.css">
<script src="/test/assets/js/admin.js" defer></script>

<div class="content-scrollable">

    <div class="page-header">
        <h2>👥 Clients</h2>
    </div>

    <div class="table-card">
        <table class="clients-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id_user'] ?></td>
                    <td><?= htmlspecialchars($u['nom']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <span class="badge <?= $u['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                            <?= $u['is_active'] ? 'Actif' : 'Inactif' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
