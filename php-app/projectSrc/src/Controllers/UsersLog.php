<?php

namespace Root\Controllers;

use FontLib\EOT\File;
use Root\Database\Database;

class UsersLog 
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    function redirect(string $path) {
        header("Location: $path");
        exit;
    }

    public function Register()
    {

        include_once __DIR__ . '/../templates/register.php';

    }

    public function SignUp()
    {
        session_start();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashed_ps = md5($password);

            $registerQuery = $this->connection->prepare(
                'INSERT INTO app_user (email, username, password) VALUES (:email, :username, :password)'
            );

            $registerQuery->execute([
                'email' => $email,
                'username' => $username,
                'password' => $hashed_ps
            ]);

            $_SESSION['registered'] = true;
            
            $this->redirect('/register');
        }
        
    }
}