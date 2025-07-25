<?php
require_once 'config/database.php';
require_once 'models/Comment.php';

class CommentController
{
    private $comment;

    public function __construct($pdo)
    {
        $this->comment = new Comment($pdo);
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /shop/?controller=user&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $content = $_POST['content'] ?? '';
            if ($product_id && $content) {
                $this->comment->create($_SESSION['user_id'], $product_id, $content);
                header("Location: /shop/?controller=product&action=show&id=$product_id");
                exit;
            }
        }
        header('Location: /shop/?controller=product&action=index');
        exit;
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /shop/?controller=user&action=login');
            exit;
        }
        $id = $_POST['comment_id'] ?? ($_GET['id'] ?? null);
        if (!$id) {
            header('Location: /shop/?controller=product&action=index');
            exit;
        }
        $comment = $this->comment->findById($id);
        if (!$comment || $comment['user_id'] != $_SESSION['user_id']) {
            header('Location: /shop/?controller=product&action=index');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'] ?? '';
            if ($content) {
                $this->comment->update($id, $content);
                header("Location: /shop/?controller=product&action=show&id={$comment['product_id']}");
                exit;
            }
        }
        header("Location: /shop/?controller=product&action=show&id={$comment['product_id']}&edit_comment_id=$id");
        exit;
    }
}
