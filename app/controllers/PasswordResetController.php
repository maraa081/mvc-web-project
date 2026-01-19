<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PasswordResetModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';


class PasswordResetController
{
    private UserModel $userModel;
    private PasswordResetModel $resetModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->resetModel = new PasswordResetModel();
    }

    /**
     * Affiche le formulaire "Mot de passe oublié"
     */
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleForgotPassword();
        } else {
            require __DIR__ . '/../views/forgot_password.php';
        }
    }

    /**
     * Traite la demande de réinitialisation
     */
    private function handleForgotPassword()
    {
        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['forgot_error'] = "Veuillez entrer votre adresse email.";
            header('Location: ' . BASE_URL . '/public/index.php?page=forgot_password');
            exit;
        }

        // Vérifier si l'utilisateur existe
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            // Pour la sécurité, on affiche le même message même si l'email n'existe pas
            $_SESSION['forgot_success'] = "Si cet email existe, vous recevrez un lien de réinitialisation.";
            header('Location: ' . BASE_URL . '/public/index.php?page=forgot_password');
            exit;
        }

        // Générer un token unique
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Sauvegarder le token en base
        $this->resetModel->createResetToken($user['id_user'], $token, $expiresAt);

        // Créer le lien de réinitialisation
        $resetLink = BASE_URL . "/public/index.php?page=reset_password&token=" . $token;

        // Envoyer l'email
        $emailSent = $this->sendResetEmail($email, $user['nom'], $resetLink);

        if ($emailSent) {
            $_SESSION['forgot_success'] = "Un email de réinitialisation a été envoyé à votre adresse.";
            
            // MODE DEV : Afficher le lien directement
            if (defined('DEV_MODE') && DEV_MODE === true) {
                $_SESSION['reset_link'] = $resetLink;
            }
        } else {
            $_SESSION['forgot_error'] = "Erreur lors de l'envoi de l'email. Veuillez réessayer.";
        }

        header('Location: ' . BASE_URL . '/public/index.php?page=forgot_password');
        exit;
    }

    /**
     * Affiche le formulaire de réinitialisation (avec token)
     */
    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleResetPassword();
        } else {
            $token = $_GET['token'] ?? '';

            if (empty($token)) {
                $_SESSION['reset_error'] = "Lien invalide.";
                header('Location: ' . BASE_URL . '/public/index.php?page=login');
                exit;
            }

            // Vérifier la validité du token
            $resetData = $this->resetModel->findValidToken($token);

            if (!$resetData) {
                $_SESSION['reset_error'] = "Ce lien de réinitialisation est invalide ou expiré.";
                header('Location: ' . BASE_URL . '/public/index.php?page=forgot_password');
                exit;
            }

            require __DIR__ . '/../views/reset_password.php';
        }
    }

    /**
     * Traite le changement de mot de passe
     */
    private function handleResetPassword()
    {
        $token = $_GET['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Validation
        if (empty($password) || empty($passwordConfirm)) {
            $_SESSION['reset_error'] = "Tous les champs sont obligatoires.";
            header('Location: ' . BASE_URL . '/public/index.php?page=reset_password&token=' . $token);
            exit;
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['reset_error'] = "Les mots de passe ne correspondent pas.";
            header('Location: ' . BASE_URL . '/public/index.php?page=reset_password&token=' . $token);
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['reset_error'] = "Le mot de passe doit contenir au moins 8 caractères.";
            header('Location: ' . BASE_URL . '/public/index.php?page=reset_password&token=' . $token);
            exit;
        }

        // Vérifier le token
        $resetData = $this->resetModel->findValidToken($token);

        if (!$resetData) {
            $_SESSION['reset_error'] = "Ce lien de réinitialisation est invalide ou expiré.";
            header('Location: ' . BASE_URL . '/public/index.php?page=forgot_password');
            exit;
        }

        // Mettre à jour le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->updatePassword($resetData['id_user'], $hashedPassword);

        // Marquer le token comme utilisé
        $this->resetModel->markTokenAsUsed($resetData['id_reset']);

        $_SESSION['success'] = "Votre mot de passe a été réinitialisé avec succès !";
        header('Location: ' . BASE_URL . '/public/index.php?page=login');
        exit;
    }

    /**
     * Envoie l'email de réinitialisation
     */
    private function sendResetEmail($to, $name, $resetLink): bool
{
    $mail = new PHPMailer(true);
    
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'timdore2705@gmail.com';
        $mail->Password = 'kxwoqazeervfafaj'; // Mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Expéditeur et destinataire
        $mail->setFrom('noreply@rentium.com', 'Rentium');
        $mail->addAddress($to, $name);
        
        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Reinitialisation de votre mot de passe - Rentium';
        $mail->Body = "
    <h2>Réinitialisation de votre mot de passe</h2>
    <p>Bonjour $name,</p>
    <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien ci-dessous :</p>
    <p>
        <a href='$resetLink' 
           style='display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>
           Réinitialiser mon mot de passe
        </a>
    </p>
    <p>Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet email.</p>
    <p>— L'équipe Rentium</p>
";

        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur email : " . $mail->ErrorInfo);
        return false;
    }
}
}