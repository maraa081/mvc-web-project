<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ConcessionnaireModel.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
        // Auto-login via remember me
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
            $user = $this->userModel->findByRememberToken($_COOKIE['remember_token']);
            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id'    => $user['id_user'],
                    'nom'   => htmlspecialchars($user['nom']),
                    'email' => htmlspecialchars($user['email']),
                    'avatar'=> $user['avatar_url'] ?? null
                ];
                header('Location: index.php?page=home');
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Vérification CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Requête invalide.";
                require __DIR__ . '/../views/login.php';
                return;
            }

            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            // 🔐 Initialiser la structure globale des tentatives
            if (!isset($_SESSION['login_attempts']) || !is_array($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = [];
            }

            // 🔐 Initialiser compteur pour cet email
            if (!isset($_SESSION['login_attempts'][$email])) {
                $_SESSION['login_attempts'][$email] = 0;
            }

            // 🔐 Vérifier si cet email est bloqué
            if ($_SESSION['login_attempts'][$email] >= 5) {
                $_SESSION['error'] = "Trop de tentatives pour cet email. Réessayez plus tard.";
                require __DIR__ . '/../views/login.php';
                return;
            }

            $user = $this->userModel->findByEmail($email);

            // ❌ Identifiants incorrects
            if (!$user || !password_verify($password, $user['mot_de_passe'])) {

                $_SESSION['login_attempts'][$email]++;

                $remaining = 5 - $_SESSION['login_attempts'][$email];

                if ($remaining <= 0) {
                    $_SESSION['error'] = "Trop de tentatives pour cet email. Réessayez plus tard.";
                } else {
                    $_SESSION['error'] = "Identifiants incorrects. Tentatives restantes : $remaining";
                }

            }
            // ❌ Email non confirmé
            elseif ((int)$user['email_verified'] !== 1) {

                $_SESSION['error'] = "Veuillez confirmer votre email avant de vous connecter.";

            }
            // ✔️ Succès
            else {

                // Reset compteur
                $_SESSION['login_attempts'][$email] = 0;

                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id'    => $user['id_user'],
                    'nom'   => htmlspecialchars($user['nom']),
                    'email' => htmlspecialchars($user['email']),
                    'role'  => $user['role'],
                    'avatar'=> $user['avatar_url'] ?? null
                ];

                // Remember me
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $this->userModel->storeRememberToken($user['id_user'], $token);

                    setcookie(
                        'remember_token',
                        $token,
                        [
                            'expires'  => time() + 60 * 60 * 24 * 30,
                            'path'     => '/',
                            'secure'   => true,
                            'httponly' => true,
                            'samesite' => 'Strict'
                        ]
                    );
                }

                header('Location: index.php?page=home');
                exit;
            }
        }

        require __DIR__ . '/../views/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Requête invalide.";
                require __DIR__ . '/../views/register.php';
                return;
            }

            $nom = trim($_POST['nom'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if ($password !== $passwordConfirm) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($password) < 8) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères.";
            } elseif ($this->userModel->findByEmail($email)) {
                $_SESSION['error'] = "Un compte existe déjà avec cet email.";
            } else {
                $token = bin2hex(random_bytes(32));
                $this->userModel->createWithToken($nom, $email, $password, $token);
                $this->sendConfirmationEmail($email, $token, 'client');
            }
        }

        require __DIR__ . '/../views/register.php';
    }

    public function confirm()
{
    $token = $_GET['token'] ?? null;

    if (!$token) {
        $_SESSION['error'] = "Lien invalide.";
        header("Location: index.php?page=login");
        exit;
    }

    $user = $this->userModel->findByToken($token);

    if (!$user) {
        $_SESSION['error'] = "Lien invalide ou expiré.";
        header("Location: index.php?page=login");
        exit;
    }

    // Confirmer l'email
    $this->userModel->verifyEmail((int)$user['id_user']);

    // Message affiché dans la vue
    $_SESSION['success'] = "Votre compte a été confirmé ! Vous pouvez maintenant vous connecter.";

    // 🔥 Redirection selon le rôle
    if ($user['role'] === 'concessionnaire') {
        header("Location: index.php?page=login_concessionnaire");
    } else {
        header("Location: index.php?page=login");
    }

    exit;
}


    public function logout()
    {
        // Supprimer le remember me
        if (isset($_COOKIE['remember_token'])) {
            $this->userModel->clearRememberToken($_COOKIE['remember_token']);
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }

        $_SESSION = [];
        session_destroy();

        header('Location: index.php?page=home');
        exit;
    }

   private function sendConfirmationEmail(string $email, string $token, string $role): void
{
    require_once __DIR__ . '/../../vendor/autoload.php';

    $mailConfig = require __DIR__ . '/../config/mail.php';

    $link = BASE_URL . "/public/index.php?page=confirm&token=" . $token;

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $mailConfig['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailConfig['username'];
        $mail->Password   = $mailConfig['password'];
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $mailConfig['port'];

        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Confirmez votre compte VTC Rentium";
        $mail->Body = "
            <h2>Bienvenue chez VTC Rentium !</h2>
            <p>Merci de vous être inscrit. Cliquez sur le lien ci-dessous pour confirmer votre compte :</p>
            <p><a href='$link' style='color: #1a73e8;'>Confirmer mon compte</a></p>
            <p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>
        ";

        $mail->send();

        $_SESSION['success'] = "Un email de confirmation vous a été envoyé.";

    } catch (Exception $e) {
        $_SESSION['confirm_link'] = $link;
        $_SESSION['error'] = "Impossible d'envoyer l'email. Mode DEV activé : utilisez le lien ci-dessous.";
    }

    // 🔥 REDIRECTION SELON LE RÔLE
    if ($role === 'concessionnaire') {
        header("Location: index.php?page=register_concessionnaire");
    } else {
        header("Location: index.php?page=register");
    }

    exit;
}

