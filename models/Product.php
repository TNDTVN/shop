<?php
class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($user_id, $title, $description, $image)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (user_id, title, description, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $title, $description, $image]);
    }

    public function update($id, $title, $description, $image)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET title = ?, description = ?, image = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $image, $id]);
    }
}
