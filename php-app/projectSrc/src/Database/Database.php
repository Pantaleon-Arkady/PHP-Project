<?php

namespace Root\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = 'db';
            $db   = 'php-app';
            $user = 'pguser';
            $pass = 'password';
            $dsn  = "pgsql:host=$host;port=5432;dbname=$db;";

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    public static function fetchAssoc(string $query, array $params = []): array|false
    {
        $pdo = self::getConnection();

        $statement = $pdo->prepare($query);
        $statement->execute($params);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function fetchAll(string $query, array $params = []): array|false
    {
        $pdo = self::getConnection();
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crudQuery(string $query, array $params = []): \PDOStatement
    {
        $pdo = self::getConnection();
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    public static function lastInsertId(?string $sequence = null): string
    {
        $pdo = self::getConnection();
        return $sequence
            ? $pdo->lastInsertId($sequence)
            : $pdo->lastInsertId();
    }
}
