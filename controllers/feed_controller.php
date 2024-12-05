<?php
namespace Controllers;
require_once 'models/Post.php';  // Add this line to include the Post model
use Models\Post;  // Ensure you use the correct namespace for the Post model

class FeedController
{
    private $postModel;

    public function __construct($db)
    {
        $this->postModel = new Post($db);  // Now it should work if Post is correctly included
    }

    public function getPosts()
    {
        return $this->postModel->getPosts();
    }

    public function createPost($data, $files, $userId)
    {
        // Post creation logic
    }
}
?>
