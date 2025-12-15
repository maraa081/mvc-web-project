<?php
// register.php
header("Content-Type: application/json; charset=UTF-8");

include_once 'database.php';
include_once 'User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->nom) &&
    !empty($data->email) &&
    !empty($data->mot_de_passe) &&
    !empty($data->confirmer_mot_de_passe)
) {
    // Vérifier que les mots de passe correspondent
    if($data->mot_de_passe !== $data->confirmer_mot_de_passe) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Les mots de passe ne correspondent pas."]);
        exit();
    }
    
    // Vérifier si l'email existe déjà
    $user->email = $data->email;
    if($user->emailExists()) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Cet email est déjà utilisé."]);
        exit();
    }
    
    // Créer l'utilisateur
    $user->nom = $data->nom;
    $user->email = $data->email;
    $user->mot_de_passe = $data->mot_de_passe;
    
    if($user->create()) {
        http_response_code(201);
        echo json_encode(["success" => true, "message" => "Inscription réussie !"]);
    } else {
        http_response_code(503);
        echo json_encode(["success" => false, "message" => "Impossible de créer l'utilisateur."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Données incomplètes."]);
}
?>