<?php

require_once __DIR__ . '/../models/VoitureModel.php';
require_once __DIR__ . '/../models/ConcessionnaireModel.php'; // ✅ AJOUT

class VoitureController
{
    private VoitureModel $voitureModel;
    private ConcessionnaireModel $concessionnaireModel; // ✅ AJOUT

    public function __construct()
    {
        $this->voitureModel = new VoitureModel();
        $this->concessionnaireModel = new ConcessionnaireModel(); // ✅ AJOUT
    }

    public function ajouterVoiture()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'concessionnaire') {
            header('Location: index.php?page=login_concessionnaire');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupération des champs
            $plaque  = trim($_POST['plaque'] ?? '');
            $marque  = trim($_POST['marque'] ?? '');
            $modele  = trim($_POST['modele'] ?? '');
            $type    = trim($_POST['type'] ?? '');
            $couleur = trim($_POST['couleur'] ?? '');
            $prix    = floatval($_POST['prix_journalier'] ?? 0);

            // 🔥 VALIDATIONS 🔥

            // Plaque
            if (!preg_match('/^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$/', $plaque)) {
                $_SESSION['error'] = "Format de plaque invalide. Exemple : AB-123-CD";
                require __DIR__ . '/../views/ajouter_voiture.php';
                return;
            }

            // Prix
            if ($prix <= 0) {
                $_SESSION['error'] = "Le prix doit être supérieur à 0.";
                require __DIR__ . '/../views/ajouter_voiture.php';
                return;
            }

            // Vérification image
            if (empty($_FILES['image']['name'])) {
                $_SESSION['error'] = "Veuillez sélectionner une image.";
                require __DIR__ . '/../views/ajouter_voiture.php';
                return;
            }

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if ($ext !== 'jpg') {
                $_SESSION['error'] = "L'image doit être au format JPG.";
                require __DIR__ . '/../views/ajouter_voiture.php';
                return;
            }

            // Nom attendu
            $expectedName = strtolower($marque . '_' . $modele . '.jpg');
            if ($_FILES['image']['name'] !== $expectedName) {
                $_SESSION['error'] = "Le fichier doit se nommer : $expectedName";
                require __DIR__ . '/../views/ajouter_voiture.php';
                return;
            }

            // 🔥 Upload image
            $targetDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = time() . '_' . $expectedName;
            $targetFile = $targetDir . $fileName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $_SESSION['error'] = "Erreur lors de l'upload de l'image.";
                require __DIR__ . '/../views/ajouter_voiture.php';
                return;
            }

            // ✅ CORRECTION: Chemin relatif depuis public/
            $imageUrl = "uploads/" . $fileName;

            // ✅ CORRECTION: Récupérer l'id_concess depuis la table concessionnaire
            $concessionnaire = $this->concessionnaireModel->getByUserId($_SESSION['user']['id']);
            
            if (!$concessionnaire) {
                $_SESSION['error'] = "Profil concessionnaire non trouvé.";
                require __DIR__ . '/../views/ajouter_voiture.php';
                return;
            }

            $idConcess = $concessionnaire['id_concess'];

            // 🔥 Insertion en base
            $this->voitureModel->ajouterVoiture(
                $idConcess,
                $plaque,
                $marque,
                $modele,
                $type,
                $couleur,
                $prix,
                $imageUrl
            );

            $_SESSION['success'] = "Véhicule ajouté avec succès !";
            header("Location: index.php?page=mes_voitures");
            exit;
        }

        // Affichage du formulaire
        require __DIR__ . '/../views/ajouter_voiture.php';
    }

    // ✅ NOUVELLE MÉTHODE: Afficher les véhicules du concessionnaire
    public function mesVoitures()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'concessionnaire') {
            header('Location: index.php?page=login_concessionnaire');
            exit;
        }

        // Récupérer l'id_concess
        $concessionnaire = $this->concessionnaireModel->getByUserId($_SESSION['user']['id']);
        
        if (!$concessionnaire) {
            $_SESSION['error'] = "Profil concessionnaire non trouvé.";
            header('Location: index.php?page=dashboard_concessionnaire');
            exit;
        }

        $idConcess = $concessionnaire['id_concess'];

        // Récupérer tous les véhicules du concessionnaire
        $voitures = $this->voitureModel->getByConcessionnaire($idConcess);

        // Afficher la vue
        require __DIR__ . '/../views/mes_voitures.php';
    }



// ========================================
// FICHIER 1: VoitureController.php - Nouvelles méthodes
// ========================================

/**
 * Afficher le formulaire de modification
 */
