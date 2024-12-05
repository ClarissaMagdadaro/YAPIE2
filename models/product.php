<?php

class Product {
    public $id;
    public $user_id;
    public $name;
    public $category_id;
    public $product_detail;
    public $date_posted;
    public $price;
    public $stock_qty;
    public $status;
    public $image;

    private $connDb;
    private $table = 'product';

    public function __construct($connDb) {
        $this->connDb = $connDb;
    }

    // Create a new product
    public function create() {
        try {
            $this->date_posted = date('Y-m-d H:i:s'); // Automatically set current date and time
            $sql = "INSERT INTO $this->table (user_id, name, category_id, product_detail, date_posted, price, stock_qty, status, image) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connDb->prepare($sql);

            $stmt->bind_param(
                'isissdiss',
                $this->user_id,
                $this->name,
                $this->category_id,
                $this->product_detail,
                $this->date_posted,
                $this->price,
                $this->stock_qty,
                $this->status,
                $this->image
            );

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to create product: " . $stmt->error);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    // Retrieve all products
    public function getAll() {
        try {
            $sql = "SELECT * FROM $this->table";
            $result = $this->connDb->query($sql);

            $products = [];
            while ($row = $result->fetch_object()) {
                $products[] = $row;
            }
            return $products;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return [];
        }
    }

    // Retrieve product by ID
    public function getById($id) {
        try {
            $sql = "SELECT * FROM $this->table WHERE id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_object();
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    // Delete a product by ID
    public function delete($id) {
        try {
            $sql = "DELETE FROM $this->table WHERE id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to delete product: " . $stmt->error);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}
?>