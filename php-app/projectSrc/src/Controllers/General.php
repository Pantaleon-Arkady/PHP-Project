<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Database\BaseTable;
use Root\Controllers\Post;
use Root\Controllers\Shop;
use \PDO;

class General
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function showWelcome()
    {
        require __DIR__ . '/../templates/initial.php';
    }

    public function userHome()
    {
        session_start();

        $userId = $_SESSION['userId'];

        $user = Database::fetchAssoc(
            'SELECT * FROM app_user WHERE id = :id',
            ['id' => $userId]
        );

        $allPosts = Post::allPosts();
        $allProducts = Shop::allProducts();

        include_once __DIR__ . '/../templates/home.php';
    }

    public static function uploadFile()
    {
        $uploadedFiles = [];

        $uploadDir = __DIR__ . '/../../public/files/'; // Make sure this folder exists and is writable

        foreach ($_FILES['fileToUpload']['name'] as $index => $fileName) {
            if ($_FILES['fileToUpload']['error'][$index] === UPLOAD_ERR_OK) {
                $tmpPath = $_FILES['fileToUpload']['tmp_name'][$index];
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);

                // Make a new safe filename
                $newFileName = uniqid('img_', true) . '.' . $extension;
                $destinationPath = $uploadDir . $newFileName;

                if (move_uploaded_file($tmpPath, $destinationPath)) {
                    // Store the relative URL to use later in HTML
                    $uploadedFiles[] = '/files/' . $newFileName;
                } else {
                    echo "Failed to move file: $fileName";
                }
            } else {
                echo "Upload error for file: $fileName";
            }
        }
    }

    public static function writableFolder()
    {
        $folder = __DIR__ . '/../../public/files';

        if (is_writable($folder)) {
            echo "Writable ✅";
        } else {
            echo "Not writable ❌";
        }
    }
}
