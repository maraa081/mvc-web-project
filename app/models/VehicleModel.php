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

    /**
     * Méthode de recherche avec filtres multiples avancés
     */
    public function search($filters): array
    {
        $query = "SELECT v.*, c.nom AS concession 
                  FROM voiture v 
                  JOIN concessionnaire c ON v.id_concess = c.id_concess 
                  WHERE 1=1";
        $params = [];

        // ==========================================
        // FILTRES
        // ==========================================

        // Filtre par TYPE (Berline, SUV, Citadine, Électrique...)
        if (!empty($filters['type'])) {
            $query .= " AND v.type = :type";
            $params[':type'] = $filters['type'];
        }

        // Filtre par PRIX MAXIMUM
        if (!empty($filters['maxPrice'])) {
            $query .= " AND v.prix_journalier <= :maxPrice";
            $params[':maxPrice'] = $filters['maxPrice'];
        }

        // Filtre par MARQUES (plusieurs possibles)
        if (!empty($filters['marques']) && is_array($filters['marques'])) {
            $placeholders = [];
            foreach ($filters['marques'] as $index => $marque) {
                $key = ':marque' . $index;
                $placeholders[] = $key;
                $params[$key] = $marque;
            }
            $query .= " AND v.marque IN (" . implode(',', $placeholders) . ")";
        }

        // Filtre par COULEURS (plusieurs possibles)
        if (!empty($filters['couleurs']) && is_array($filters['couleurs'])) {
            $placeholders = [];
            foreach ($filters['couleurs'] as $index => $couleur) {
                $key = ':couleur' . $index;
                $placeholders[] = $key;
                $params[$key] = $couleur;
            }
            $query .= " AND v.couleur IN (" . implode(',', $placeholders) . ")";
        }

        // Filtre par CONCESSION (plusieurs possibles)
        if (!empty($filters['concessions']) && is_array($filters['concessions'])) {
            $placeholders = [];
            foreach ($filters['concessions'] as $index => $concession) {
                $key = ':concession' . $index;
                $placeholders[] = $key;
                $params[$key] = $concession;
            }
            $query .= " AND c.nom IN (" . implode(',', $placeholders) . ")";
        }

        // ==========================================
        // TRIS
        // ==========================================
        $sort = $filters['sortBy'] ?? 'price_asc';
        
        switch ($sort) {
            case 'price_asc':  
                $query .= " ORDER BY v.prix_journalier ASC"; 
                break;
            
            case 'price_desc': 
                $query .= " ORDER BY v.prix_journalier DESC"; 
                break;
            
            case 'marque_asc': 
                $query .= " ORDER BY v.marque ASC, v.modele ASC"; 
                break;
            
            case 'marque_desc': 
                $query .= " ORDER BY v.marque DESC, v.modele DESC"; 
                break;
            
            case 'recent':     
                $query .= " ORDER BY v.id_voiture DESC"; 
                break;
            
            case 'oldest':     
                $query .= " ORDER BY v.id_voiture ASC"; 
                break;
            
            default:           
                $query .= " ORDER BY v.prix_journalier ASC";
        }

        // Exécution de la requête
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouve un véhicule par sa plaque
     */
    public function find($plaque)
    {
        $stmt = $this->db->prepare("
            SELECT v.*, c.nom AS concession 
            FROM voiture v 
            JOIN concessionnaire c ON v.id_concess = c.id_concess 
            WHERE v.plaque = :plaque
        ");
        $stmt->execute([':plaque' => $plaque]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère toutes les marques disponibles (pour les filtres)
     */
    public function getAllMarques(): array
    {
        $stmt = $this->db->query("SELECT DISTINCT marque FROM voiture ORDER BY marque ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Récupère toutes les couleurs disponibles
     */
    public function getAllCouleurs(): array
    {
        $stmt = $this->db->query("SELECT DISTINCT couleur FROM voiture ORDER BY couleur ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Récupère tous les types de véhicules
     */
    public function getAllTypes(): array
    {
        $stmt = $this->db->query("SELECT DISTINCT type FROM voiture ORDER BY type ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}