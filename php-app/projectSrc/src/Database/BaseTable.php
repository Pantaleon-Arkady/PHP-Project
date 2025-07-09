<?php

namespace Root\Database;

use Symfony\Component\VarDumper\Cloner\Data;

class BaseTable
{
    private $connection = null;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    // private $dbHost = 'db';

    // private $dbName = 'php-app';

    // private $dbUser = 'pguser';

    // private $dbPassword = 'password';

    // private $connection = null;

    // public function __construct()
    // {
    //     try {
    //         $this->connection = new \PDO(
    //             "mysql:host={$this->dbHost};dbname={$this->dbName}",
    //             $this->dbUser,
    //             $this->dbPassword
    //         );
    //     } catch (\PDOException $e) {
    //         // attempt to retry the connection after some timeout for example
    //         // log failure, return error - server busy
    //         $log = $e->getMessage();
    //     }
    // }

    public function fetchAll(string $query = null, array $options = []): array|bool
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($options);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}