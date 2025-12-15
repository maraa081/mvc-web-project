<?php

require_once __DIR__ . '/database.php';

class Voiture
{
    private $conn;

    public function __construct() {
        // Créer une instance de Database
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCars() {
        $sql = "SELECT * FROM voiture";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
