<?php

require_once __DIR__ . '/../models/UserModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['mot_de_passe'])) {
                $error = "Email ou mot de passe incorrect";
            }
            elseif ((int)$user['email_verified'] !== 1) {
                $error = "Veuillez confirmer votre email avant de vous connecter";
            }
            else {
                // ✅ SESSION PROPRE
                $_SESSION['user'] = [
                    'id_user'    => $user['id_user'], // On utilise 'id_user' pour correspondre au SettingsController
                    'nom'        => $user['nom'],
                    'email'      => $user['email'],
                    'avatar_url' => $user['avatar_url'] ?? null // On utilise 'avatar_url' pour correspondre au header
                ];

                header('Location: index.php?page=home');
                exit;
            }
        }

        require __DIR__ . '/../views/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = $_POST['nom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->findByEmail($email)) {
                $error = "Un compte existe déjà avec cet email";
            }
            else {
                $token = bin2hex(random_bytes(32));
                $this->userModel->createWithToken($nom, $email, $password, $token);
                $this->sendConfirmationEmailDEV($email, $token);
            }
        }

        require __DIR__ . '/../views/register.php';
    }

    public function confirm()
    {
        $token = $_GET['token'] ?? null;

        if (!$token) {
            echo "Lien invalide";
            return;
        }

        $user = $this->userModel->findByToken($token);

        if (!$user) {
            echo "Lien invalide ou expiré";
            return;
        }

        $this->userModel->verifyEmail((int)$user['id_user']);

        echo "✅ Compte confirmé ! <a href='index.php?page=login'>Se connecter</a>";
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();

        header('Location: index.php?page=home');
        exit;
    }

    private function sendConfirmationEmailDEV(string $email, string $token): void
    {
        $link = BASE_URL . "/public/index.php?page=confirm&token=" . $token;

        echo "<h2>Email de confirmation (DEV)</h2>";
        echo "<p><a href='$link'>Confirmer mon compte</a></p>";
        exit;
    }
}
