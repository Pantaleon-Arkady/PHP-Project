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

    function redirect(string $path) {
        header("Location: $path");
        exit;
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
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user = $_SESSION['userId'];
            $title = $_POST['title'];
            $content = $_POST['text'];

            $insertPost = Database::crudQuery(
                'INSERT INTO app_user_posts (author, title, content, created_at) VALUES (:author, :title, :content, :created_at)', 
                [
                    'author' => $user,
                    'title' => $title,
                    'content' => $content,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }

        $this->redirect('/homepage?home=post');
    }

    public function editPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $postId = $_POST['post-id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            $updatePost = Database::crudQuery(
                'UPDATE app_user_posts SET title = :title, content = :content, modified_at = :modified_at WHERE id = :id',
                [
                    'title' => $title,
                    'content' => $content,
                    'modified_at' => date('Y-m-d H:i:s'),
                    'id' => $postId
                ]
            );
        }

        $this->redirect('/homepage?home=post');
    }

    public function deletePost()
    {
        $deleteId = $_GET["id"] ?? null;

        $deletePost = Database::crudQuery(
            'DELETE FROM app_user_posts WHERE id = :id',
            [
                'id' => $deleteId
            ]
        );

        $this->redirect('/homepage?home=post');
    }
}