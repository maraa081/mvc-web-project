<?php

require_once __DIR__ . '/../models/VehicleModel.php';
require_once __DIR__ . '/../models/AnnonceModel.php';

class VehicleController
{
    private VehicleModel $vehicleModel;

    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
    }

    public function index()
{
    $vehicles = $this->vehicleModel->all();
    
    // Formater les chemins d'images
    foreach ($vehicles as &$vehicle) {
        $vehicle['image_url'] = $this->formatImagePath($vehicle['image'] ?? '');
    }
    unset($vehicle);
    
    // ✅ AJOUT: Récupérer les filtres dynamiques
    $marques = $this->vehicleModel->getAllMarques();
    $couleurs = $this->vehicleModel->getAllCouleurs();
    $types = $this->vehicleModel->getAllTypes();
    $concessions = $this->vehicleModel->getAllConcessions(); // ← NOUVEAU
    
    require __DIR__ . '/../views/vehicles.php';
}

    public function show()
    {
        if (!isset($_GET['plaque'])) {
            http_response_code(400);
            die('Plaque manquante');
        }

        $vehicle = $this->vehicleModel->find($_GET['plaque']);

        if (!$vehicle) {
            http_response_code(404);
            die('Véhicule introuvable');
        }

        $annonceModel = new AnnonceModel();

        // ✅ ON PASSE BIEN id_voiture
        $annonce = $annonceModel->findByVehicleId($vehicle['id_voiture']);

        if (!$annonce) {
            http_response_code(404);
            die('Aucune annonce associée à ce véhicule');
        }

        // ✅ AJOUT: Formater le chemin de l'image du véhicule
        $vehicle['image_url'] = $this->formatImagePath($vehicle['image'] ?? '');

        require __DIR__ . '/../views/vehicle_detail.php';
    }

    /**
     * ✅ NOUVELLE MÉTHODE: Formater intelligemment le chemin de l'image
     * Gère tous les formats possibles de chemins d'images
     */
    private function formatImagePath(string $imagePath): string
    {
        // Si vide, retourner l'image par défaut
        if (empty($imagePath)) {
            return BASE_URL . '/assets/images/vehicles/default.jpg';
        }

        // Si c'est déjà une URL complète (commence par http:// ou https://)
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        // Si le chemin commence par 'uploads/' (nouvelles images uploadées)
        if (str_starts_with($imagePath, 'uploads/')) {
            return BASE_URL . '/public/' . $imagePath;
        }

        // Si le chemin commence par 'assets/' (images statiques)
        if (str_starts_with($imagePath, 'assets/')) {
            return BASE_URL . '/' . $imagePath;
        }

        // Si c'est juste un nom de fichier sans /
        if (!str_contains($imagePath, '/')) {
            // Vérifier d'abord si c'est une ancienne image statique
            $staticPath = __DIR__ . '/../../assets/images/vehicles/' . $imagePath;
            if (file_exists($staticPath)) {
                return BASE_URL . '/assets/images/vehicles/' . $imagePath;
            }
            // Sinon, c'est probablement dans uploads/
            return BASE_URL . '/public/uploads/' . $imagePath;
        }

        // Par défaut, ajouter BASE_URL devant
        return BASE_URL . '/' . ltrim($imagePath, '/');
    }
}