<?php
class PostType {
    private $conn;
    private $id;
    private $name;

    // Constructor now expects a database connection object for better encapsulation
    public function __construct($db, $name = null) {
        $this->conn = $db;
        $this->name = $name;
    }

    // Save a new post type
    public function save() {
        try {
            $sql = "INSERT INTO post_type (name) VALUES (:name)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            // Handle any exceptions that occur during the save operation
            echo "Error saving post type: " . $ex->getMessage();
            return false;
        }
    }

    // Get post type by ID
    public static function getById($db, $id) {
        try {
            $sql = "SELECT * FROM post_type WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            // Handle any exceptions that occur during the retrieval operation
            echo "Error fetching post type by ID: " . $ex->getMessage();
            return null;
        }
    }

    // Get all post types
    public static function getAll($db) {
        try {
            $sql = "SELECT * FROM post_type";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            // Handle any exceptions that occur during the retrieval operation
            echo "Error fetching all post types: " . $ex->getMessage();
            return [];
        }
    }

    // Getters and Setters for the private properties
    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}
?>