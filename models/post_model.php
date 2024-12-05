<?php
namespace Models;  // Ensure the namespace is Models, not Controllers

class Post
{
    private $db;
    
    // Constructor
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    // Other methods for Post class...
    public function createPost($userId, $content, $media)
    {
        // Code to create the post in the database
    }

    public function getPosts()
    {
        // Code to retrieve posts from the database
    }
}
?>