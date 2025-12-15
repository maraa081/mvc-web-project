<?php

class ReservationModel extends Model
{
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO reservation 
            (id_user, id_annonce, date_debut, date_fin)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_user'],
            $data['id_annonce'],
            $data['date_debut'],
            $data['date_fin']
        ]);
    }

    public function byUser(int $id_user)
    {
        $stmt = $this->db->prepare("
            SELECT r.*, a.titre
            FROM reservation r
            JOIN annonce a ON a.id_annonce = r.id_annonce
            WHERE r.id_user = ?
        ");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll();
    }

    public function all()
    {
        return $this->db->query("SELECT * FROM reservation")->fetchAll();
    }
}
