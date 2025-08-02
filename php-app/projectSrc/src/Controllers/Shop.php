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

    public static function allCartProducts($userId)
    {

        $cartQuery = Database::fetchAssoc(
            'SELECT * FROM app_user_cart WHERE user_id = :user_id',
            ['user_id' => $userId]
        );

        $cartId = $cartQuery['id'];

        $productsQuery = Database::fetchAll(
            'SELECT
                c.id AS product_on_cart_id,
                c.cart_id AS cart_id,
                c.product_id AS product_id,
                c.quantity AS product_quantity,
                p.name AS product_name,
                p.price AS product_price,
                p.image_path AS product_images
            FROM
                app_user_cart_products c
            LEFT JOIN
                app_user_products p
            ON
                (c.product_id = p.id)
            WHERE
                cart_id = :cart_id',
            ['cart_id' => $cartId]
        );

        return $productsQuery;
    }
}