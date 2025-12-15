<?php

class UserModel extends Model
{
    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO user (nom, email, mot_de_passe)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['nom'],
            $data['email'],
            password_hash($data['mot_de_passe'], PASSWORD_BCRYPT)
        ]);
    }

    public function find(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function all()
    {
        return $this->db->query("SELECT * FROM user")->fetchAll();
    }
}
