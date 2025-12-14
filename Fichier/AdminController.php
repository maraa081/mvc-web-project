<?php

require_once __DIR__ . '/../models/VehicleModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ReservationModel.php';

class AdminController
{
    public function dashboard()
    {
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function vehicles()
    {
        $vehicleModel = new VehicleModel();
        $vehicles = $vehicleModel->all();

        require __DIR__ . '/../views/admin/vehicles.php';
    }

    public function clients()
    {
        $userModel = new UserModel();
        $users = $userModel->all();

        require __DIR__ . '/../views/admin/clients.php';
    }

    public function orders()
    {
        $reservationModel = new ReservationModel();
        $reservations = $reservationModel->all();

        require __DIR__ . '/../views/admin/orders.php';
    }

    public function settings()
    {
        require __DIR__ . '/../views/admin/settings.php';
    }
}
