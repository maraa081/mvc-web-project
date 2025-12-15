<?php

require_once '../app/config/config.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {

    /* ================= FRONT ================= */

    case 'home':
        require_once '../app/controllers/HomeController.php';
        (new HomeController())->index();
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
    
    case 'settings':
        require_once '../app/controllers/UserController.php';
        (new UserController())->settings();
        break;


    /* ================= ADMIN ================= */

    case 'admin_clients':
        require_once '../app/controllers/AdminController.php';
        (new AdminController())->clients();
        break;

    case 'admin_settings':
        require_once '../app/controllers/AdminController.php';
        (new AdminController())->settings();
        break;
    case 'admin_vehicles':
        require_once '../app/controllers/AdminController.php';
        (new AdminController())->vehicles();
        break;


    /* ================= 404 ================= */

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}
