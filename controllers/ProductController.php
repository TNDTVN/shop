<?php
require_once 'config/database.php';
require_once 'models/Product.php';
require_once 'models/Comment.php';

class ProductController
{
    private $product;
    private $comment;

    public function __construct($pdo)
    {
        $this->product = new Product($pdo);
        $this->comment = new Comment($pdo);
    }

    public function index()
    {
        $products = $this->product->getAll();
        require 'views/products/index.php';
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /shop/?controller=product&action=index');
            exit;
        }
        $product = $this->product->findById($id);
        if (!$product) {
            header('Location: /shop/?controller=product&action=index');
            exit;
        }
        $comments = $this->comment->getByProductId($id);
        require 'views/products/show.php';
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /shop/?controller=user&action=login');
            exit;
        }
        $id = $_GET['id'] ?? null;
        $product = $id ? $this->product->findById($id) : null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $product ? $product['image'] : '';
            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'public/images/' . $image);
            }
            if ($id) {
                $this->product->update($id, $title, $description, $image);
            } else {
                $this->product->create($_SESSION['user_id'], $title, $description, $image);
            }
            header('Location: /shop/?controller=product&action=index');
            exit;
        }
        require 'views/products/form.php';
    }
}
