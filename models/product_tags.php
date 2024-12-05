<?php

class ProductTags {
    private $product_id;
    private $tag_id;

    private $connDb;
    private $table = 'product_tags';

    public function __construct($connDb) {
        $this->connDb = $connDb;
    }

    // Assign a tag to a product
    public function save($product_id, $tag_id) {
        try {
            $sql = "INSERT INTO $this->table (product_id, tag_id) VALUES (?, ?)";
            $stmt = $this->connDb->prepare($sql);
            $stmt->bind_param('ii', $product_id, $tag_id);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to assign tag to product: " . $stmt->error);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    // Retrieve all tags for a specific product
    public function getTagsByProduct($product_id) {
        try {
            $sql = "SELECT t.name 
                    FROM tags t
                    INNER JOIN $this->table pt ON t.id = pt.tag_id
                    WHERE pt.product_id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->bind_param('i', $product_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $tags = [];
            while ($row = $result->fetch_object()) {
                $tags[] = $row;
            }
            return $tags;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return [];
        }
    }

    // Delete a tag from a product
    public function deleteTagFromProduct($product_id, $tag_id) {
        try {
            $sql = "DELETE FROM $this->table WHERE product_id = ? AND tag_id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->bind_param('ii', $product_id, $tag_id);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to delete tag from product: " . $stmt->error);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}
?>