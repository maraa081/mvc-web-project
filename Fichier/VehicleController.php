<?php

class VehicleController
{
    public function index()
    {
        require __DIR__ . '/../views/vehicles.php';
    }

    public function show()
    {
        require __DIR__ . '/../views/vehicle_detail.php';
    }
}
