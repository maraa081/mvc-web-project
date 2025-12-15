<?php
// User.php
class User {
    private $conn;
    private $table_name = "user";

    public $id_user;
    public $nom;
    public $email;
    public $mot_de_passe;
    public $is_active;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer un nouvel utilisateur
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nom=:nom, email=:email, mot_de_passe=:mot_de_passe";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_BCRYPT);
        
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mot_de_passe", $this->mot_de_passe);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Vérifier si l'email existe
    public function emailExists() {
        $query = "SELECT id_user, nom, email, mot_de_passe, is_active 
                  FROM " . $this->table_name . " 
                  WHERE email = :email 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id_user = $row['id_user'];
            $this->nom = $row['nom'];
            $this->email = $row['email'];
            $this->mot_de_passe = $row['mot_de_passe'];
            $this->is_active = $row['is_active'];
            return true;
        }
        
        return false;
    }

    // Connexion utilisateur
    public function login($password) {
        if($this->emailExists()) {
            if(password_verify($password, $this->mot_de_passe)) {
                if($this->is_active) {
                    return true;
                }
            }
        }
        return false;
    }
}
?>