<?php
// 1. Connexion BDD (Attention aux majuscules des dossiers !)
require 'Config/db.php';

// 2. Inclusion du Modèle
require 'Models/ClientModel.php';

// 3. Récupération des données
$clients = getAllClients($pdo);

// 4. Affichage de la Vue
require 'Views/Clients.view.php';
?>