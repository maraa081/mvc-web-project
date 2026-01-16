<?php

class UserController
{
    public function settings()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        require __DIR__ . '/../views/settings.php';
    }
}
