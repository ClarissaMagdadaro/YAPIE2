<?php
class ProductModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getProductById($productId) {
        $query = $this->db->prepare("SELECT * FROM `products` WHERE id = ?");
        $query->execute([$productId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

?>