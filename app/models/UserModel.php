<?php

require_once __DIR__ . '/Model.php';

class UserModel extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function createWithToken(string $nom, string $email, string $password, string $token): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
            INSERT INTO user (nom, email, mot_de_passe, email_token)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([$nom, $email, $hash, $token]);
    }

    public function findByToken(string $token): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch() ?: null;
    }

    public function verifyEmail(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE user
            SET email_verified = 1, email_token = NULL
            WHERE id_user = ?
        ");

        return $stmt->execute([$id]);
    }
}
