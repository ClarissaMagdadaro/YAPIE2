<?php
namespace Models;  // Ensure the correct namespace is used for the Post model

class Post
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPosts()
    {
        // Logic to fetch posts from the database
        $query = "SELECT * FROM posts";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createPost($userId, $content, $media)
    {
        // Logic to insert a post into the database
        $query = "INSERT INTO posts (user_id, content, media) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId, $content, $media]);
    }
}
?>
