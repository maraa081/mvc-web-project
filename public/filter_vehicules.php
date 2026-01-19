<?php
/**
 * API de filtrage des véhicules
 */

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/models/VehicleModel.php';

header('Content-Type: application/json');

// Activer l'affichage des erreurs pour debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Récupération des données JSON
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    
    // Log dans un fichier custom
    file_put_contents(__DIR__ . '/debug.log', date('Y-m-d H:i:s') . " - Données reçues:\n" . print_r($data, true) . "\n\n", FILE_APPEND);
    
    if ($data === null) {
        throw new Exception("Données JSON invalides");
    }
    
    $vehicleModel = new VehicleModel();
    $filters = [];
    
    // Filtres
    if (!empty($data['type']) && $data['type'] !== '') {
        $filters['type'] = $data['type'];
        file_put_contents(__DIR__ . '/debug.log', "TYPE: " . $data['type'] . "\n", FILE_APPEND);
    }
    
    if (!empty($data['maxPrice']) && $data['maxPrice'] !== '') {
        $filters['maxPrice'] = (float) $data['maxPrice'];
    }
    
    if (!empty($data['marques']) && is_array($data['marques']) && count($data['marques']) > 0) {
        $filters['marques'] = $data['marques'];
    }
    
    if (!empty($data['couleurs']) && is_array($data['couleurs']) && count($data['couleurs']) > 0) {
        $filters['couleurs'] = $data['couleurs'];
    }
    
    if (!empty($data['concessions']) && is_array($data['concessions']) && count($data['concessions']) > 0) {
        $filters['concessions'] = $data['concessions'];
    }
    
    if (!empty($data['sortBy']) && $data['sortBy'] !== '') {
        $filters['sortBy'] = $data['sortBy'];
    }
    
    file_put_contents(__DIR__ . '/debug.log', "Filtres finaux: " . print_r($filters, true) . "\n", FILE_APPEND);
    
    // Exécution
    if (empty($filters) || (count($filters) === 1 && isset($filters['sortBy']))) {
        $vehicles = $vehicleModel->all();
    } else {
        $vehicles = $vehicleModel->search($filters);
    }
    
    // Formater images
    foreach ($vehicles as &$vehicle) {
        $vehicle['image_url'] = formatImagePath($vehicle['image'] ?? '');
    }
    unset($vehicle);
    
    file_put_contents(__DIR__ . '/debug.log', "Véhicules trouvés: " . count($vehicles) . "\n\n", FILE_APPEND);
    
    // Réponse
    echo json_encode([
        'success' => true,
        'count' => count($vehicles),
        'vehicles' => $vehicles,
        'filters_applied' => $filters
    ]);
    
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/debug.log', "ERREUR: " . $e->getMessage() . "\n\n", FILE_APPEND);
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

function formatImagePath($imagePath)
{
    if (empty($imagePath)) {
        return BASE_URL . '/assets/images/vehicles/default.jpg';
    }

    if (strpos($imagePath, 'http://') === 0 || strpos($imagePath, 'https://') === 0) {
        return $imagePath;
    }

    if (strpos($imagePath, 'uploads/') === 0) {
        return BASE_URL . '/public/' . $imagePath;
    }

    if (strpos($imagePath, 'assets/') === 0) {
        return BASE_URL . '/' . $imagePath;
    }

    if (strpos($imagePath, '/') === false) {
        $staticPath = __DIR__ . '/../assets/images/vehicles/' . $imagePath;
        if (file_exists($staticPath)) {
            return BASE_URL . '/assets/images/vehicles/' . $imagePath;
        }
        return BASE_URL . '/public/uploads/' . $imagePath;
    }

    return BASE_URL . '/' . ltrim($imagePath, '/');
}