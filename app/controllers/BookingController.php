<?php

require_once __DIR__ . '/../models/AnnonceModel.php';
require_once __DIR__ . '/../models/ReservationModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class BookingController
{
    public function index()
    {
        if (!isset($_GET['id_annonce'])) {
            http_response_code(404);
            die('Annonce invalide');
        }

        $id_annonce = (int) $_GET['id_annonce'];

        $annonceModel = new AnnonceModel();
        $annonce = $annonceModel->find($id_annonce);

        if (!$annonce) {
            http_response_code(404);
            die('Annonce introuvable');
        }

        require __DIR__ . '/../views/booking.php';
    }

    public function store()
    {
        /* 🔥 Nettoyage de tout output parasite */
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');

        /* ✅ UTILISATEUR CONNECTÉ (CLÉ CORRECTE) */
        if (
            !isset($_SESSION['user']) ||
            !isset($_SESSION['user']['id'])
        ) {
            echo json_encode([
                'success' => false,
                'error'   => 'Utilisateur non connecté'
            ]);
            exit;
        }

        $id_user    = (int) $_SESSION['user']['id'];
        $id_annonce = (int) ($_POST['id_annonce'] ?? 0);
        $date_debut = $_POST['date_debut'] ?? null;
        $date_fin   = $_POST['date_fin'] ?? null;

        if (!$id_annonce || !$date_debut || !$date_fin) {
            echo json_encode([
                'success' => false,
                'error'   => 'Données manquantes'
            ]);
            exit;
        }

        $reservationModel = new ReservationModel();

        $success = $reservationModel->create(
            $id_user,
            $id_annonce,
            $date_debut,
            $date_fin
        );

        echo json_encode([
            'success' => $success
        ]);
        exit;
    }
}