private ConcessionnaireModel $concessionnaireModel;
public function registerConcessionnaire()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $this->concessionnaireModel = new ConcessionnaireModel();

        // Récupération des champs
        $entreprise = trim($_POST['entreprise'] ?? '');
        $siret      = trim($_POST['siret'] ?? ''); // ✅ AJOUT du SIRET
        $adresse    = trim($_POST['adresse'] ?? '');
        $email      = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password   = $_POST['password'] ?? '';
        $password2  = $_POST['password_confirm'] ?? '';
        $latitude   = trim($_POST['latitude'] ?? null);
        $longitude  = trim($_POST['longitude'] ?? null);

        // CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Requête invalide.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        // Vérifications
        if (!$entreprise || !$siret || !$adresse || !$email || !$password) {
            $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        // ✅ VALIDATION DU SIRET
        if (!$this->isValidSiret($siret)) {
            $_SESSION['error'] = "Le numéro SIRET est invalide.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email invalide.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        if ($password !== $password2) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        if (strlen($password) < 8) {
            $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        // ✅ Vérifier si email déjà utilisé
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = "Un compte existe déjà avec cet email.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        // ✅ Vérifier si SIRET déjà utilisé
        $existingSiret = $this->userModel->findBySiret($siret);
        if ($existingSiret) {
            $_SESSION['error'] = "Ce numéro SIRET est déjà enregistré.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        // Token de confirmation
        $token = bin2hex(random_bytes(32));

        // ✅ Création du compte user avec SIRET
        $idUser = $this->userModel->createConcessionnaireUserWithSiret(
            $entreprise,
            $siret,
            $email,
            $password,
            $token
        );

        if (!$idUser) {
            $_SESSION['error'] = "Erreur lors de la création du compte utilisateur.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        // Création de l'entrée concessionnaire
        $idConcess = $this->concessionnaireModel->create(
            $entreprise,
            $adresse,
            $email,
            $latitude,
            $longitude
        );

        if (!$idConcess) {
            $_SESSION['error'] = "Erreur lors de la création du profil concessionnaire.";
            require __DIR__ . '/../views/register_concessionnaire.php';
            return;
        }

        // Envoi de l'email de confirmation
        $this->sendConfirmationEmail($email, $token, 'concessionnaire');
        exit;
    }

    require __DIR__ . '/../views/register_concessionnaire.php';
}


public function loginConcessionnaire()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Requête invalide.";
            require __DIR__ . '/../views/login_concessionnaire.php';
            return;
        }

        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if (!$user || $user['role'] !== 'concessionnaire') {
            $_SESSION['error'] = "Aucun compte concessionnaire trouvé avec cet email.";
            // ✅ CORRECTION: require au lieu de header
            require __DIR__ . '/../views/login_concessionnaire.php';
            return;
        } 
        
        if (!password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['error'] = "Mot de passe incorrect.";
            require __DIR__ . '/../views/login_concessionnaire.php';
            return;
        } 
        
        if ((int)$user['email_verified'] !== 1) { 
            $_SESSION['error'] = "Veuillez confirmer votre email avant de vous connecter.";
            require __DIR__ . '/../views/login_concessionnaire.php';
            return;
        }
        
        // ✅ Connexion réussie
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id'    => $user['id_user'],
            'nom'   => htmlspecialchars($user['nom']),
            'email' => htmlspecialchars($user['email']),
            'role'  => $user['role'],
            'avatar'=> $user['avatar_url'] ?? null
        ];

        header('Location: index.php?page=dashboard_concessionnaire');
        exit;
    }

    require __DIR__ . '/../views/login_concessionnaire.php';
}

