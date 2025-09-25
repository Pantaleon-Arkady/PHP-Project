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

    private function getTableFromUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (strpos($uri, 'tasks') !== false) {
            return 'react_php_mixed';
        } elseif (strpos($uri, 'reminders') !== false) {
            return 'api_reminders';
        } else {
            throw new Exception("Unknown resource type");
        }
    }

    public function listData()
    {
        $this->addHeaders("full");

        try {
            $table = $this->getTableFromUri();

            $rows = Database::fetchAll("SELECT * FROM {$table} ORDER BY id DESC");

            echo json_encode([
                'success' => true,
                'data' => $rows
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteData()
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
            $id = isset($query['id']) ? (int) $query['id'] : 0;

            if ($id <= 0) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "ID is required"]);
                exit;
            }

            $table = $this->getTableFromUri();

            $stmt = Database::crudQuery(
                "DELETE FROM {$table} WHERE id = :id",
                ['id' => $id]
            );

            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    "success" => true,
                    "message" => ucfirst($table) . " entry deleted"
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "error" => "Entry not found"
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
