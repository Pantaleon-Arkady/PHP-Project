<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Controllers\Post;
use Root\Controllers\Shop;
use Root\Controllers\General;
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
        $images = $_FILES['images'];

        $filePaths = isset($_FILES['images']) ? General::uploadFile() : [];

        $imagePaths = json_encode($filePaths['success']);

        $query = Database::crudQuery(
            'INSERT INTO app_user_products (name, description, price, stock, image_path, created_at)
            VALUES (:name, :description, :price, :stock, :image_path, :created_at)',
            [
                'name' => $name, 
                'description' => $description,
                'price' => $price,
                'stock' => $stocks,
                'image_path' => $imagePaths,
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        $this->redirect('/homepage-admin?home=shop');
        
    }

    public function adminDeleteProduct()
    {
        session_start();
        ob_start();

        $productId = $_GET['id'];

        echo 'deleting prodcut with an id: ' . $productId;

        $query = Database::crudQuery(
            'DELETE FROM app_user_products WHERE id = :id',
            [
                'id' => $productId
            ]
        );

        ob_get_clean();

        $this->redirect('/homepage-admin?home=shop');
    }

    public function adminEditProduct()
    {
        $productId = $_GET['id'];

        $product = Database::fetchAssoc(
            'SELECT * FROM app_user_products WHERE id = :id',
            [
                'id' => $productId
            ]
        );

        include __DIR__ . ('/../templates/edit-products.php');
    }

    public function adminUpdateProduct()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo 'Wrong request chum';
        }

        $required = ['name', 'description', 'stock', 'price'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                echo "Missing field: $field";
                return;
            }
        }

        $productId = $_POST['id'];
        // for future advance coding, figure out hwo to compare arrays...
        // then figure out a proper way on regulating images number and its assigned key...
        $submittedData = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'stock' => (int) $_POST['stock'],
            'price' => (float) $_POST['price'],
        ];

        $queriedData = Database::fetchAssoc(
            'SELECT name, description, stock, price FROM app_user_products WHERE id = :id',
            [
                'id' => $productId
            ]
        );

        if (!$queriedData) {
            echo 'No product found.';
            return;
        }

        $changes = false;
        foreach ($submittedData as $key => $value) {
            if ((string)$value !== (string)$queriedData[$key]) {
                $changes = true;
                echo 'There is a change made in ' . $key . '.';
                // break;
            } else {
                echo 'No changes made in ' . $key . '.';
                echo '<br /><br />';
                echo '<a href="/admin-edit-product?id=' . $productId . '"></a>';
            }
        }  
    }
}
