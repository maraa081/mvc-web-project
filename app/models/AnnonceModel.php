<?php

require_once __DIR__ . '/Model.php';

class AnnonceModel extends Model
{
    /**
     * Trouver une annonce active par ID de voiture
     */
    public function findByVehicleId(int $id_voiture): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                a.*,
                v.marque,
                v.modele,
                v.type,
                v.couleur,
                v.image,
                v.prix_journalier,
                c.nom AS concession
            FROM annonce a
            JOIN voiture v ON v.id_voiture = a.id_voiture
            JOIN concessionnaire c ON c.id_concess = v.id_concess
            WHERE a.id_voiture = ? AND a.actif = 1
            LIMIT 1
        ");
        $stmt->execute([$id_voiture]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Trouver une annonce par son ID (pour booking)
     */
    public function find(int $id_annonce): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                a.*,
                v.marque,
                v.modele,
                v.type,
                v.couleur,
                v.image,
                v.prix_journalier,
                c.nom AS concession
            FROM annonce a
            JOIN voiture v ON v.id_voiture = a.id_voiture
            JOIN concessionnaire c ON c.id_concess = v.id_concess
            WHERE a.id_annonce = ?
            LIMIT 1
        ");
        $stmt->execute([$id_annonce]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
