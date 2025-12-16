<?php
function getAllClients($pdo) {
    // Récupère tous les clients triés par ID décroissant
    $stmt = $pdo->query("SELECT * FROM clients ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>