
<?php
// ========================================
// FICHIER 1: ConcessionnaireModel.php (CORRIGÉ)
// ========================================
// Supprimez l'accolade en trop à la ligne 33

require_once __DIR__ . '/Model.php';

class ConcessionnaireModel extends Model
{
    public function create($nom, $adresse, $email, $lat = null, $lng = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO concessionnaire (nom, adresse, email, latitude, longitude)
            VALUES (:nom, :adresse, :email, :lat, :lng)
        ");

        $stmt->execute([
            ':nom'     => $nom,
            ':adresse' => $adresse,
            ':email'   => $email,
            ':lat'     => $lat,
            ':lng'     => $lng
        ]);

        return $this->db->lastInsertId();
    }

    public function getByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM concessionnaire WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // ✅ NOUVELLE MÉTHODE: Récupérer un concessionnaire par id_user
    public function getByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT c.* 
            FROM concessionnaire c
            INNER JOIN user u ON c.email = u.email
            WHERE u.id_user = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
/**
 * Récupérer toutes les concessions avec leurs coordonnées et nombre de véhicules
 */
public function getAllWithCoordinates(): array
{
    $stmt = $this->db->query("
        SELECT 
            c.id_concess,
            c.nom,
            c.adresse,
            c.email,
            c.latitude,
            c.longitude,
            COUNT(v.id_voiture) as nb_vehicules
        FROM concessionnaire c
        LEFT JOIN voiture v ON c.id_concess = v.id_concess
        WHERE c.latitude IS NOT NULL 
        AND c.longitude IS NOT NULL
        AND c.latitude != 0 
        AND c.longitude != 0
        GROUP BY c.id_concess
        ORDER BY c.nom ASC
    ");
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}