public function modifierVoiture()
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'concessionnaire') {
        header('Location: index.php?page=login_concessionnaire');
        exit;
    }

    $idVoiture = $_GET['id'] ?? null;

    if (!$idVoiture) {
        $_SESSION['error'] = "ID du véhicule manquant.";
        header('Location: index.php?page=mes_voitures');
        exit;
    }

    // Récupérer le véhicule
    $voiture = $this->voitureModel->getById($idVoiture);

    if (!$voiture) {
        $_SESSION['error'] = "Véhicule introuvable.";
        header('Location: index.php?page=mes_voitures');
        exit;
    }

    // Vérifier que c'est bien le véhicule du concessionnaire
    $concessionnaireModel = new ConcessionnaireModel();
    $concessionnaire = $concessionnaireModel->getByUserId($_SESSION['user']['id']);

    if (!$concessionnaire || $voiture['id_concess'] != $concessionnaire['id_concess']) {
        $_SESSION['error'] = "Vous n'avez pas accès à ce véhicule.";
        header('Location: index.php?page=mes_voitures');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->traiterModification($idVoiture, $voiture);
        return;
    }

    require __DIR__ . '/../views/modifier_voiture.php';
}

/**
 * Traiter la modification
 */
private function traiterModification($idVoiture, $voitureActuelle)
{
    // Récupération des champs
    $marque  = trim($_POST['marque'] ?? '');
    $modele  = trim($_POST['modele'] ?? '');
    $type    = trim($_POST['type'] ?? '');
    $couleur = trim($_POST['couleur'] ?? '');
    $prix    = floatval($_POST['prix_journalier'] ?? 0);

    // Validations
    if (empty($marque) || empty($modele) || empty($type) || empty($couleur)) {
        $_SESSION['error'] = "Tous les champs sont obligatoires.";
        header("Location: index.php?page=modifier_voiture&id=$idVoiture");
        exit;
    }

    if ($prix <= 0) {
        $_SESSION['error'] = "Le prix doit être supérieur à 0.";
        header("Location: index.php?page=modifier_voiture&id=$idVoiture");
        exit;
    }

    // Gestion de l'image (optionnelle)
    $imageUrl = $voitureActuelle['image']; // Garder l'ancienne par défaut

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if ($ext !== 'jpg') {
            $_SESSION['error'] = "L'image doit être au format JPG.";
            header("Location: index.php?page=modifier_voiture&id=$idVoiture");
            exit;
        }

        $expectedName = strtolower($marque . '_' . $modele . '.jpg');
        if ($_FILES['image']['name'] !== $expectedName) {
            $_SESSION['error'] = "Le fichier doit se nommer : $expectedName";
            header("Location: index.php?page=modifier_voiture&id=$idVoiture");
            exit;
        }

        // Upload nouvelle image
        $targetDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = time() . '_' . $expectedName;
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Supprimer l'ancienne image si elle existe
            if (!empty($voitureActuelle['image']) && strpos($voitureActuelle['image'], 'uploads/') === 0) {
                $oldImagePath = __DIR__ . '/../../public/' . $voitureActuelle['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $imageUrl = "uploads/" . $fileName;
        }
    }

    // Mise à jour en base
    $success = $this->voitureModel->update(
        $idVoiture,
        $marque,
        $modele,
        $type,
        $couleur,
        $prix,
        $imageUrl
    );

    if ($success) {
        $_SESSION['success'] = "Véhicule modifié avec succès !";
    } else {
        $_SESSION['error'] = "Erreur lors de la modification.";
    }

    header("Location: index.php?page=mes_voitures");
    exit;
}

// ========================================
// FICHIER 1: VoitureController.php - Méthode de suppression
// ========================================

/**
 * Supprimer un véhicule
 */
public function supprimerVoiture()
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'concessionnaire') {
        header('Location: index.php?page=login_concessionnaire');
        exit;
    }

    $idVoiture = $_GET['id'] ?? null;

    if (!$idVoiture) {
        $_SESSION['error'] = "ID du véhicule manquant.";
        header('Location: index.php?page=mes_voitures');
        exit;
    }

    // Récupérer le véhicule
    $voiture = $this->voitureModel->getById($idVoiture);

    if (!$voiture) {
        $_SESSION['error'] = "Véhicule introuvable.";
        header('Location: index.php?page=mes_voitures');
        exit;
    }

    // Vérifier que c'est bien le véhicule du concessionnaire
    $concessionnaireModel = new ConcessionnaireModel();
    $concessionnaire = $concessionnaireModel->getByUserId($_SESSION['user']['id']);

    if (!$concessionnaire || $voiture['id_concess'] != $concessionnaire['id_concess']) {
        $_SESSION['error'] = "Vous n'avez pas accès à ce véhicule.";
        header('Location: index.php?page=mes_voitures');
        exit;
    }

    // Vérifier s'il y a des réservations actives
    if ($this->voitureModel->hasActiveReservations($idVoiture)) {
        $_SESSION['error'] = "Impossible de supprimer ce véhicule : des réservations sont en cours.";
        header('Location: index.php?page=mes_voitures');
        exit;
    }

    // Supprimer l'image si elle existe
    if (!empty($voiture['image']) && strpos($voiture['image'], 'uploads/') === 0) {
        $imagePath = __DIR__ . '/../../public/' . $voiture['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Suppression en base
    $success = $this->voitureModel->delete($idVoiture);

    if ($success) {
        $_SESSION['success'] = "Véhicule supprimé avec succès !";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression.";
    }

    header('Location: index.php?page=mes_voitures');
    exit;
}

}