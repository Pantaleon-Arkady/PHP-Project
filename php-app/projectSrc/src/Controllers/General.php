<?php

namespace Root\Controllers;

class General 
{
    public function showWelcome()
    {
        require __DIR__ . '/../templates/initial.php';
    }
}