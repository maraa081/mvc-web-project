<?php
// api/voitures_delete.php
declare(strict_types=1);
header("Content-Type: application/json; charset=utf-8");

try {
    require __DIR__ . "/db.php";

    $data = json_decode(file_get_contents("php://input"), true);
    if (!is_array($data)) {
        throw new Exception("JSON invalide");
    }

    $ids = $data["ids"] ?? [];

    if (!is_array($ids) || count($ids) === 0) {
        throw new Exception("Aucun ID fourni");
    }

    // Nettoyage strict des IDs
    $ids = array_values(array_filter($ids, fn($id) => is_numeric($id) && (int)$id > 0));
    if (count($ids) === 0) {
        throw new Exception("IDs invalides");
    }

    $placeholders = implode(",", array_fill(0, count($ids), "?"));

    $sql = "DELETE FROM voitures WHERE id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);

    echo json_encode([
        "success" => true,
        "deleted" => $stmt->rowCount()
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
