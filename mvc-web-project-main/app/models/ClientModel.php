<?php
require_once __DIR__ . '/Model.php';

class ClientModel extends Model
{
    public function getUserFullInfo(int $id_user)
    {
        // Sélectionne toutes les infos
        $stmt = $this->db->prepare("
            SELECT u.id_user, u.nom, u.email, u.created_at, u.avatar_url,
                   d.prenom, d.telephone, d.bio, d.adresse, d.ville, d.code_postal, 
                   d.date_naissance, d.genre, d.facebook, d.twitter, d.linkedin, d.email_secours,
                   d.notif_email, d.notif_sms
            FROM user u
            LEFT JOIN user_details d ON u.id_user = d.id_user
            WHERE u.id_user = ?
        ");
        $stmt->execute([$id_user]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createInitialProfile($userId, $prenom) {
        try {
            // On insère l'ID USER et le PRENOM dans la table user_details
            $sql = "INSERT INTO user_details (id_user, prenom) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$userId, $prenom]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateFullInfo(int $id_user, array $data): bool
    {
        try {
            $this->db->beginTransaction();
            // 1. Mise à jour de la table USER (Avatar seulement si fourni)
            if (!empty($data['avatar_url'])) {
                $sqlUser = "UPDATE user SET avatar_url = :avatar WHERE id_user = :id";
                $stmtUser = $this->db->prepare($sqlUser);
                $stmtUser->execute([
                    ':avatar' => $data['avatar_url'],
                    ':id' => $data['id_user']
                ]);
            }

            // 2. Mise à jour de la table USER_DETAILS
            // On vérifie d'abord si une ligne existe dans user_details
            $checkSql = "SELECT id_detail FROM user_details WHERE id_user = ?";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([$data['id_user']]);
            $exists = $checkStmt->fetch();

            if ($exists) {
                // UPDATE si la ligne existe
                $sqlDetails = "UPDATE user_details SET 
                    ville = :ville, 
                    code_postal = :code_postal, 
                    telephone = :telephone, 
                    date_naissance = :date_naissance, 
                    genre = :genre,
                    facebook = :facebook,
                    twitter = :twitter,
                    linkedin = :linkedin,
                    email_secours = :email_secours,
                    notif_email = :notif_email,
                    notif_sms = :notif_sms
                    WHERE id_user = :id_user";
            } else {
                // INSERT si elle n'existe pas (Cas d'un vieux compte ou erreur inscription)
                $sqlDetails = "INSERT INTO user_details 
                    (id_user, ville, code_postal, telephone, date_naissance, genre, facebook, twitter, linkedin, email_secours, notif_email, notif_sms)
                    VALUES 
                    (:id_user, :ville, :code_postal, :telephone, :date_naissance, :genre, :facebook, :twitter, :linkedin, :email_secours, :notif_email, :notif_sms)";
            }

            $stmt = $this->db->prepare($sqlDetails);
            
            // On exécute avec toutes les données
            $res = $stmt->execute([
                ':id_user' => $data['id_user'],
                ':ville' => $data['ville'] ?? '',
                ':code_postal' => $data['code_postal'] ?? '',
                ':telephone' => $data['telephone'] ?? '',
                ':date_naissance' => !empty($data['date_naissance']) ? $data['date_naissance'] : null,
                ':genre' => $data['genre'] ?? 'Non spécifié',
                ':facebook' => $data['facebook'] ?? '',
                ':twitter' => $data['twitter'] ?? '',
                ':linkedin' => $data['linkedin'] ?? '',
                ':email_secours' => $data['email_secours'] ?? '',
                ':notif_email' => isset($data['notif_email']) ? 1 : 0,
                ':notif_sms' => isset($data['notif_sms']) ? 1 : 0
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updatePassword(int $id_user, string $new_password): bool
    {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE user SET mot_de_passe = ? WHERE id_user = ?");
        return $stmt->execute([$hash, $id_user]);
    }

    public function verifyPassword(int $id_user, string $password): bool
    {
        $stmt = $this->db->prepare("SELECT mot_de_passe FROM user WHERE id_user = ?");
        $stmt->execute([$id_user]);
        $user = $stmt->fetch();
        return $user && password_verify($password, $user['mot_de_passe']);
    }

    public function updateAvatar(int $id, ?string $path): bool
    {
        // Méthode utilisée uniquement pour la suppression ou l'upload direct (si besoin)
        $stmt = $this->db->prepare("UPDATE user SET avatar_url = ? WHERE id_user = ?");
        return $stmt->execute([$path, $id]);
    }
    
    public function createEmptyProfile($userId) {
        $sql = "INSERT INTO user_details (id_user) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId]);
    }
}