<?php

class SettingsController {

    public function index() {
        // 1. Vérification de sécurité : Est-on connecté ?
        // On vérifie si la variable 'user' existe dans la session
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/public/index.php?page=login');
            exit;
        }

        $user = $_SESSION['user'];

        // 2. Récupération de l'ID utilisateur
        // On gère les deux cas possibles (id ou id_user) pour éviter les erreurs
        $userId = $user['id_user'] ?? $user['id'] ?? null;

        if (!$userId) {
            // Si on ne trouve pas l'ID, la session est corrompue -> déconnexion forcée
            header('Location: ' . BASE_URL . '/public/index.php?page=logout');
            exit;
        }

        // 3. Chargement des modèles
        require_once __DIR__ . '/../models/ClientModel.php';
        $clientModel = new ClientModel();

        // 4. Traitement du formulaire (Mise à jour)
        $message = null;
        $messageType = ''; // 'success' ou 'error'

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mise à jour des infos personnelles
            if (isset($_POST['update_profile'])) {
                $data = [
                    'prenom' => htmlspecialchars($_POST['prenom'] ?? ''),
                    'telephone' => htmlspecialchars($_POST['telephone'] ?? ''),
                    'bio' => htmlspecialchars($_POST['bio'] ?? ''),
                    'adresse' => htmlspecialchars($_POST['adresse'] ?? ''),
                    'ville' => htmlspecialchars($_POST['ville'] ?? ''),
                    'code_postal' => htmlspecialchars($_POST['code_postal'] ?? ''),
                    'date_naissance' => $_POST['date_naissance'] ?? null,
                    'genre' => $_POST['genre'] ?? '',
                    'facebook' => htmlspecialchars($_POST['facebook'] ?? ''),
                    'twitter' => htmlspecialchars($_POST['twitter'] ?? ''),
                    'linkedin' => htmlspecialchars($_POST['linkedin'] ?? ''),
                    'email_secours' => htmlspecialchars($_POST['email_secours'] ?? '')
                ];

                if ($clientModel->createOrUpdateDetails($userId, $data)) {
                    $message = "Profil mis à jour avec succès !";
                    $messageType = "success";
                } else {
                    $message = "Erreur lors de la mise à jour.";
                    $messageType = "error";
                }
            }

            // Mise à jour de l'avatar
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['avatar']['name'];
                $filetype = $_FILES['avatar']['type'];
                $filesize = $_FILES['avatar']['size'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed) && $filesize < 2000000) { // Max 2MB
                    $newFilename = "avatar_" . $userId . "_" . time() . "." . $ext;
                    $uploadDir = __DIR__ . '/../../assets/uploads/avatars/';
                    
                    // Créer le dossier s'il n'existe pas
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $newFilename)) {
                        $avatarPath = 'assets/uploads/avatars/' . $newFilename;
                        $clientModel->updateAvatar($userId, $avatarPath);
                        
                        // Mettre à jour la session pour que l'image change immédiatement dans le header
                        $_SESSION['user']['avatar_url'] = $avatarPath;
                        
                        $message = "Avatar modifié avec succès !";
                        $messageType = "success";
                    }
                } else {
                    $message = "Format invalide ou fichier trop lourd (Max 2Mo).";
                    $messageType = "error";
                }
            }
        }

        // 5. Récupération des données pour l'affichage
        // Infos de base (table user)
        require_once __DIR__ . '/../models/UserModel.php';
        $userModel = new UserModel();
        $userInfo = $userModel->findById($userId); // Récupère nom, email, etc.

        // Infos détaillées (table user_details)
        $userDetails = $clientModel->getUserDetails($userId);

        // Fusionner pour la vue
        $profile = array_merge($userInfo ? $userInfo : [], $userDetails ? $userDetails : []);

        // Préparation de la vue
        $pageTitle = "Paramètres de mon compte";
        $pageCss = ['settings.css']; 
        
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/settings.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}