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

    public function updateFullInfo(int $id_user, array $data): bool
    {
        try {
            $this->db->beginTransaction();

            // 1. Mise à jour de la table USER 
            $stmt1 = $this->db->prepare("
                UPDATE user 
                SET nom = ?, email = ?, avatar_url = ? 
                WHERE id_user = ?
            ");
            
            // On passe bien l'avatar_url en 3ème paramètre
            $stmt1->execute([
                $data['nom'], 
                $data['email'], 
                $data['avatar_url'], 
                $id_user
            ]);

            // 2. Mise à jour de la table USER_DETAILS
            $check = $this->db->prepare("SELECT id_detail FROM user_details WHERE id_user = ?");
            $check->execute([$id_user]);
            
            if ($check->fetch()) {
                $sql = "UPDATE user_details SET prenom=?, telephone=?, ville=?, code_postal=?, date_naissance=?, genre=?, facebook=?, twitter=?, linkedin=?, email_secours=?, notif_email=?, notif_sms=? WHERE id_user=?";
            } else {
                $sql = "INSERT INTO user_details (prenom, telephone, ville, code_postal, date_naissance, genre, facebook, twitter, linkedin, email_secours, notif_email, notif_sms, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            }

            $stmt2 = $this->db->prepare($sql);
            $stmt2->execute([
                $data['prenom'] ?? '', 
                $data['telephone'] ?? '', 
                $data['ville'] ?? '', 
                $data['code_postal'] ?? '', 
                $data['date_naissance'] ?? NULL, 
                $data['genre'] ?? '', 
                $data['facebook'] ?? '', 
                $data['twitter'] ?? '', 
                $data['linkedin'] ?? '',
                $data['email_secours'] ?? '', 
                $data['notif_email'] ?? 1, 
                $data['notif_sms'] ?? 0, 
                $id_user
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
}