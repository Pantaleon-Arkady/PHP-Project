<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Controllers\Post;
use Root\Controllers\Shop;
use \PDO;

class Admin 
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function adminHomePage()
    {
        session_start();

        include __DIR__ . ('/../templates/home-admin.php');

    }
}