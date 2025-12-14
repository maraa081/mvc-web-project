<?php

class AuthController
{
    public function login()
    {
        require __DIR__ . '/../views/login.php';
    }

    public function register()
    {
        require __DIR__ . '/../views/register.php';
    }
}
