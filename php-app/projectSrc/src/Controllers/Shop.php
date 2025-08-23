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

                $productId = $_POST['product_id'];

                $product = self::productQueryWithID($productId);
    
                include __DIR__ . ('/../templates/direct-checkout.php');

            } elseif ($checkout == "cart") {

                if (!General::validateCsrfToken('cart_checkout', $_POST['token'], $_POST['userId'])) {
                    die('Invalid CSRF token');
                }

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
    
                include __DIR__ . ('/../templates/cart-checkout.php');
            }
        }
    }

    public function directCheckout()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!General::validateCsrfToken('direct_checkout', $_POST['token'], $_SESSION['userId'])) {
                die('Invalid CSRF token');
            }

            $productId = $_POST['product_id'];

            $product = self::productQueryWithID($productId);

            General::fastPrint($product);

            include __DIR__ . ('/../templates/direct-checkout.php');

        }
    }

    public function cartCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!General::validateCsrfToken('cart_checkout', $_POST['token'], $_POST['userId'])) {
                die('Invalid CSRF token');
            }

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

            include __DIR__ . ('/../templates/cart-checkout.php');
        }
    }

    public function placeOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo 'placing order<br/>';

            $checkoutType = $_POST['checkout'];

            if ($checkoutType == 'direct') {

                echo "checkout directly";

                $pName = $_POST['product_name'];
                $totalPrice = $_POST['total_price'];
                $quantity = $_POST['quantity'];

                echo "order product: $pName, number: $quantity, and total price: $totalPrice";

            } elseif ($checkoutType == 'cart') {

                $order = [];

                foreach ($_POST['products'] as $pId => $data) {
                    $orders[] = [
                        'id'        => $pId,
                        'name'      => $data['name'],
                        'quantity'  => $data['quantity'],
                        'totalPrice'=> $data['total_price']
                    ];
                }

                General::fastPrint($orders);

            }  
        }
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