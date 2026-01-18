<?php

// Démarrage global des sessions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration de la base de données pour XAMPP
define('DB_HOST', 'localhost');      // ou '127.0.0.1'
define('DB_NAME', 'rentium');        // Nom de votre base de données
define('DB_USER', 'root');           // Utilisateur par défaut XAMPP
define('DB_PASS', '');               // Mot de passe vide par défaut XAMPP
define('DB_CHARSET', 'utf8mb4');
define('DB_PORT', '3306');           // Port MySQL par défaut

// URL de base
define('BASE_URL', 'http://localhost/mvc-web-project-main'); // Adaptez selon votre dossier

// Affichage des erreurs (DEV)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);