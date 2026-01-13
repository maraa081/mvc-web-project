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

        require __DIR__ . '/../views/vehicle_detail.php';
    }
}
