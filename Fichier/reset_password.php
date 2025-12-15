<?php
include_once 'database.php';

if (!isset($_GET['token'])) {
    die("Token manquant.");
}

$token = $_GET['token'];

// Obtenir la connexion PDO
$database = new Database();
$conn = $database->getConnection();

// Vérifier le token et sa validité
$stmt = $conn->prepare("SELECT id_user, reset_expiry FROM user WHERE reset_token = :token");
$stmt->bindParam(':token', $token);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    die("Token invalide ou expiré.");
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);
$userId = $user['id_user'];
$expiry = $user['reset_expiry'];

// Vérifier si le token n'est pas expiré
if (strtotime($expiry) < time()) {
    die("Token expiré.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Utiliser le nom correct de la colonne : mot_de_passe
    $updateStmt = $conn->prepare("UPDATE user SET mot_de_passe = :password, reset_token = NULL, reset_expiry = NULL WHERE id_user = :id");
    $updateStmt->bindParam(':password', $password);
    $updateStmt->bindParam(':id', $userId);
    $updateStmt->execute();

    echo "Mot de passe réinitialisé avec succès ! <a href='connexion.html'>Se connecter</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - VTC Rentium</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-wrapper">
            <div class="auth-box">
                <div class="auth-header">
                    <h1>Nouveau mot de passe</h1>
                    <p>Choisissez un nouveau mot de passe sécurisé</p>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="password" placeholder="Entrez votre nouveau mot de passe" required minlength="8">
                    </div>

                    <button type="submit" class="btn-submit">Réinitialiser le mot de passe</button>

                    <p class="switch-form">
                        Retour à la <a href="connexion.html">page de connexion</a>
                    </p>
                </form>
            </div>

            <!-- Image de côté -->
            <div class="auth-image">
                <div class="image-overlay">
                    <h2>Sécurité avant tout</h2>
                    <p>Créez un mot de passe fort pour protéger votre compte</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>