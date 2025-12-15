<?php
session_start();
include_once 'database.php';

// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assurez-vous que Composer a créé ce fichier

// Obtenir la connexion PDO
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        die("Email invalide.");
    }

    // Vérifier si l'email existe
    $stmt = $conn->prepare("SELECT id_user FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Générer un token unique
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Mettre à jour le token en BDD
        $updateStmt = $conn->prepare("UPDATE user SET reset_token=:token, reset_expiry=:expiry WHERE email=:email");
        $updateStmt->bindParam(':token', $token);
        $updateStmt->bindParam(':expiry', $expiry);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->execute();

        // Créer le lien de réinitialisation
        $resetLink = "http://localhost/rentium/reset_password.php?token=" . $token;

        // Envoyer le mail via PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Paramètres SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'timdore2705@gmail.com';        // Remplace par ton email
            $mail->Password   = 'kxwoqazeervfafaj';           // Mot de passe ou App Password Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Destinataire et expéditeur
            $mail->setFrom('no-reply@vtcrentium.com', 'VTC Rentium');
            $mail->addAddress($email);

            // Contenu
            $mail->isHTML(false);
            $mail->Subject = 'Réinitialisation de votre mot de passe - VTC Rentium';
            $mail->Body    = "Bonjour,\n\nPour réinitialiser votre mot de passe, cliquez sur le lien suivant :\n$resetLink\n\nCe lien est valable 1 heure.\n\nSi vous n'avez pas demandé cette réinitialisation, ignorez ce mail.";

            $mail->send();
            echo "Si l'email existe, un lien de réinitialisation a été envoyé.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi du mail: {$mail->ErrorInfo}";
        }

    } else {
        // Message générique pour éviter de révéler si l'email existe
        echo "Si l'email existe, un lien de réinitialisation a été envoyé.";
    }
}
?>
