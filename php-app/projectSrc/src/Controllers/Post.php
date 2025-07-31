<?php

namespace Root\Controllers;

use Root\Database\Database;
use Root\Database\BaseTable;
use Root\Controllers\General;
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
            'SELECT p.id, p.title, p.content, p.created_at, u.id AS author_id, u.username AS author
             FROM app_user_posts p
             LEFT JOIN app_user u ON p.author = u.id
             ORDER BY p.id DESC;',
            []
        );
        
        foreach ($allPosts as &$post) {
            $post['comments'] = Database::fetchAll(
                'SELECT c.content, c.created_at, c.id AS comment_id, u.id AS author_id, u.username AS author
                 FROM app_user_main_comments c
                 LEFT JOIN app_user u ON c.author = u.id
                 WHERE c.post_id = ?
                 ORDER BY c.created_at ASC;',
                [$post['id']]
            );
        }

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

    public function createComment()
    {

        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $postId = $_POST['post_id'];
            $comment = $_POST['comment'];
            $userId = $_SESSION['userId'];

            $CrudQuery = Database::crudQuery(
                'INSERT INTO app_user_main_comments (post_id, author, content, created_at) 
                VALUES (:post_id, :author, :content, :created_at)',
                [
                    'post_id' => $postId,
                    'author' => $userId,
                    'content' => $comment,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );

            $this->redirect('/homepage?home=post');
        }
    }
}