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
    case 'blog':
        require_once '../app/controllers/StaticController.php';
        (new StaticController())->blog();
        break;

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

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}
