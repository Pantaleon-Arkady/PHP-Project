<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

use Root\Controllers\General;
use Root\Controllers\UsersLog;
use Root\Controllers\Post;
use Root\Controllers\Shop;
use Root\Controllers\Admin;

$uri = strtok($_SERVER["REQUEST_URI"], '?');

$general = new General();
$usersLog = new UsersLog();
$post = new Post();
$shop = new Shop();
$admin = new Admin();

switch ($uri) {

    #Users Log
    case '/register':
        $usersLog->Register();
        break;
    case '/signing-up';
        $usersLog->SignUp();
        break;
    case '/verifying':
        $usersLog->qrVerification();
        break;
    case '/logging-in':
        $usersLog->LogIn();
        break;
    case '/homepage':
        $general->userHome();
        break;
    case '/register-pin':
        $usersLog->pinVerification();
        break;
    case '/logout':
        $usersLog->logOut();
        break;

    #Posts
    case '/create-post':
        $post->createPost();
        break;
    case '/edit-post':
        $post->editPost();
        break;
    case '/delete-post':
        $post->deletePost();
        break;
    case '/create-comment':
        $post->createComment();
        break;
    case '/edit-comment':
        $post->editComment();
        break;
    case '/delete-comment':
        $post->deleteComment();
        break;

    #Shop
    case '/product-view':
        $shop->productView();
        break;

    #General Stuff
    case '/':
        $general->showWelcome();
        break;
    default:
        http_response_code(404);
        echo 'Page not found.';

    
    //Admin

    case '/homepage-admin':
        $admin->adminHomePage();
        break;
    case '/admin-view-product':
        $admin->adminViewProduct();
        break;
    case '/admin-create-product':
        $admin->adminCreateProduct();
        break;
    case '/admin-edit-product':
        $admin->adminEditProduct();
        break;
    case '/admin-update-product':
        $admin->adminUpdateProduct();
        break;
    case '/admin-update-product':
        $admin->adminDeleteProduct();
        break;
}