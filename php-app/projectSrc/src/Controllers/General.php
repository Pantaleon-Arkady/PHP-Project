<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Database\BaseTable;
use Root\Controllers\Post;
use \PDO;

class General 
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function showWelcome()
    {
        require __DIR__ . '/../templates/initial.php';
    }

    public function userHome() {
        session_start();
        
        $userId = $_SESSION['userId'];

        $user = Database::fetchAssoc(
            'SELECT * FROM app_user WHERE id = :id',
            ['id' => $userId]
        );

        $allPosts = Post::allPosts();

        include_once __DIR__ . '/../templates/home.php';
    }
}