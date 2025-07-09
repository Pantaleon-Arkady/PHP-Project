<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Database\BaseTable;
use \PDO;

class Post 
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    
}