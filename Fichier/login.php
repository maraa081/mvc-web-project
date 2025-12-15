<?php
// login.php
session_start();
header("Content-Type: application/json; charset=UTF-8");

include_once 'database.php';
include_once 'User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->email) && !empty($data->mot_de_passe)) {
    $user->email = $data->email;
    
    if($user->login($data->mot_de_passe)) {
        $_SESSION['user_id'] = $user->id_user;
        $_SESSION['user_nom'] = $user->nom;
        $_SESSION['user_email'] = $user->email;
        
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Connexion réussie",
            "user" => [
                "id" => $user->id_user,
                "nom" => $user->nom,
                "email" => $user->email
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "Email ou mot de passe incorrect."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Données incomplètes."]);
}
?>