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

        if ($cartQuery) {

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

        } else {

            return [];

        }
    }

    public function addToCart()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['userId'];

            $userCartQuery = Database::fetchAssoc(
                'SELECT * FROM app_user_cart WHERE user_id = :user_id',
                ['user_id' => $userId]
            );

            if ($userCartQuery) {

                $cartId = $userCartQuery['id'];

                $ATCAQuery = Database::fetchAssoc(
                    'SELECT * FROM app_user_cart_products
                    WHERE cart_id = :cart_id AND product_id = :product_id',
                    [
                        'cart_id' => $cartId,
                        'product_id' => $productId
                    ]
                );

                if ($ATCAQuery) {

                    $oldQuantity = $ATCAQuery['quantity'];
                    $newQuantity = $quantity;

                    $sumQuantity = intval($oldQuantity) + intval($newQuantity);

                    $ATECQuery = Database::crudQuery(
                        'UPDATE app_user_cart_products
                        SET quantity = :quantity
                        WHERE cart_id = :cart_id AND product_id = :product_id',
                        [
                            'quantity' => $sumQuantity,
                            'cart_id' => $cartId,
                            'product_id' => $productId
                        ]
                    );

                    $this->stockReduction($productId, $quantity);
                    $this->redirect("/product-view?id=$productId");

                } else {

                    $this->ATCFunction($cartId, $productId, $quantity);
                    $this->stockReduction($productId, $quantity);
                    $this->redirect("/product-view?id=$productId");

                }

            // If user does not have existing cart yet...
            } else {

                $CUCQuery = Database::crudQuery(
                    'INSERT INTO app_user_cart (user_id, created_at)
                    VALUES (:user_id, :created_at)',
                    [
                        'user_id' => $userId,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );

                $UCQuery = Database::fetchAssoc(
                    'SELECT * FROM app_user_cart WHERE user_id = :user_id',
                    ['user_id' => $userId]
                );

                $cartId = $UCQuery['id'];

                $this->ATCFunction($cartId, $productId, $quantity);
                $this->stockReduction($productId, $quantity);
                $this->redirect("/product-view?id=$productId");

            }

        }
    }

    public function ATCFunction($cartId, $productId, $quantity)
    {

        $atcQuery = Database::crudQuery(
            'INSERT INTO app_user_cart_products (cart_id, product_id, quantity)
            VALUES (:cart_id, :product_id, :quantity)',
            [
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]
        );
    }

    public function stockReduction($productId, $quantity)
    {

        $productQuery = Database::fetchAssoc(
            'SELECT * FROM app_user_products
            WHERE id = :id',
            ['id' => $productId]
        );

        $updatedStock = intval($productQuery['stock']) - intval($quantity);

        $updateQuery = Database::crudQuery(
            'UPDATE app_user_products 
            SET stock = :stock
            WHERE id = :id',
            [
                'stock' => $updatedStock,
                'id' => $productId
            ]
        );

        return $updatedStock;
    }
}