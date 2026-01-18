<?php
session_start();

require_once '../app/config/config.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {

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

    //case 'confirm':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->confirm();
        break; //

    case 'booking':
        require_once '../app/controllers/BookingController.php';
        (new BookingController())->index();
        break;

    case 'booking_store':
        require_once '../app/controllers/BookingController.php';
        (new BookingController())->store();
        break;
    case 'blog':
        // On charge le contrôleur dédié au Blog dynamique
        require_once '../app/controllers/BlogController.php';
        (new BlogController())->index(); 
        break;

    case 'blog_rate':
        require_once '../app/controllers/BlogController.php';
        (new BlogController())->rate();
        break;

    // Pour About et Contact, on utilise StaticController
    case 'about':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->about();
        break;

    case 'contact':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->contact();
        break;

    case 'settings':
        require_once '../app/controllers/SettingsController.php';
        $controller = new SettingsController();
        $controller->index();
        break;

        case 'faq':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->faq();
        break;

    case 'cgu':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->cgu();
        break;


    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}
