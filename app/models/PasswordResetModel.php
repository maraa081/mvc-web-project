<?php

require_once __DIR__ . '/Model.php';

class PasswordResetModel extends Model
{
    /**
     * Crée un nouveau token de réinitialisation
     */
    public function createResetToken($userId, $token, $expiresAt): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO password_reset (id_user, token, expires_at, created_at)
            VALUES (:id_user, :token, :expires_at, NOW())
        ");

        return $stmt->execute([
            ':id_user' => $userId,
            ':token' => $token,
            ':expires_at' => $expiresAt
        ]);
    }

    /**
     * Trouve un token valide (non utilisé et non expiré)
     */
    public function findValidToken($token): ?array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM password_reset
            WHERE token = :token
            AND used_at IS NULL
            AND expires_at > NOW()
            ORDER BY created_at DESC
            LIMIT 1
        ");

        $stmt->execute([':token' => $token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    /**
     * Marque un token comme utilisé
     */
    public function markTokenAsUsed($resetId): bool
    {
        $stmt = $this->db->prepare("
            UPDATE password_reset
            SET used_at = NOW()
            WHERE id_reset = :id_reset
        ");

        return $stmt->execute([':id_reset' => $resetId]);
    }

    /**
     * Supprime les tokens expirés (nettoyage)
     */
    public function deleteExpiredTokens(): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM password_reset
            WHERE expires_at < NOW()
            OR used_at IS NOT NULL
        ");

        return $stmt->execute();
    }

    /**
     * Vérifie si un utilisateur a déjà un token valide
     */
    public function hasValidToken($userId): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count FROM password_reset
            WHERE id_user = :id_user
            AND used_at IS NULL
            AND expires_at > NOW()
        ");

        $stmt->execute([':id_user' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }
}