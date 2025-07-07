<?php

namespace Root\Controllers;

use Root\Database\Database;
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

        $userQuery = $this->connection->prepare(
            'SELECT * FROM app_user WHERE id = :id'
        );

        $userQuery->execute(['id' => $userId]);

        $user = $userQuery->fetch(PDO::FETCH_ASSOC);

        // echo 'home page fetch';

        // echo '<pre>';
        // print_r($user);
        // echo '</pre>';

        include_once __DIR__ . '/../templates/home.php';
    }
}