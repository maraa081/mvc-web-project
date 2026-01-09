<?php

require_once __DIR__ . '/Model.php';

class VehicleModel extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT 
                v.id_voiture,
                v.plaque,
                v.marque,
                v.modele,
                v.type,
                v.couleur,
                v.prix_journalier,
                v.image,
                c.nom AS concession
            FROM voiture v
            JOIN concessionnaire c ON c.id_concess = v.id_concess
        ");
        return $stmt->fetchAll();
    }

    public function find(string $plaque): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                v.*,
                c.nom AS concession
            FROM voiture v
            JOIN concessionnaire c ON c.id_concess = v.id_concess
            WHERE v.plaque = ?
        ");
        $stmt->execute([$plaque]);
        return $stmt->fetch() ?: null;
    }
}
