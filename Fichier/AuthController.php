<?php
// AuthController.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'database.php';
include_once 'User.php';

session_start();

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action) {
    case 'register':
        register($user);
        break;
    case 'login':
        login($user);
        break;
    case 'logout':
        logout();
        break;
    default:
        echo json_encode(["message" => "Action non reconnue"]);
        break;
}

function register($user) {
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
            echo json_encode(["message" => "Les mots de passe ne correspondent pas."]);
            return;
        }
        
        // Vérifier si l'email existe déjà
        $user->email = $data->email;
        if($user->emailExists()) {
            http_response_code(400);
            echo json_encode(["message" => "Cet email est déjà utilisé."]);
            return;
        }
        
        // Créer l'utilisateur
        $user->nom = $data->nom;
        $user->email = $data->email;
        $user->mot_de_passe = $data->mot_de_passe;
        
        if($user->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Inscription réussie ! Vous pouvez maintenant vous connecter."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Impossible de créer l'utilisateur."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Données incomplètes."]);
    }
}

function login($user) {
    $data = json_decode(file_get_contents("php://input"));
    
    if(!empty($data->email) && !empty($data->mot_de_passe)) {
        $user->email = $data->email;
        $_POST['mot_de_passe'] = $data->mot_de_passe;
        
        if($user->login()) {
            $_SESSION['user_id'] = $user->id_user;
            $_SESSION['user_nom'] = $user->nom;
            $_SESSION['user_email'] = $user->email;
            
            http_response_code(200);
            echo json_encode([
                "message" => "Connexion réussie",
                "user" => [
                    "id" => $user->id_user,
                    "nom" => $user->nom,
                    "email" => $user->email
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Email ou mot de passe incorrect."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Données incomplètes."]);
    }
}

function logout() {
    session_destroy();
    http_response_code(200);
    echo json_encode(["message" => "Déconnexion réussie"]);
}
?>