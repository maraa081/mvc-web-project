<?php
require_once __DIR__ . '/Model.php';

class UserModel extends Model {

    public function findByEmail($email) {
        $sql = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        try {
            // CORRECTION : On cible 'mot_de_passe'
            $sql = "INSERT INTO user (nom, email, mot_de_passe, is_active, created_at, email_verified) 
                    VALUES (:nom, :email, :password, 1, NOW(), 1)";
            
            $stmt = $this->db->prepare($sql);

            $result = $stmt->execute([
                ':nom' => $data['nom'],
                ':email' => $data['email'],
                ':password' => $data['password'] // Le hash va dans mot_de_passe
            ]);

            if ($result) {
                return $this->db->lastInsertId();
            }
            return false;

        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}