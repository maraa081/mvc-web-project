<?php

require_once __DIR__ . '/Model.php';

class ReservationModel extends Model
{
    /**
     * Vérifie si le véhicule est disponible pour les dates demandées
     *
     * @param int $id_annonce
     * @param string $date_debut
     * @param string $date_fin
     * @return bool true si disponible, false sinon
     */
    public function isAvailable(
        int $id_annonce,
        string $date_debut,
        string $date_fin
    ): bool {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM reservation
            WHERE id_annonce = ?
            AND statut != 'CANCELED'
            AND date_fin >= ?
            AND date_debut <= ?
        ");

        $stmt->execute([
            $id_annonce,
            $date_debut,
            $date_fin
        ]);

        $result = $stmt->fetch();
        return $result['count'] == 0;
    }

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
