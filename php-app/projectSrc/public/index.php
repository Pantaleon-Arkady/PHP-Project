<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

use Root\Controllers\General;
use Root\Controllers\UsersLog;

$uri = strtok($_SERVER["REQUEST_URI"], '?');

$general = new General();
$usersLog = new UsersLog();

switch ($uri) {

    #Users
    case '/register':
        $usersLog->Register();
        break;
    case '/signing-up';
        $usersLog->SignUp();
        break;
    case '/logging-in':
        $usersLog->LogIn();
        break;
    case '/home':
        $usersLog->Home();
        break;
    case '/homepage':
        $general->userHome();
        break;


    #General Stuff
    case '/':
        $general->showWelcome();
        break;
    default:
        http_response_code(404);
        echo 'Page not found.';
}