<?php

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

    case 'blog':
        require_once '../app/controllers/BlogController.php';
        (new BlogController())->index();
        break;

    case 'about':
        require_once '../app/controllers/AboutController.php';
        (new AboutController())->index();
        break;

    case 'contact':
        require_once '../app/controllers/ContactController.php';
        (new ContactController())->index();
        break;


    case 'booking':
        require_once '../app/controllers/BookingController.php';
        (new BookingController())->index();
        break;

    case 'login':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->login();
        break;

    case 'register':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->register();
        break;

    case 'settings':
        require_once '../app/controllers/UserController.php';
        (new UserController())->settings();
        break;

    case 'blog':
        require_once '../app/controllers/PageController.php';
        (new PageController())->blog();
        break;

    case 'about':
        require_once '../app/controllers/PageController.php';
        (new PageController())->about();
        break;

    case 'contact':
        require_once '../app/controllers/PageController.php';
        (new PageController())->contact();
        break;
    case 'admin_clients':
        require __DIR__ . '/../app/views/admin/clients.php';
        break;
    case 'admin_clients':
        require __DIR__ . '/../app/views/admin/clients.php';
        break;

    case 'admin_settings':
        require __DIR__ . '/../app/views/admin/settings.php';
        break;
    case 'vehicles':
        require __DIR__ . '/../app/views/vehicles.php';
        break;
    case 'admin_orders':
        require __DIR__ . '/../app/views/admin/orders.php';
        break;

    case 'admin_vehicles':
        require __DIR__ . '/../app/views/admin/vehicles.php';
        break;


    default:
        echo "Page non trouvée";
}
