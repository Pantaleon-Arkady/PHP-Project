<?php

namespace Root\Controllers;

use Root\Database\Database;

class APIData {
    private function addHeaders(string $mode = "full")
{
    if ($mode === "full") {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: application/json");
    }

    if ($mode === "jsonOnly") {
        header("Content-Type: application/json");
    }
}

    public function listTasks() 
    {
        $this->addHeaders("full");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            $tasks = Database::fetchAll("SELECT * FROM react_php_mixed ORDER BY id DESC");

            echo json_encode([
                'success' => true,
                'data' => $tasks
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function remindersList() 
    {
        $this->addHeaders("full");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            $reminders = Database::fetchAll("SELECT * FROM api_reminders ORDER BY id DESC");

            echo json_encode([
                'success' => true,
                'data' => $reminders
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteTask()
    {
        header("jsonOnly");
    }
}
