<?php

namespace Root\Controllers;
use Root\Database\Database;

class General 
{
    public function showWelcome()
    {
        require __DIR__ . '/../templates/initial.php';
    }
}