<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        // Utilisation des constantes ou valeurs en dur pour XAMPP
        $host = 'localhost';        // XAMPP utilise localhost
        $db   = 'rentium';          // Votre base de données
        $user = 'root';             // Utilisateur par défaut XAMPP
        $pass = '';                 // Mot de passe vide par défaut sur XAMPP
        $charset = 'utf8mb4';
        $port = '3306';             // Port MySQL par défaut

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            die('Erreur connexion BDD : ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}