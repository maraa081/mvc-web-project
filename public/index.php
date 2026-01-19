<?php
session_start();

require_once '../app/config/config.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {

    // --- ROUTES COMMUNES ---
    case 'home':
        require_once '../app/controllers/HomeController.php';
        (new HomeController())->index();
        break;

    case 'vehicles':
        require_once '../app/controllers/VehicleController.php';
        (new VehicleController())->index();
        break;

    case 'vehicle':
        require_once '../app/controllers/VehicleController.php';
        (new VehicleController())->show();
        break;

    case 'login':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->login();
        break;

    case 'register':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->register();
        break;

    case 'logout':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    case 'confirm':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->confirm();
        break;

    case 'booking':
        require_once '../app/controllers/BookingController.php';
        (new BookingController())->index();
        break;

    case 'booking_store':
        require_once '../app/controllers/BookingController.php';
        (new BookingController())->store();
        break;

    // --- ROUTES DU PROJET B (BLOG & SETTINGS) ---
    case 'blog':
        require_once '../app/controllers/BlogController.php';
        (new BlogController())->index(); 
        break;

    case 'blog_rate':
        require_once '../app/controllers/BlogController.php';
        (new BlogController())->rate();
        break;

    case 'settings':
        require_once '../app/controllers/SettingsController.php';
        (new SettingsController())->index();
        break;

    case 'faq':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->faq();
        break;
    
    case 'cgu':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->cgu();
        break;

    // --- ROUTES DU PROJET A (CONCESSIONNAIRES & CARTE) ---
    case 'register_concessionnaire':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->registerConcessionnaire();
        break;
    
    case 'login_concessionnaire':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->loginConcessionnaire();
        break;

    case 'dashboard_concessionnaire':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->dashboardConcessionnaire();
        break;

    case 'forgot_password': // Gestion MDP (Projet A est plus complet sur ce point)
        require_once '../app/controllers/PasswordResetController.php';
        (new PasswordResetController())->forgotPassword();
        break;

    case 'reset_password':
        require_once '../app/controllers/PasswordResetController.php';
        (new PasswordResetController())->resetPassword();
        break;

    case 'ajouter_voiture':
        require_once '../app/controllers/VoitureController.php';
        (new VoitureController())->ajouterVoiture();
        break;

    case 'mes_voitures':
        require_once '../app/controllers/VoitureController.php';
        (new VoitureController())->mesVoitures();
        break;

    case 'modifier_voiture':
        require_once '../app/controllers/VoitureController.php';
        (new VoitureController())->modifierVoiture();
        break;

    case 'supprimer_voiture':
        require_once '../app/controllers/VoitureController.php';
        (new VoitureController())->supprimerVoiture();
        break;

    case 'carte':
        require_once '../app/controllers/CarteController.php';
        (new CarteController())->index();
        break;

    // --- ROUTES STATIQUES ---
    case 'about':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->about();
        break;

    case 'contact':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->contact();
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}