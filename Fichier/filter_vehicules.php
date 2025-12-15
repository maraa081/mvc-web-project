<?php
// filter_vehicles.php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

include_once 'database.php';

$database = new Database();
$db = $database->getConnection();

// Récupérer les données JSON
$input = file_get_contents("php://input");
$data = json_decode($input);

// Log pour debug
error_log("Données reçues : " . $input);

// Construction de la requête SQL
$query = "SELECT 
            v.plaque,
            v.marque,
            v.modele,
            v.type,
            v.couleur,
            v.prix_journalier,
            c.nom as concession_nom,
            c.adresse as concession_adresse,
            c.latitude as concession_lat,
            c.longitude as concession_lon,
            a.date_publication
          FROM voiture v
          INNER JOIN concessionnaire c ON v.id_concess = c.id_concess
          LEFT JOIN annonce a ON v.plaque = a.voiture_plaque AND a.actif = 1
          WHERE 1=1";

$params = array();

// Filtre par type
if (!empty($data->type) && $data->type !== '') {
    $query .= " AND v.type = :type";
    $params[':type'] = $data->type;
}


// Filtre par prix minimum
if (!empty($data->minPrice) && $data->minPrice !== '') {
    $query .= " AND v.prix_journalier >= :minPrice";
    $params[':minPrice'] = floatval($data->minPrice);
}

// Filtre par prix maximum
if (!empty($data->maxPrice) && $data->maxPrice !== '') {
    $query .= " AND v.prix_journalier <= :maxPrice";
    $params[':maxPrice'] = floatval($data->maxPrice);
}

// Filtre par marques
if (!empty($data->marques) && is_array($data->marques) && count($data->marques) > 0) {
    $placeholders = [];
    foreach ($data->marques as $index => $marque) {
        $placeholder = ":marque" . $index;
        $placeholders[] = $placeholder;
        $params[$placeholder] = $marque;
    }
    $query .= " AND v.marque IN (" . implode(',', $placeholders) . ")";
}

// Filtre par couleurs
if (!empty($data->couleurs) && is_array($data->couleurs) && count($data->couleurs) > 0) {
    $placeholders = [];
    foreach ($data->couleurs as $index => $couleur) {
        $placeholder = ":couleur" . $index;
        $placeholders[] = $placeholder;
        $params[$placeholder] = $couleur;
    }
    $query .= " AND v.couleur IN (" . implode(',', $placeholders) . ")";
}

// Filtre par concession
if (!empty($data->concession) && $data->concession !== '') {
    $query .= " AND c.id_concess = :concession";
    $params[':concession'] = intval($data->concession);
}

// Déterminer l'ordre de tri
$sortBy = isset($data->sortBy) ? $data->sortBy : 'price_asc';

switch($sortBy) {
    case 'price_asc':
        $orderClause = " ORDER BY v.prix_journalier ASC";
        break;
    case 'price_desc':
        $orderClause = " ORDER BY v.prix_journalier DESC";
        break;
    case 'recent':
        $orderClause = " ORDER BY a.date_publication DESC";
        break;
    case 'oldest':
        $orderClause = " ORDER BY a.date_publication ASC";
        break;
    case 'brand_asc':
        $orderClause = " ORDER BY v.marque ASC, v.modele ASC";
        break;
    case 'brand_desc':
        $orderClause = " ORDER BY v.marque DESC, v.modele DESC";
        break;
    default:
        $orderClause = " ORDER BY v.prix_journalier ASC";
}

// Ordre par prix
$query .= $orderClause;

try {
    $stmt = $db->prepare($query);
    error_log(print_r($params, true));
    $stmt->execute($params);
    
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Si localisation fournie, calculer les distances
    if (!empty($data->userLat) && !empty($data->userLon) && !empty($data->distance)) {
        $userLat = floatval($data->userLat);
        $userLon = floatval($data->userLon);
        $maxDistance = floatval($data->distance);
        
        $filteredVehicles = [];
        
        foreach ($vehicles as $vehicle) {
            if (!empty($vehicle['concession_lat']) && !empty($vehicle['concession_lon'])) {
                $distance = calculateDistance(
                    $userLat, 
                    $userLon, 
                    floatval($vehicle['concession_lat']), 
                    floatval($vehicle['concession_lon'])
                );
                
                if ($distance <= $maxDistance) {
                    $vehicle['distance_km'] = round($distance, 1);
                    $filteredVehicles[] = $vehicle;
                }
            } else {
                // Inclure les véhicules sans coordonnées
                $filteredVehicles[] = $vehicle;
            }
        }
        
        // Trier par distance
        usort($filteredVehicles, function($a, $b) {
            $distA = isset($a['distance_km']) ? $a['distance_km'] : 999999;
            $distB = isset($b['distance_km']) ? $b['distance_km'] : 999999;
            return $distA <=> $distB;
        });
        
        $vehicles = $filteredVehicles;
    }
    
    http_response_code(200);
    echo json_encode([
        "success" => true,
        "count" => count($vehicles),
        "vehicles" => $vehicles,
        "debug_query" => $query,
        "debug_params" => $params
    ], JSON_UNESCAPED_UNICODE);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erreur lors de la recherche : " . $e->getMessage(),
        "query" => $query
    ], JSON_UNESCAPED_UNICODE);
}

// Fonction pour calculer la distance (Haversine)
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // km
    
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    
    return $earthRadius * $c;
}
?>