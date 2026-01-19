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

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function createWithToken(string $nom, string $email, string $password, string $token, string $role = 'client')
{
    $stmt = $this->db->prepare("
        INSERT INTO user (nom, email, mot_de_passe, email_token, role)
        VALUES (:nom, :email, :password, :token, :role)
    ");

    return $stmt->execute([
        ':nom'      => $nom,
        ':email'    => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
        ':token'    => $token,
        ':role'     => $role
    ]);
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


/**
 * Met à jour le mot de passe d'un utilisateur
 */
public function updatePassword($userId, $hashedPassword): bool
{
    $stmt = $this->db->prepare("
        UPDATE user 
        SET mot_de_passe = :password 
        WHERE id_user = :id_user
    ");
    
    return $stmt->execute([
        ':password' => $hashedPassword,
        ':id_user' => $userId
    ]);
}

    public function storeRememberToken(int $userId, string $token): bool
    {
        $stmt = $this->db->prepare("
            UPDATE user 
            SET remember_token = :token 
            WHERE id_user = :id_user
        ");

        return $stmt->execute([
            ':token'   => $token,
            ':id_user' => $userId
        ]);
    }

    public function findByRememberToken(string $token): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE remember_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch() ?: null;
    }

    public function clearRememberToken(string $token): bool
    {
        $stmt = $this->db->prepare("
            UPDATE user 
            SET remember_token = NULL 
            WHERE remember_token = ?
        ");

        return $stmt->execute([$token]);
    }

    public function createWithTokenConcessionnaire(string $entreprise, string $siret, string $email, string $password, string $token)
{
    $stmt = $this->db->prepare("
        INSERT INTO user (nom, siret, email, mot_de_passe, email_token, role)
        VALUES (:entreprise, :siret, :email, :password, :token, 'concessionnaire')
    ");

    return $stmt->execute([
        ':entreprise' => $entreprise,
        ':siret'      => $siret,
        ':email'      => $email,
        ':password'   => password_hash($password, PASSWORD_DEFAULT),
        ':token'      => $token
    ]);
}

public function createConcessionnaireUser(string $entreprise, string $email, string $password, string $token): int|false
{
    // Vérifier si email déjà utilisé
    $stmt = $this->db->prepare("SELECT id_user FROM user WHERE email = :email");
    $stmt->execute([':email' => $email]);

    if ($stmt->fetch()) {
        return false;
    }

    // Insérer le user
    $stmt = $this->db->prepare("
        INSERT INTO user (nom, email, mot_de_passe, email_token, email_verified, role)
        VALUES (:nom, :email, :password, :token, 0, 'concessionnaire')
    ");

    $stmt->execute([
        ':nom'      => $entreprise,
        ':email'    => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
        ':token'    => $token
    ]);

    return $this->db->lastInsertId();
}

/**
 * Créer un utilisateur concessionnaire avec SIRET
 */
public function createConcessionnaireUserWithSiret(
    string $entreprise, 
    string $siret, 
    string $email, 
    string $password, 
    string $token
): int|false {
    // Vérifier si email déjà utilisé
    if ($this->findByEmail($email)) {
        return false;
    }

    // Vérifier si SIRET déjà utilisé
    if ($this->findBySiret($siret)) {
        return false;
    }

    // Insérer le user
    $stmt = $this->db->prepare("
        INSERT INTO user (nom, siret, email, mot_de_passe, email_token, email_verified, role)
        VALUES (:nom, :siret, :email, :password, :token, 0, 'concessionnaire')
    ");

    $result = $stmt->execute([
        ':nom'      => $entreprise,
        ':siret'    => $siret,
        ':email'    => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
        ':token'    => $token
    ]);

    return $result ? (int)$this->db->lastInsertId() : false;
}

/**
 * Trouver un utilisateur par SIRET
 */
public function findBySiret(string $siret): ?array
{
    $stmt = $this->db->prepare("SELECT * FROM user WHERE siret = ?");
    $stmt->execute([$siret]);
    return $stmt->fetch() ?: null;
}


}
