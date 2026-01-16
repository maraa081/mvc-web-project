<?php

class OrderModel
{
    private PDO $db;

    public function __construct()
    {
        require_once __DIR__ . '/../core/Database.php';
        $this->db = Database::getInstance();
    }

    public function getAllOrders()
    {
        $sql = "
            SELECT 
                r.id_reservation,
                r.date_debut,
                r.date_fin,
                r.statut,
                r.created_at,
                u.nom as client_nom,
                u.email as client_email,
                v.marque,
                v.modele,
                v.plaque,
                v.prix_journalier,
                a.titre as annonce_titre,
                DATEDIFF(r.date_fin, r.date_debut) as nb_jours,
                (DATEDIFF(r.date_fin, r.date_debut) * v.prix_journalier) as prix_total
            FROM reservation r
            INNER JOIN user u ON r.id_user = u.id_user
            INNER JOIN annonce a ON r.id_annonce = a.id_annonce
            INNER JOIN voiture v ON a.id_voiture = v.id_voiture
            ORDER BY r.created_at DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getOrdersByStatus(string $status)
    {
        $sql = "
            SELECT 
                r.id_reservation,
                r.date_debut,
                r.date_fin,
                r.statut,
                r.created_at,
                u.nom as client_nom,
                u.email as client_email,
                v.marque,
                v.modele,
                v.plaque,
                v.prix_journalier,
                a.titre as annonce_titre,
                DATEDIFF(r.date_fin, r.date_debut) as nb_jours,
                (DATEDIFF(r.date_fin, r.date_debut) * v.prix_journalier) as prix_total
            FROM reservation r
            INNER JOIN user u ON r.id_user = u.id_user
            INNER JOIN annonce a ON r.id_annonce = a.id_annonce
            INNER JOIN voiture v ON a.id_voiture = v.id_voiture
            WHERE r.statut = :status
            ORDER BY r.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['status' => $status]);
        return $stmt->fetchAll();
    }

    public function getUpcomingOrders()
    {
        $sql = "
            SELECT 
                r.id_reservation,
                r.date_debut,
                r.date_fin,
                r.statut,
                u.nom as client_nom,
                v.marque,
                v.modele,
                v.plaque,
                DATEDIFF(r.date_debut, NOW()) as jours_avant
            FROM reservation r
            INNER JOIN user u ON r.id_user = u.id_user
            INNER JOIN annonce a ON r.id_annonce = a.id_annonce
            INNER JOIN voiture v ON a.id_voiture = v.id_voiture
            WHERE r.date_debut > NOW()
            AND r.statut != 'CANCELED'
            ORDER BY r.date_debut ASC
            LIMIT 10
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getCurrentOrders()
    {
        $sql = "
            SELECT 
                r.id_reservation,
                r.date_debut,
                r.date_fin,
                r.statut,
                u.nom as client_nom,
                u.email as client_email,
                v.marque,
                v.modele,
                v.plaque,
                v.prix_journalier,
                DATEDIFF(r.date_fin, r.date_debut) as nb_jours
            FROM reservation r
            INNER JOIN user u ON r.id_user = u.id_user
            INNER JOIN annonce a ON r.id_annonce = a.id_annonce
            INNER JOIN voiture v ON a.id_voiture = v.id_voiture
            WHERE r.date_debut <= NOW()
            AND r.date_fin >= NOW()
            AND r.statut != 'CANCELED'
            ORDER BY r.date_debut DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, string $status)
    {
        $sql = "UPDATE reservation SET statut = :status WHERE id_reservation = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
