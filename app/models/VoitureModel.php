<?php

require_once __DIR__ . '/Model.php';

class VoitureModel extends Model
{
    public function __construct()
    {
        parent::__construct(); // initialise $this->db via Database::getInstance()
    }

    public function ajouterVoiture($idConcess, $plaque, $marque, $modele, $type, $couleur, $prix, $image)
    {
        $stmt = $this->db->prepare("
            INSERT INTO voiture (id_concess, plaque, marque, modele, type, couleur, prix_journalier, image)
            VALUES (:idc, :plaque, :marque, :modele, :type, :couleur, :prix, :image)
        ");

        return $stmt->execute([
            ':idc'     => $idConcess,
            ':plaque'  => $plaque,
            ':marque'  => $marque,
            ':modele'  => $modele,
            ':type'    => $type,
            ':couleur' => $couleur,
            ':prix'    => $prix,
            ':image'   => $image
        ]);
    }

    public function getByConcessionnaire($idConcess)
    {
        $stmt = $this->db->prepare("SELECT * FROM voiture WHERE id_concess = :idc");
        $stmt->execute([':idc' => $idConcess]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getAllWithConcession()
{
    $stmt = $this->db->prepare("
        SELECT 
            v.*,
            c.nom as concession,
            c.adresse as concession_adresse,
            c.latitude,
            c.longitude
        FROM voiture v
        INNER JOIN concessionnaire c ON v.id_concess = c.id_concess
        ORDER BY v.id_voiture DESC
    ");
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupérer un véhicule par sa plaque
 */
public function getByPlaque($plaque)
{
    $stmt = $this->db->prepare("
        SELECT 
            v.*,
            c.nom as concession,
            c.adresse as concession_adresse,
            c.email as concession_email,
            c.latitude,
            c.longitude
        FROM voiture v
        INNER JOIN concessionnaire c ON v.id_concess = c.id_concess
        WHERE v.plaque = :plaque
    ");
    
    $stmt->execute([':plaque' => $plaque]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Rechercher des véhicules par critères
 */
public function search($filters = [])
{
    $sql = "
        SELECT 
            v.*,
            c.nom as concession,
            c.adresse as concession_adresse
        FROM voiture v
        INNER JOIN concessionnaire c ON v.id_concess = c.id_concess
        WHERE 1=1
    ";
    
    $params = [];
    
    // Filtre par type
    if (!empty($filters['type'])) {
        $sql .= " AND v.type = :type";
        $params[':type'] = $filters['type'];
    }
    
    // Filtre par marque
    if (!empty($filters['marque'])) {
        $sql .= " AND v.marque LIKE :marque";
        $params[':marque'] = '%' . $filters['marque'] . '%';
    }
    
    // Filtre par prix max
    if (!empty($filters['prix_max'])) {
        $sql .= " AND v.prix_journalier <= :prix_max";
        $params[':prix_max'] = $filters['prix_max'];
    }
    
    // Filtre par prix min
    if (!empty($filters['prix_min'])) {
        $sql .= " AND v.prix_journalier >= :prix_min";
        $params[':prix_min'] = $filters['prix_min'];
    }
    
    // Tri
    $orderBy = " ORDER BY v.id_voiture DESC";
    
    if (!empty($filters['sort'])) {
        switch ($filters['sort']) {
            case 'price_asc':
                $orderBy = " ORDER BY v.prix_journalier ASC";
                break;
            case 'price_desc':
                $orderBy = " ORDER BY v.prix_journalier DESC";
                break;
            case 'marque_asc':
                $orderBy = " ORDER BY v.marque ASC, v.modele ASC";
                break;
            case 'marque_desc':
                $orderBy = " ORDER BY v.marque DESC, v.modele DESC";
                break;
            case 'recent':
                $orderBy = " ORDER BY v.id_voiture DESC";
                break;
            case 'oldest':
                $orderBy = " ORDER BY v.id_voiture ASC";
                break;
        }
    }
    
    $sql .= $orderBy;
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

/**
 * Récupère les statistiques d'un concessionnaire
 */
public function getStatsByConcessionnaire($idConcess): array
{
    // Nombre de véhicules
    $stmtVehicules = $this->db->prepare("
        SELECT COUNT(*) as nb_vehicules
        FROM voiture
        WHERE id_concess = :id_concess
    ");
    $stmtVehicules->execute([':id_concess' => $idConcess]);
    $nbVehicules = $stmtVehicules->fetch(PDO::FETCH_ASSOC)['nb_vehicules'];
    
    // Nombre de réservations en cours
    $stmtReservations = $this->db->prepare("
        SELECT COUNT(*) as nb_reservations
        FROM reservation r
        INNER JOIN annonce a ON r.id_annonce = a.id_annonce
        WHERE a.id_concess = :id_concess
        AND r.statut = 'PENDING'
    ");
    $stmtReservations->execute([':id_concess' => $idConcess]);
    $nbReservations = $stmtReservations->fetch(PDO::FETCH_ASSOC)['nb_reservations'];
    
    // Revenus estimés (réservations en cours)
    $stmtRevenus = $this->db->prepare("
        SELECT 
            COALESCE(SUM(
                DATEDIFF(r.date_fin, r.date_debut) * v.prix_journalier
            ), 0) as revenus_estimes
        FROM reservation r
        INNER JOIN annonce a ON r.id_annonce = a.id_annonce
        INNER JOIN voiture v ON a.id_voiture = v.id_voiture
        WHERE a.id_concess = :id_concess
        AND r.statut = 'PENDING'
    ");
    $stmtRevenus->execute([':id_concess' => $idConcess]);
    $revenusEstimes = $stmtRevenus->fetch(PDO::FETCH_ASSOC)['revenus_estimes'];
    
    return [
        'nb_vehicules' => (int)$nbVehicules,
        'nb_reservations' => (int)$nbReservations,
        'revenus_estimes' => (float)$revenusEstimes
    ];
}

/**
 * Récupérer un véhicule par son ID
 */
public function getById($idVoiture)
{
    $stmt = $this->db->prepare("
        SELECT v.*, c.nom as concession_nom
        FROM voiture v
        LEFT JOIN concessionnaire c ON v.id_concess = c.id_concess
        WHERE v.id_voiture = :id
    ");
    $stmt->execute([':id' => $idVoiture]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Mettre à jour un véhicule
 */
public function update($idVoiture, $marque, $modele, $type, $couleur, $prix, $image)
{
    $stmt = $this->db->prepare("
        UPDATE voiture 
        SET marque = :marque,
            modele = :modele,
            type = :type,
            couleur = :couleur,
            prix_journalier = :prix,
            image = :image
        WHERE id_voiture = :id
    ");

    return $stmt->execute([
        ':marque'  => $marque,
        ':modele'  => $modele,
        ':type'    => $type,
        ':couleur' => $couleur,
        ':prix'    => $prix,
        ':image'   => $image,
        ':id'      => $idVoiture
    ]);
}

/**
 * Vérifier si le véhicule a des réservations actives
 */
public function hasActiveReservations($idVoiture): bool
{
    $stmt = $this->db->prepare("
        SELECT COUNT(*) as count
        FROM reservation r
        INNER JOIN annonce a ON r.id_annonce = a.id_annonce
        WHERE a.id_voiture = :id_voiture
        AND r.statut IN ('PENDING', 'CONFIRMED')
        AND r.date_fin >= CURDATE()
    ");
    $stmt->execute([':id_voiture' => $idVoiture]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['count'] > 0;
}

/**
 * Supprimer un véhicule
 */
public function delete($idVoiture): bool
{
    try {
        // Démarrer une transaction
        $this->db->beginTransaction();
        
        // Supprimer les annonces liées (si pas de réservations)
        $stmt1 = $this->db->prepare("
            DELETE FROM annonce 
            WHERE id_voiture = :id_voiture
            AND id_annonce NOT IN (
                SELECT id_annonce FROM reservation 
                WHERE statut IN ('PENDING', 'CONFIRMED')
            )
        ");
        $stmt1->execute([':id_voiture' => $idVoiture]);
        
        // Supprimer le véhicule
        $stmt2 = $this->db->prepare("
            DELETE FROM voiture 
            WHERE id_voiture = :id_voiture
        ");
        $stmt2->execute([':id_voiture' => $idVoiture]);
        
        // Valider la transaction
        $this->db->commit();
        
        return true;
    } catch (Exception $e) {
        // Annuler en cas d'erreur
        $this->db->rollBack();
        error_log("Erreur suppression véhicule : " . $e->getMessage());
        return false;
    }
}

}

