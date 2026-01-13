<?php
/**
 * API de filtrage des véhicules
 * Placez ce fichier dans : public/filter_vehicules.php
 */

// Correction du chemin relatif selon votre structure
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/models/VehicleModel.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

try {
    // Récupération des données JSON envoyées par filter.js
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    
    // Log pour le débogage (à retirer en production)
    error_log("Filtres reçus : " . print_r($data, true));
    
    // Vérification que les données sont bien reçues
    if ($data === null) {
        throw new Exception("Données JSON invalides");
    }
    
    // Création du modèle
    $vehicleModel = new VehicleModel();
    
    // Préparation des filtres
    $filters = [];
    
    if (!empty($data['type'])) {
        $filters['type'] = $data['type'];
    }
    
    if (!empty($data['maxPrice'])) {
        $filters['maxPrice'] = (float) $data['maxPrice'];
    }
    
    if (!empty($data['marques']) && is_array($data['marques'])) {
        $filters['marques'] = $data['marques'];
    }
    
    if (!empty($data['couleurs']) && is_array($data['couleurs'])) {
        $filters['couleurs'] = $data['couleurs'];
    }
    
    if (!empty($data['concessions']) && is_array($data['concessions'])) {
        $filters['concessions'] = $data['concessions'];
    }
    
    if (!empty($data['sortBy'])) {
        $filters['sortBy'] = $data['sortBy'];
    }
    
    // Exécution de la recherche
    $vehicles = $vehicleModel->search($filters);
    
    // Log du résultat
    error_log("Véhicules trouvés : " . count($vehicles));
    
    // Réponse JSON
    echo json_encode([
        'success' => true,
        'count' => count($vehicles),
        'vehicles' => $vehicles,
        'filters_applied' => $filters
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    error_log("ERREUR API : " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}