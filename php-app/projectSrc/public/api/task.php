<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Root\Database\Database;

try {
    $tasks = Database::fetchAll("SELECT * FROM tasks ORDER BY id DESC");

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $tasks
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}