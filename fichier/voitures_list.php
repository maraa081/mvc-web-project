<?php
// api/voitures_list.php
declare(strict_types=1);
header("Content-Type: application/json; charset=utf-8");

try {
    require __DIR__ . "/db.php";

    $q          = trim($_GET["q"] ?? "");
    $type       = trim($_GET["type"] ?? "all");
    $concession = trim($_GET["concession"] ?? "all");
    $statut     = trim($_GET["statut"] ?? "all");
    $sort       = trim($_GET["sort"] ?? "none");

    $limit  = max(1, min(60, (int)($_GET["limit"] ?? 6)));
    $offset = max(0, (int)($_GET["offset"] ?? 0));

    // WHERE de base (sans statut) -> utile pour compter "disponibles"
    $whereBase = [];
    $paramsBase = [];

    if ($q !== "") {
        $whereBase[] = "(marque LIKE :q OR modele LIKE :q OR type LIKE :q)";
        $paramsBase[":q"] = "%$q%";
    }
    if ($type !== "all") {
        $whereBase[] = "type = :type";
        $paramsBase[":type"] = $type;
    }
    if ($concession !== "all") {
        $whereBase[] = "concession = :c";
        $paramsBase[":c"] = (int)$concession;
    }

    $whereBaseSql = $whereBase ? ("WHERE " . implode(" AND ", $whereBase)) : "";

    // WHERE complet (avec statut) -> total + data
    $where = $whereBase;
    $params = $paramsBase;

    if ($statut !== "all") {
        $where[] = "statut = :s";
        $params[":s"] = $statut;
    }

    $whereSql = $where ? ("WHERE " . implode(" AND ", $where)) : "";

    // ORDER BY
    $orderSql = "ORDER BY id DESC";
    if ($sort === "prix-asc")  $orderSql = "ORDER BY prix ASC";
    if ($sort === "prix-desc") $orderSql = "ORDER BY prix DESC";
    if ($sort === "marque-az") $orderSql = "ORDER BY marque ASC";

    // TOTAL
    $stmtTotal = $pdo->prepare("SELECT COUNT(*) AS cnt FROM voitures $whereSql");
    $stmtTotal->execute($params);
    $total = (int)($stmtTotal->fetch()["cnt"] ?? 0);

    // DISPONIBLES (mêmes filtres sauf statut, et statut='disponible')
    $stmtDisp = $pdo->prepare(
        "SELECT COUNT(*) AS cnt
         FROM voitures
         $whereBaseSql " . ($whereBase ? "AND statut='disponible'" : "WHERE statut='disponible'")
    );
    $stmtDisp->execute($paramsBase);
    $disponibles = (int)($stmtDisp->fetch()["cnt"] ?? 0);

    // DATA (pagination)
    $sql = "SELECT id, marque, modele, type, annee, prix, kilometrage, statut, concession, image
            FROM voitures
            $whereSql
            $orderSql
            LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k => $v) $stmt->bindValue($k, $v);
    $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "total" => $total,
        "disponibles" => $disponibles,
        "data" => $stmt->fetchAll()
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
