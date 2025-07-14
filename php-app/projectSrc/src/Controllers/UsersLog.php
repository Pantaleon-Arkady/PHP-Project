<?php

namespace Root\Controllers;

use FontLib\EOT\File;
use Root\Controllers\Mailer;
use Root\Database\Database;
use \PDO;

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

    protected function emailRegistration($email, $username) {

        include_once __DIR__ . '/../Controllers/Mailer.php';

        $emailTo = $email;
        $emailFrom = 'register@email.com';
        $subject = 'Registration';
        $content = '
        <html>
        <body>
            <h1>Welcome, ' . htmlspecialchars($username) . '!</h1>
            <p>Click to verify: <a href="http://email.api:8080/verify">Verify</a></p>
        </body>
        </html>
        ';

        $sent = Mailer::send($emailTo, $emailFrom, $subject, $content);
        if (!$sent) {
            error_log('Email failed to send');
        }
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

            $this->emailRegistration($email, $username);

            $_SESSION['registered'] = true;
            
            $this->redirect('/register');
        }
        
    }

    public function LogIn()
    {
        session_start();
        ob_start();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $namemail = $_POST['namemail'];
            $password = $_POST['password'];
            $hashed_ps = md5($password);

            $registerQuery = $this->connection->prepare(
                'SELECT * FROM app_user WHERE (username = :namemail OR email = :namemail) AND password = :password'
            );

            $registerQuery->execute([
                'namemail' => $namemail,
                'password' => $hashed_ps
            ]);

            $user = $registerQuery->fetch(PDO::FETCH_ASSOC);

            $_SESSION['userId'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['userRole'] = $user['role'];
            $_SESSION['userInfo'] = $user;

            if ($_SESSION['userRole'] == 'admin') {

                $this->redirect('/homepage-admin');

            } else {
            
                $this->redirect('/homepage');

            }
        }

        return ob_get_clean();
    }


    public function logOut()
    {
        session_start();

        unset($_SESSION['userId']);

        $this->redirect('/register');
        die();
    }

}