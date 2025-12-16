<?php
// api/db.php
declare(strict_types=1);

$host = "127.0.0.1";
$db   = "rentium";     // ⚠️ nom EXACT de la base dans phpMyAdmin
$user = "root";
$pass = "";            // XAMPP par défaut
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Connexion BDD impossible"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
