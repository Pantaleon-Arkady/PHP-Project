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
        session_start();

        $productId = $_GET["id"] ?? null;

        $product = self::productQueryWithID($productId);

        $productImages = json_decode($product['image_path'], true);

        $token = General::generateCsrfToken('direct_checkout', $_SESSION['userId']);

        include __DIR__ . ('/../templates/product-view.php');
    }

    public static function allCartProducts($userId)
    {
        $token = General::generateCsrfToken('cart_checkout', $_SESSION['userId']);

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

            return [
                'productsQuery' => $productsQuery,
                'token' => $token
            ];

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

                } else {

                    $this->ATCFunction($cartId, $productId, $quantity);
                    $this->stockReduction($productId, $quantity);
                    
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

            }

            $this->redirect("/product-view?id=$productId");

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
        $product = self::productQueryWithID($productId);

        $updatedStock = intval($product['stock']) - intval($quantity);

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

    public function checkout()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $checkout = $_POST['checkout_type'];

            if ($checkout == "direct") {

                if (!General::validateCsrfToken('direct_checkout', $_POST['token'], $_SESSION['userId'])) {
                    die('Invalid CSRF token');
                }

                self::checkoutCart($_SESSION['userId']);

                $productId = $_POST['product_id'];

                $product = self::productQueryWithID($productId);

            } elseif ($checkout == "cart") {

                if (!General::validateCsrfToken('cart_checkout', $_POST['token'], $_POST['userId'])) {
                    die('Invalid CSRF token');
                }

                self::checkoutCart($_POST['userId']);

                $products = [];

                foreach ($_POST['products'] as $pId => $data) {
                    if (!empty($data['selected'])) {
                        $products[] = [
                            'product'    => self::productQueryWithID($pId),
                            'quantity'   => $data['quantity'],
                            'totalPrice' => $data['total_price']
                        ];
                    }
                }
            }

            include __DIR__ . ('/../templates/checkout.php');
        }
    }

    public static function checkoutCart($userId)
    {
        Database::crudQuery(
            'INSERT INTO app_user_cart (type, user_id, created_at)
            VALUES (:type, :user_id, :created_at)',
            [
                'type' => 'checkout',
                'user_id' => $userId,
                'created_at' => date('Y-m-d')
            ]
        );
    }

    public function placeOrder()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userId = $_SESSION['userId'];

            $checkoutType = $_POST['checkout'];
            $checkoutCart = Database::fetchAssoc(
                'SELECT *
                FROM app_user_cart
                WHERE type = :type
                AND user_id = :user_id
                ORDER BY id DESC
                LIMIT 1;',
                [
                    'type' => 'checkout',
                    'user_id' => $userId
                ]
            );

            General::fastPrint($checkoutCart);

            $cartId = $checkoutCart['id'];

            self::userOrder($cartId, $userId);

            $order = Database::fetchAssoc(
                'SELECT * FROM app_user_order
                WHERE cart_id = :cart_id
                AND user_id = :user_id',
                [
                    'cart_id' => $cartId,
                    'user_id' => $userId
                ]
            );

            $orderId = $order['id'];

            General::fastPrint($order);

            if ($checkoutType == 'direct') {

                echo "checkout directly";

                $pName = $_POST['product_name'];
                $price = $_POST['product_price'];                
                $quantity = $_POST['quantity'];
                $totalPrice = $_POST['total_price'];
                $productId = $_POST['product_id'];

                $order = [
                    'product_id' => $productId,
                    'name' => $pName,
                    'price' => $price,
                    'quantity' => $quantity,
                    'totalPrice' => $totalPrice
                ];

                self::userOrderItems($orderId, $productId, $price, $quantity, $totalPrice);

                General::fastPrint($order);

            } elseif ($checkoutType == 'cart') {

                foreach ($_POST['products'] as $pId => $data) {
                    $orders[] = [
                        'product_id' => $pId,
                        'name' => $data['name'],
                        'price' => $data['price'],
                        'quantity' => $data['quantity'],
                        'totalPrice' => $data['total_price']
                    ];
                }

                General::fastPrint($orders);

            }  
        }
    }

    public static function userOrder($cartId, $userId)
    {
        Database::crudQuery(
            'INSERT INTO app_user_order (cart_id, user_id, created_at)
            VALUES (:cart_id, :user_id, :created_at)',
            [
                'cart_id' => $cartId,
                'user_id' => $userId,
                'created_at' => date('Y-m-d')
            ]
        );
    }

    public static function userOrderItems($orderId, $productId, $price, $quantity, $totalPrice)
    {
        Database::crudQuery(
            'INSERT INTO app_user_order_item (order_id, product_id, price, quantity, total_price, created_at)
            VALUES (:order_id, :product_id, :price, :quantity, :total_price, :created_at)',
            [
                'order_id' => $orderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => date('Y-m-d')
            ]
        );
    }

    public static function productQueryWithID($productId)
    {
        $product = Database::fetchAssoc(
            'SELECT * FROM app_user_products WHERE id = :id',
            ['id' => $productId]
        );

        return $product;
    }
}