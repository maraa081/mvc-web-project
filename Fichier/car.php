<?php

require_once 'voiture.php';

class CarController {
    public function index() {
        $voiture = new Voiture();
        return $voiture->getAllCars();
    }
}
