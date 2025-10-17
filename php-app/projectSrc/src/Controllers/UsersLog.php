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

    public function SignUp()
    {
        session_start();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashed_ps = md5($password);

            $_SESSION['userInfo'] = 
            [
                'email' => $email,
                'username' => $username,
                'password' => $hashed_ps
            ];

            $pin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $_SESSION['pin'] = $pin;
            $_SESSION['pin_expires'] = time() + 600;

            $qrcode = General::generateQrCodeBase64('localhost:8080/verifying?token=' . $pin . '');

            $this->emailRegistration($email, $username, $pin, $qrcode);

            $_SESSION['registered'] = true;
            
            $this->redirect('/register?register=pin');
        }
        
    }

    protected function emailRegistration($email, $username, $pin, ?string $qrcode = null) {

        include_once __DIR__ . '/../Controllers/Mailer.php';

        $emailTo = $email;
        $emailFrom = 'register@email.com';
        $subject = 'Registration';

        $data = [
            'email' => $email,
            'username' => $username,
            'pin' => $pin,
            'qrcode' => $qrcode
        ];

        ob_start();
        extract($data);
        include __DIR__ . '/../templates/registration-email.php';
        $content = ob_get_clean();

        $sent = Mailer::send($emailTo, $emailFrom, $subject, $content);
        if (!$sent) {
            error_log('Email failed to send');
        }
    }

    public function pinVerification()
    {
        session_start();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $pinSubmitted = intval($_POST['pin']);
            $pinGenerated = intval($_SESSION['pin']);

            if ($pinSubmitted == $pinGenerated) {

                $user = $_SESSION['userInfo'];   
                $this->createUser($user['email'], $user['username'], $user['password']);

                $_SESSION['registered'] = true;
                $this->redirect('/register');
            }

        }
    }

    public function qrVerification()
    {
        session_start();
        if($_SERVER['REQUEST_METHOD'] == 'GET') {

            $tokenGot = intval($_GET['token']);
            $pinGenerated = intval($_SESSION['pin']);

            if ($tokenGot == $pinGenerated) {
                
                $user = $_SESSION['userInfo'];   
                $this->createUser($user['email'], $user['username'], $user['password']);

                $_SESSION['registered'] = true;
                $this->redirect('/register');
                
            } else {
                echo 'something i do not know went wrong...';
            }

        }
    }

    public function createUser($email, $username, $password)
    {
        $registerQuery = $this->connection->prepare(
            'INSERT INTO app_user (email, username, password) VALUES (:email, :username, :password)'
        );

        $registerQuery->execute([
            'email' => $email,
            'username' => $username,
            'password' => $password
        ]);
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

    public function userProfileImage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo 'uploading profile...';
        }
    }

}