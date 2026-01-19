<?php

require_once __DIR__ . '/../models/ConcessionnaireModel.php';

class CarteController
{
    public function index()
    {
        $concessionnaireModel = new ConcessionnaireModel();
        $concessions = $concessionnaireModel->getAllWithCoordinates();
        
        require __DIR__ . '/../views/carte_concessions.php';
    }
}