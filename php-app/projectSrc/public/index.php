<?php

require __DIR__ . '/../vendor/autoload.php';

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


    #General Stuff
    case '/':
        $general->showWelcome();
        break;
    default:
        http_response_code(404);
        echo 'Page not found.';
}