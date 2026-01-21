<?php

// app/models/VehicleModel.php

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

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                v.*,
                c.nom AS concession
            FROM voiture v
            JOIN concessionnaire c ON c.id_concess = v.id_concess
            WHERE v.id_voiture = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Récupérer N véhicules aléatoires avec leurs annonces
     */
    public function getRandomVehicles(int $limit = 3): array
    {
        // IMPORTANT: Utiliser directement la valeur dans la requête pour éviter les problèmes avec LIMIT
        $sql = "
            SELECT 
                v.*,
                a.id_annonce,
                a.titre,
                a.description,
                c.nom AS concession
            FROM voiture v
            LEFT JOIN annonce a ON a.id_voiture = v.id_voiture AND a.actif = 1
            LEFT JOIN concessionnaire c ON c.id_concess = v.id_concess
            WHERE a.id_annonce IS NOT NULL
            ORDER BY RAND()
            LIMIT " . intval($limit);

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO voiture (plaque, marque, modele, type, couleur, prix_journalier, id_concess, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['plaque'],
            $data['marque'],
            $data['modele'],
            $data['type'],
            $data['couleur'],
            $data['prix_journalier'],
            $data['id_concess'],
            $data['image']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE voiture 
            SET marque = ?, modele = ?, type = ?, couleur = ?, prix_journalier = ?, image = ?
            WHERE id_voiture = ?
        ");

        return $stmt->execute([
            $data['marque'],
            $data['modele'],
            $data['type'],
            $data['couleur'],
            $data['prix_journalier'],
            $data['image'],
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM voiture WHERE id_voiture = ?");
        return $stmt->execute([$id]);
    }

    public function getLastInsertId(): int
    {
        return (int) $this->db->lastInsertId();
    }
}
