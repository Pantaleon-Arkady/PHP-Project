<?php

namespace Root\Controllers;

use ApiPlatform\Metadata\Delete;
use Exception;
use Root\Database\Database;

class APIData
{
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

    public function handlePreflight() {
        $this->addHeaders("full");
        http_response_code(200);
        exit;
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
        $this->addHeaders("full");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
                http_response_code(405);
                echo json_encode(["success" => false, "error" => "Method not allowed"]);
                exit;
            }

            parse_str($_SERVER['QUERY_STRING'] ?? '', $query);
            $taskId = isset($query['id']) ? (int) $query['id'] : 0;

            if ($taskId <= 0) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "Task ID is required"]);
                exit;
            }

            $stmt = Database::crudQuery(
                "DELETE FROM react_php_mixed WHERE id = :id",
                ['id' => $taskId]
            );

            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    "success" => true,
                    "message" => "Task deleted"
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "error" => "Task not found"
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function deleteReminder()
    {
        $this->addHeaders("full");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
                http_response_code(405);
                echo json_encode(["success" => false, "error" => "Method not allowed"]);
                exit;
            }

            parse_str($_SERVER['QUERY_STRING'] ?? '', $query);
            $taskId = isset($query['id']) ? (int) $query['id'] : 0;

            if ($taskId <= 0) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "Task ID is required"]);
                exit;
            }

            $stmt = Database::crudQuery(
                "DELETE FROM api_reminders WHERE id = :id",
                ['id' => $taskId]
            );

            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    "success" => true,
                    "message" => "Task deleted"
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "error" => "Task not found"
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }
}
