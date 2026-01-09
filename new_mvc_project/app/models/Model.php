<?php

require_once __DIR__ . '/../core/Database.php';

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
