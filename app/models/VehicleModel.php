<?php

class VehicleModel extends Model
{
    public function all()
    {
        return $this->db->query("
            SELECT v.*, c.nom AS concession
            FROM voiture v
            JOIN concessionnaire c ON c.id_concess = v.id_concess
        ")->fetchAll();
    }

    public function find(string $plaque)
    {
        $stmt = $this->db->prepare("SELECT * FROM voiture WHERE plaque = ?");
        $stmt->execute([$plaque]);
        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO voiture 
            (plaque, marque, modele, type, couleur, prix_journalier, id_concess)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['plaque'],
            $data['marque'],
            $data['modele'],
            $data['type'],
            $data['couleur'],
            $data['prix_journalier'],
            $data['id_concess']
        ]);
    }

    public function delete(string $plaque): bool
    {
        $stmt = $this->db->prepare("DELETE FROM voiture WHERE plaque = ?");
        return $stmt->execute([$plaque]);
    }
}