public function dashboardConcessionnaire()
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'concessionnaire') {
        header('Location: index.php?page=login_concessionnaire');
        exit;
    }

    // ✅ Récupérer les statistiques
    require_once __DIR__ . '/../models/VoitureModel.php';
    require_once __DIR__ . '/../models/ConcessionnaireModel.php';
    
    $voitureModel = new VoitureModel();
    $concessionnaireModel = new ConcessionnaireModel();
    
    // Récupérer l'ID du concessionnaire
    $concessionnaire = $concessionnaireModel->getByUserId($_SESSION['user']['id']);
    
    if (!$concessionnaire) {
        $_SESSION['error'] = "Profil concessionnaire non trouvé.";
        header('Location: index.php?page=logout');
        exit;
    }
    
    $idConcess = $concessionnaire['id_concess'];
    
    // ✅ Récupérer les statistiques
    $stats = $voitureModel->getStatsByConcessionnaire($idConcess);
    
    require __DIR__ . '/../views/dashboard_concessionnaire.php';
}

public function forgotPasswordConcessionnaire()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Requête invalide.";
            require __DIR__ . '/../views/forgot_password_concessionnaire.php';
            return;
        }

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $user = $this->userModel->findByEmail($email);

        if (!$user || $user['role'] !== 'concessionnaire') {
            $_SESSION['error'] = "Aucun compte concessionnaire trouvé avec cet email.";
        } else {
            $token = bin2hex(random_bytes(32));
            $this->userModel->storeResetToken($user['id_user'], $token);

            $this->sendResetPasswordEmail($email, $token);

            $_SESSION['success'] = "Un email de réinitialisation vous a été envoyé.";
        }
    }

    require __DIR__ . '/../views/forgot_password_concessionnaire.php';
}

private function isValidSiret(string $siret): bool
{
    // Doit faire 14 chiffres
    if (!preg_match('/^[0-9]{14}$/', $siret)) {
        return false;
    }

    // Vérification Luhn
    $sum = 0;
    for ($i = 0; $i < 14; $i++) {
        $digit = (int)$siret[$i];

        if ($i % 2 === 0) { 
            $digit *= 2;
            if ($digit > 9) {
                $digit -= 9;
            }
        }

        $sum += $digit;
    }

    return $sum % 10 === 0;
}


}
