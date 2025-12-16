<?php
// 1. Connexion BDD
require 'Config/db.php';

// 2. Inclusion du Modèle
require 'Models/AdminModel.php';

// 3. Récupération des données
$user = getAdminInfo($pdo);

// 4. Affichage de la Vue
require 'Views/Parametres.view.php';
?>