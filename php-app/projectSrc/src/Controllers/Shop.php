<?php

namespace Root\Controllers;

use Root\Database\Database;
use \PDO;

class Shop 
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

    public static function allProducts()
    {
        $allProducts = Database::fetchAll(
            'SELECT * FROM app_user_products ORDER BY id ASC',
            []
        );

        return $allProducts;
    }

    public static function productView()
    {
        $productId = $_GET["id"] ?? null;

        // echo $product;

        $product = Database::fetchAssoc(
            'SELECT * FROM app_user_products WHERE id = :id',
            [
                'id' => $productId
            ]
        );

        $productImages = json_decode($product['image_path'], true);

        include __DIR__ . ('/../templates/product-view.php');
    }
}