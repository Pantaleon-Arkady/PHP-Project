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

    function redirect(string $path)
    {
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

        // Data Retrieval excluding images
        $productId = $_POST['id'];
        $submittedData = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'stock' => (int) $_POST['stock'],
            'price' => number_format($_POST['price'], 2, '.', '')
        ];

        $queriedData = Database::fetchAssoc(
            'SELECT name, description, stock, price FROM app_user_products WHERE id = :id',
            ['id' => $productId]
        );

        if (!$queriedData) {
            echo 'No product found.';
            return;
        }

        //Data Retrieval for Images
        $submittedImages = null;
        if (!empty($_FILES['images']['name'][0])) {
            $filePaths = isset($_FILES['images']) ? General::uploadFile() : [];
            $imagePaths = json_encode($filePaths['success']);
            $submittedImages = json_decode($imagePaths, true) ?? [];
        }
        $queriedImages = Database::fetchAssoc(
            'SELECT image_path FROM app_user_products WHERE id = :id',
            ['id' => $productId]
        );

        $currentImages = json_decode($queriedImages['image_path'], true) ?? [];

        $changes = false;
        foreach ($submittedData as $key => $value) {
            if ((string)$value !== (string)$queriedData[$key]) {
                $changes = true;
                break;
            } elseif ($submittedImages !== $currentImages) {
                $changes = true;
            }
        }

        if ($changes) {
            if (empty($_FILES['images']['name'][0])) {
                echo 'updating without image changes';
                $updateTable = Database::crudQuery(
                    'UPDATE app_user_products SET name = :name, description = :description, price = :price, stock = :stock, modified_at = :date
                    WHERE id = :id',
                    [
                        'name' => $_POST['name'],
                        'description' => $_POST['description'],
                        'price' => (float) $_POST['price'],
                        'stock' => (int) $_POST['stock'],
                        'date' => date('Y-m-d H:i:s'),
                        'id' => $productId
                    ]
                );
            } else {
                echo 'updating with image changes';
                $updateTable = Database::crudQuery(
                    'UPDATE app_user_products SET name = :name, description = :description, price = :price, stock = :stock, image_path = :image_path, modified_at = :date
                    WHERE id = :id',
                    [
                        'name' => $_POST['name'],
                        'description' => $_POST['description'],
                        'price' => (float) $_POST['price'],
                        'stock' => (int) $_POST['stock'],
                        'image_path' => $imagePaths,
                        'date' => date('Y-m-d H:i:s'),
                        'id' => $productId
                    ]
                );
            }
        } else {
            echo 'No changes made';
            echo '<br /><br />';
            echo '<a href="/admin-edit-product?id=' . $productId . '">Go back?</a>';
        }
    }
}
