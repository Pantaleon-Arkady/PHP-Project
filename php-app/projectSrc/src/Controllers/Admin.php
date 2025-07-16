<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Controllers\Post;
use Root\Controllers\Shop;
use \PDO;

class Admin
{
    private $connection;

    public const UPLOADS_DIR = __DIR__ . '/../../public/files/';

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    function redirect(string $path) {
        header("Location: $path");
        exit;
    }

    public function adminHomePage()
    {
        session_start();

        $allProducts = Shop::allProducts();

        include __DIR__ . ('/../templates/home-admin.php');
    }

    public function adminCreateProduct()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo 'Invalid request.';
            return;
        }

        $required = ['name', 'description', 'stock', 'price'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                echo "Missing field: $field";
                return;
            }
        }

        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $stocks = (int) $_POST['stock'];
        $price = (float) $_POST['price'];

        echo 'product created: ' . $name . ', description: ' . $description . ', price: ' . $price . ', stocks: ' . $stocks;
        
    }

    
}
