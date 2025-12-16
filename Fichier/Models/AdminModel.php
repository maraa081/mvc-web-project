<?php
function getAdminInfo($pdo) {
    // Récupère les infos de l'admin (ID 1)
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>