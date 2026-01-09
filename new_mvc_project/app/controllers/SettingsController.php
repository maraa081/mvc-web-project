<?php
require_once __DIR__ . '/../models/ClientModel.php';

if (session_status() === PHP_SESSION_NONE) session_start();

class SettingsController
{
    private ClientModel $clientModel;

    public function __construct()
    {
        if (!isset($_SESSION['user']['id_user'])) {
            header('Location: ' . BASE_URL . '/public/index.php?page=login');
            exit;
        }
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $userId = $_SESSION['user']['id_user'];
        $message = null;
        $error = null;
        
        // Onglet par défaut
        $activeTab = 'infos'; 
        
        $currentUser = $this->clientModel->getUserFullInfo($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $dataToSave = $currentUser;
            $action = $_POST['action_type'] ?? '';

            // --- CAS EXPORT JSON ---
            if ($action === 'export_json') {
                $exportData = $currentUser;
                header('Content-Type: application/json; charset=utf-8');
                header('Content-Disposition: attachment; filename="mes_donnees.json"');
                echo json_encode($exportData);
                exit;
            }

            // --- GESTION PROFIL (Avatar + Infos) ---
            elseif ($action === 'profil') {
                $activeTab = 'profil'; 

                $dataToSave['ville'] = htmlspecialchars($_POST['ville']);
                $dataToSave['code_postal'] = htmlspecialchars($_POST['code_postal']);
                $dataToSave['telephone'] = htmlspecialchars($_POST['telephone']);
                $dataToSave['date_naissance'] = htmlspecialchars($_POST['date_naissance']);
                $dataToSave['genre'] = htmlspecialchars($_POST['genre']);
                $dataToSave['facebook'] = htmlspecialchars($_POST['facebook']);
                $dataToSave['twitter'] = htmlspecialchars($_POST['twitter']);
                $dataToSave['linkedin'] = htmlspecialchars($_POST['linkedin']);

                // --- VÉRIFICATION DATE DE NAISSANCE ---
                $dobInput = $_POST['date_naissance'];
                
                if (!empty($dobInput)) {
                    $dobDate = new DateTime($dobInput);
                    $nowDate = new DateTime(); 
                    $age = $nowDate->diff($dobDate)->y;
                    
                    if ($dobDate > $nowDate) {
                        $error = "La date de naissance ne peut pas être dans le futur.";
                    } elseif ($age > 95) {
                        $error = "L'âge maximum autorisé est de 95 ans.";
                    }
                }
                
                $dataToSave['date_naissance'] = htmlspecialchars($_POST['date_naissance']);

                // --- GESTION AVATAR ---
                $deleteAvatar = isset($_POST['delete_avatar']) && $_POST['delete_avatar'] === "1";
                $uploadError = $_FILES['avatar_file']['error'] ?? UPLOAD_ERR_NO_FILE;

                if ($deleteAvatar) {
                    $dataToSave['avatar_url'] = null; 
                } elseif ($uploadError === UPLOAD_ERR_OK) {
                    $file = $_FILES['avatar_file'];
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $filename = $file['name'];
                    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
                    
                    if (in_array(strtolower($filetype), $allowed)) {
                         $newName = 'avatar_' . $userId . '_' . time() . '.' . $filetype;
                         $uploadDir = __DIR__ . '/../../assets/uploads/avatars/';
                         if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                         
                         if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
                             $dataToSave['avatar_url'] = 'assets/uploads/avatars/' . $newName;
                         } else { 
                             $error = "Erreur upload serveur."; 
                         }
                    } else { 
                        $error = "Format invalide."; 
                    }
                } elseif ($uploadError === UPLOAD_ERR_NO_FILE) {
                    $dataToSave['avatar_url'] = $currentUser['avatar_url'];
                }

                if (!isset($error)) {
                    if ($this->clientModel->updateFullInfo($userId, $dataToSave)) {
                        $message = "Profil enregistré avec succès !";
                        // Mise à jour session
                        $currentUser = $this->clientModel->getUserFullInfo($userId);
                        $_SESSION['user'] = [
                            'id_user' => $currentUser['id_user'],
                            'nom' => $currentUser['nom'],
                            'email' => $currentUser['email'],
                            'avatar_url' => $currentUser['avatar_url']
                        ];
                    } else {
                        $error = "Erreur sauvegarde BDD.";
                    }
                }
            }

            // --- GESTION MOT DE PASSE ---
            elseif ($action === 'password') {
                $activeTab = 'password'; 

                $old = $_POST['old_password'];
                $new = $_POST['new_password'];
                $conf = $_POST['confirm_password'];

                if (!$this->clientModel->verifyPassword($userId, $old)) {
                    $error = "Mot de passe actuel incorrect.";
                } elseif ($new !== $conf) {
                    $error = "Les nouveaux mots de passe ne correspondent pas.";
                } elseif (strlen($new) < 8) {
                    $error = "Le mot de passe doit faire au moins 8 caractères.";
                } elseif (!preg_match('/[A-Z]/', $new) || !preg_match('/[0-9]/', $new)) {
                    $error = "Le mot de passe doit contenir au moins une majuscule et un chiffre.";
                } else {
                    if ($this->clientModel->updatePassword($userId, $new)) {
                        $message = "Mot de passe modifié avec succès.";

                        // Envoi notification mail
                        $this->sendEmailNotification(
                            $currentUser['email'], 
                            "Modification de votre mot de passe",
                            "Bonjour " . htmlspecialchars($currentUser['nom']) . ",<br><br>Votre mot de passe a été modifié avec succès. Si vous n'êtes pas à l'origine de cette action, contactez le support."
                        );
                    } else {
                        $error = "Erreur lors de la modification.";
                    }
                }
            }

            // --- GESTION EMAIL ---
            elseif ($action === 'email_management') {
                $activeTab = 'email'; 
                $dataToSave['email'] = htmlspecialchars($_POST['email_main']);
                $dataToSave['email_secours'] = htmlspecialchars($_POST['email_secours']);
                
                $oldEmail = $currentUser['email'];
                $newEmail = $dataToSave['email'];
                $emailChanged = ($oldEmail !== $newEmail);

                if ($this->clientModel->updateFullInfo($userId, $dataToSave)) {
                    $message = "Emails enregistrés.";
                    $_SESSION['user']['email'] = $newEmail;

                    // Envoi notification mail si changement
                    if ($emailChanged) {
                        $this->sendEmailNotification(
                            $newEmail, 
                            "Confirmation de votre nouvelle adresse email",
                            "Bonjour,<br><br>Votre adresse email principale sur Rentium a bien été changée pour : <strong>" . $newEmail . "</strong>."
                        );
                    }
                }
            }

            // --- GESTION NOTIFICATIONS ---
            elseif ($action === 'notification') {
                $activeTab = 'notification'; 
                $dataToSave['notif_email'] = isset($_POST['notif_email']) ? 1 : 0;
                $dataToSave['notif_sms'] = isset($_POST['notif_sms']) ? 1 : 0;
                if ($this->clientModel->updateFullInfo($userId, $dataToSave)) {
                    $message = "Préférences enregistrées.";
                }
            }

            if(isset($message)) {
                $currentUser = $this->clientModel->getUserFullInfo($userId);
            }
        }

        $client = $currentUser; 
        require __DIR__ . '/../views/settings.php';
    }

    // --- FONCTION ENVOI MAIL ---
    private function sendEmailNotification(string $to, string $subject, string $text)
    {
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // Utilisation de l'adresse Gmail réelle ici pour éviter les blocages
        $headers .= "From: vtc.rentium@gmail.com" . "\r\n"; 

        $message = "
        <html>
        <head><title>" . htmlspecialchars($subject) . "</title></head>
        <body style='font-family: sans-serif; color: #333;'>
            <div style='padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px; max-width: 600px;'>
                <h2 style='color: #10b981;'>Rentium Sécurité</h2>
                <p>" . $text . "</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p style='font-size: 12px; color: #9ca3af;'>Ceci est un message automatique, merci de ne pas répondre.</p>
            </div>
        </body>
        </html>
        ";

        // Envoi silencieux (le @ cache les erreurs PHP si le SMTP plante temporairement)
        @mail($to, $subject, $message, $headers);
    }
}