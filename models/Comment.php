<?php
class Comment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByProductId($product_id)
    {
        $stmt = $this->pdo->prepare("SELECT comments.*, users.name FROM comments JOIN users ON comments.user_id = users.id WHERE product_id = ? ORDER BY created_at DESC");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($user_id, $product_id, $content)
    {
        $stmt = $this->pdo->prepare("INSERT INTO comments (user_id, product_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $product_id, $content]);
    }

    public function update($id, $content)
    {
        $stmt = $this->pdo->prepare("UPDATE comments SET content = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        return $stmt->execute([$content, $id]);
    }
}
