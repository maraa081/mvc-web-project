<?php

require_once __DIR__ . '/Model.php';

class ReservationModel extends Model
{
    public function create(
        int $id_user,
        int $id_annonce,
        string $date_debut,
        string $date_fin
    ): bool {
        $stmt = $this->db->prepare("
            INSERT INTO reservation (
                id_user,
                id_annonce,
                date_debut,
                date_fin,
                statut
            )
            VALUES (?, ?, ?, ?, 'PENDING')
        ");

        return $stmt->execute([
            $id_user,
            $id_annonce,
            $date_debut,
            $date_fin
        ]);
    }
}
