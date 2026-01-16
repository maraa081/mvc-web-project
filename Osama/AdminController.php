<?php

class AdminController
{
    private function render(string $view, array $data = [])
    {
        extract($data);

        ob_start();
        require __DIR__ . '/../views/admin/' . $view . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/admin/layout/admin.php';
    }

    public function dashboard()
    {
        $this->render('dashboard', [
            'pageCss' => ['admin.css'],
            'pageJs'  => ['admin.js']
        ]);
    }

    public function orders()
    {
        require_once __DIR__ . '/../models/OrderModel.php';
        $orderModel = new OrderModel();

        $currentOrders = $orderModel->getCurrentOrders();
        $upcomingOrders = $orderModel->getUpcomingOrders();
        $allOrders = $orderModel->getAllOrders();

        $this->render('orders', [
            'pageCss' => ['admin.css', 'orders.css'],
            'pageJs'  => ['admin.js'],
            'currentOrders' => $currentOrders,
            'upcomingOrders' => $upcomingOrders,
            'allOrders' => $allOrders
        ]);
    }

    public function clients()
    {
        $this->render('clients', [
            'pageCss' => ['suivi-clients.css'],
            'pageJs'  => ['script.js']
        ]);
    }

    public function settings()
    {
        $this->render('settings', [
            'pageCss' => ['param_clients.css'],
            'pageJs'  => ['p_script.js']
        ]);
    }

    public function vehicles()
    {
        $this->render('vehicles', [
            'pageCss' => ['CSS_rentium.css'],
            'pageJs'  => ['JS_rentium.js']
        ]);
    }
}
