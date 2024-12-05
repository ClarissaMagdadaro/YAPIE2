<?php
namespace Controllers;

use PDO;

class ProductController {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Delete product from database
    public function deleteProduct($productId) {
        $productId = filter_var($productId, FILTER_SANITIZE_STRING);

        $deleteProduct = $this->conn->prepare("DELETE FROM `products` WHERE id = ?");
        $deleteProduct->execute([$productId]);

        return 'Product Deleted Successfully';
    }
    
    // You can add methods for other actions like adding products, updating, etc.
}
?>
