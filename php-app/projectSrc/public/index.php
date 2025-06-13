<?php

require __DIR__ . '/../vendor/autoload.php';

use Root\Controllers\General;

$uri = strtok($_SERVER["REQUEST_URI"], '?');

$general = new General();

switch ($uri) {
    case '/':
        $general->showWelcome();
        break;
    default:
        http_response_code(404);
        echo 'Page not found.';
}