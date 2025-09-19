<?php

namespace Root\Controllers;

use Root\Database\Database;

class Tasks {
    public function listTasks() {
        header('Content-Type: application/json');
        try {
            $tasks = Database::fetchAll("SELECT * FROM react_php_mixed ORDER BY id DESC");
            echo json_encode(['success' => true, 'data' => $tasks]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
