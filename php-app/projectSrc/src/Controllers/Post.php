<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Database\BaseTable;
use \PDO;

class Post 
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public static function allPosts()
    {
        $allPosts = Database::fetchAll(
            'SELECT 
                p.id AS id,
                p.title AS title,
                p.content AS content,
                p.created_at AS date_posted,
                p.author AS author_id,
                u.username AS author
            FROM
                app_user_posts p
            LEFT JOIN
                app_user u
            ON
                (p.author = u.id)
            ORDER BY p.id DESC;',
            []
        );

        return $allPosts;
    }

    public function createPost()
    {
        echo 'creating a post';
    }
}