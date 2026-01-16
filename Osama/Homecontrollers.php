<?php
// app/controllers/HomeController.php

class HomeController {
    public function index() {
        // Récupérer 3 voitures aléatoires pour les suggestions
        require_once __DIR__ . '/../models/VehicleModel.php';
        
        try {
            $vehicleModel = new VehicleModel();
            $suggestedVehicles = $vehicleModel->getRandomVehicles(3);
        } catch (Exception $e) {
            // En cas d'erreur, tableau vide
            $suggestedVehicles = [];
            error_log("Erreur getRandomVehicles: " . $e->getMessage());
        }
        
        require __DIR__ . '/../views/home.php';
    }
}
