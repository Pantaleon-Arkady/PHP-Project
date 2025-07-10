<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

use Root\Controllers\General;
use Root\Controllers\UsersLog;
use Root\Controllers\Post;

$uri = strtok($_SERVER["REQUEST_URI"], '?');

$general = new General();
$usersLog = new UsersLog();
$post = new Post();

switch ($uri) {

    #Users Log
    case '/register':
        $usersLog->Register();
        break;
    case '/signing-up';
        $usersLog->SignUp();
        break;
    case '/logging-in':
        $usersLog->LogIn();
        break;
    case '/homepage':
        $general->userHome();
        break;
    case '/logout':
        $usersLog->logOut();
        break;

    #Posts
    case '/create-post':
        $post->createPost();
        break;


    #General Stuff
    case '/':
        $general->showWelcome();
        break;
    default:
        http_response_code(404);
        echo 'Page not found.';
}