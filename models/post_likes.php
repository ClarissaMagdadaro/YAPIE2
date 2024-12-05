<?php

class PostLike {
    private $conn;
    private $post_id;
    private $user_id;

    // Constructor accepts a database connection object for better encapsulation
    public function __construct($db, $post_id, $user_id) {
        $this->conn = $db;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
    }

    // Save a like to the database
    public function save() {
        try {
            $sql = "INSERT INTO post_likes (post_id, user_id) VALUES (:post_id, :user_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':post_id', $this->post_id);
            $stmt->bindParam(':user_id', $this->user_id);

            // Execute the query and return true if successful
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            // Handle any errors that occur during the save operation
            echo "Error saving like: " . $ex->getMessage();
            return false;
        }
    }

    // Remove a like from the database
    public function remove() {
        try {
            $sql = "DELETE FROM post_likes WHERE post_id = :post_id AND user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':post_id', $this->post_id);
            $stmt->bindParam(':user_id', $this->user_id);

            // Execute the query and return true if successful
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            // Handle any errors that occur during the removal operation
            echo "Error removing like: " . $ex->getMessage();
            return false;
        }
    }

    // Check if the user has already liked the post
    public static function hasLiked($db, $post_id, $user_id) {
        try {
            $sql = "SELECT COUNT(*) FROM post_likes WHERE post_id = :post_id AND user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':post_id', $post_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Return true if the user has liked the post, false otherwise
            return $stmt->fetchColumn() > 0;
        } catch (Exception $ex) {
            // Handle any errors during the check operation
            echo "Error checking like status: " . $ex->getMessage();
            return false;
        }
    }
}
?>