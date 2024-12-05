<?php
namespace YourNamespace;

class UserController {

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createPost($postData, $fileData, $userId) {
        try {
            // Validate inputs
            if (empty($postData['title']) || empty($postData['description']) || empty($postData['category']) || 
                empty($postData['starting_price']) || empty($postData['bidding_end_date'])) {
                return ['error' => 'All fields are required.'];
            }

            // Handle file upload
            $image = $fileData['image']['name'];
            $imagePath = '../uploads/' . basename($image);

            if (!move_uploaded_file($fileData['image']['tmp_name'], $imagePath)) {
                return ['error' => 'Failed to upload the image.'];
            }

            // Insert into database
            $query = "INSERT INTO posts (user_id, title, description, category, image, starting_price, bidding_end_date, created_at)
                      VALUES (:user_id, :title, :description, :category, :image, :starting_price, :bidding_end_date, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':user_id' => $userId,
                ':title' => $postData['title'],
                ':description' => $postData['description'],
                ':category' => $postData['category'],
                ':image' => $image,
                ':starting_price' => $postData['starting_price'],
                ':bidding_end_date' => $postData['bidding_end_date']
            ]);

            return ['success' => 'Post created successfully.'];
        } catch (Exception $e) {
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        }
    }
}
?>
