<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ClientModel.php';

class AuthController {
    private $userModel;
    private $clientModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->clientModel = new ClientModel();
    }

    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            // 1. Chercher user
            $user = $this->userModel->findByEmail($email);

            // 2. Vérifier password (CORRECTION MAJEURE ICI : 'mot_de_passe')
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                
                // 3. Récupérer détails
                $details = $this->clientModel->getUserFullInfo($user['id_user']);
                
                $fullUserData = $user;
                if ($details) {
                    $fullUserData = array_merge($user, $details);
                }

                $_SESSION['user'] = $fullUserData;
                
                // Redirection vers l'accueil
                header('Location: index.php?page=home');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        }
        require __DIR__ . '/../views/login.php';
    }

    public function register() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars($_POST['nom'] ?? '');
            $prenom = htmlspecialchars($_POST['prenom'] ?? '');
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires.";
            }
            elseif ($password !== $confirm) {
                $error = "Les mots de passe ne correspondent pas.";
            }
            elseif ($this->userModel->findByEmail($email)) {
                $error = "Cet email est déjà utilisé.";
            }
            else {
                // Création Compte
                $userId = $this->userModel->create([
                    'nom' => $nom,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);

                if ($userId) {
                    // Création Profil
                    $this->clientModel->createInitialProfile($userId, $prenom);

                    // Connexion Auto
                    $_SESSION['user'] = [
                        'id_user' => $userId,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'email' => $email,
                        'role' => 'client'
                    ];
                    
                    header('Location: index.php?page=settings');
                    exit;
                } else {
                    $error = "Erreur technique lors de l'inscription.";
                }
            }
        }
        require __DIR__ . '/../views/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?page=home');
        exit;
    }
}