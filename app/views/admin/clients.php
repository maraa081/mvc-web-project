<?php
$pageCss = ['suivi-clients.css'];
$pageJs  = ['script.js'];

ob_start();
?>

<div class="page-header">
    <h2>
        <img src="<?= BASE_URL ?>/assets/img/bullet-list.png" class="header-icon">
        Clients
    </h2>
</div>

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon-circle green-bg">
            <img src="<?= BASE_URL ?>/assets/img/customer.png" alt="Users">
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Customers</span>
            <div class="stat-number">5,423</div>
            <div class="stat-trend trend-up">
                <img src="<?= BASE_URL ?>/assets/img/fleche_haut.png">
                <span>16%</span> this month
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-circle green-light-bg">
            <img src="<?= BASE_URL ?>/assets/img/member.png">
        </div>
        <div class="stat-info">
            <span class="stat-label">Members</span>
            <div class="stat-number">1,893</div>
            <div class="stat-trend trend-down">
                <img src="<?= BASE_URL ?>/assets/img/fleche_bas.png">
                <span>1%</span> this month
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-circle green-light-bg">
            <img src="<?= BASE_URL ?>/assets/img/active.png">
        </div>
        <div class="stat-info">
            <span class="stat-label">Active Now</span>
            <div class="stat-number">189</div>
        </div>
    </div>
</div>

<div class="table-card">

    <div class="table-header-row">
        <div class="titles">
            <h3>Tous les clients</h3>
            <span class="subtitle">Membres actifs</span>
        </div>

        <div class="controls">
            <div class="small-search">
                <img src="<?= BASE_URL ?>/assets/img/loupe.png">
                <input type="text" placeholder="Recherche nom, email..." id="table-search">
            </div>

            <div class="sort-wrapper">
                <div class="sort-dropdown" id="sort-btn">
                    <span id="current-sort">Trier par : Plus récent</span>
                    <img src="<?= BASE_URL ?>/assets/img/expand.png" id="sort-arrow" class="chevron-icon">
                </div>

                <div class="sort-menu-list" id="sort-menu">
                    <div class="sort-option">Plus récent</div>
                    <div class="sort-option">Plus ancien</div>
                </div>
            </div>
        </div>
    </div>

    <table class="clients-table" id="clients-table">
        <thead>
            <tr>
                <th>Nom du client</th>
                <th>ID</th>
                <th>Numéro de Tél</th>
                <th>E-mail</th>
                <th>ID de la resv</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Jean Dupont</td>
                <td>CL-2023-001</td>
                <td>06 12 34 56 78</td>
                <td>jean.dupont@email.com</td>
                <td>RES-9981</td>
                <td><span class="badge badge-active">Active</span></td>
            </tr>
            <tr>
                <td>Sophie Martin</td>
                <td>CL-2023-042</td>
                <td>07 98 76 54 32</td>
                <td>sophie.m@email.com</td>
                <td>RES-1023</td>
                <td><span class="badge badge-inactive">Inactive</span></td>
            </tr>
            <tr>
                <td>Marc Lebrun</td>
                <td>CL-2023-108</td>
                <td>06 55 44 33 22</td>
                <td>m.lebrun@email.com</td>
                <td>RES-1145</td>
                <td><span class="badge badge-active">Active</span></td>
            </tr>
        </tbody>
    </table>

    <div class="table-footer">
        <span class="entries-info" id="entries-info">Affichage des données</span>
        <div class="pagination">
            <button class="page-btn">&lt;</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">&gt;</button>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout/admin.php';
