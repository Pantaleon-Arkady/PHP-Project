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

        // $downloadedFiles = [];

        $uploadedFiles = [
            'success' => [],
            'failed' => []
        ];

        $uploadedDestinations = [];

        $uploadDir = __DIR__ . '/../../public/files/';

        foreach ($_FILES['images']['name'] as $index => $fileName) {
            if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                $tmpPath = $_FILES['images']['tmp_name'][$index];
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);

                $newFileName = uniqid('img_', true) . '.' . $extension;
                $destinationPath = $uploadDir . $newFileName;

                if (move_uploaded_file($tmpPath, $destinationPath)) {
                    $uploadedFiles['success'][] = '/files/' . $newFileName;
                    $uploadedDestinations[] = $destinationPath;
                } else {
                    $uploadedFiles['failed'][] = $fileName;
                    echo "Failed to move file: $fileName<br>";
                }

            } else {
                $uploadedFiles['failed'] = $fileName;
                echo "Upload error for file: $fileName";
            }
        }

        if (count($uploadedFiles['failed']) > 0) {
            foreach ($uploadedDestinations as $deletePath) {
                try {
                    unlink($deletePath);
                } catch (\Error) {
                    echo "error deleting file: $deletePath";
                }
            }
        }

        return $uploadedFiles;
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
