<?php

class AnnonceModel extends Model
{
    public function allActive()
    {
        return $this->db->query("
            SELECT a.*, v.marque, v.modele, v.prix_journalier
            FROM annonce a
            JOIN voiture v ON v.plaque = a.voiture_plaque
            WHERE a.actif = 1
        ")->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO annonce (titre, description, voiture_plaque, id_concess)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['voiture_plaque'],
            $data['id_concess']
        ]);
    }
}
