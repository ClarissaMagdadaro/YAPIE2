<?php

class Comment
{
    private $id;
    private $post_id;
    private $user_id;
    private $comment_content;
    private $comment_date;

    private $connDb;

    #
    public function __construct($connDb, $post_id, $user_id, $comment_content)
    {
        $this->connDb = $connDb;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->comment_content = $comment_content;
        $this->comment_date = date('Y-m-d H:i:s'); // Set the current date/time for comment
    }

    #
    public function save()
    {
        try {
            $sql = "INSERT INTO comments (post_id, user_id, comment_content, comment_date) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$this->post_id, $this->user_id, $this->comment_content, $this->comment_date]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    public static function getCommentsByPostId($connDb, $post_id)
    {
        try {
            $sql = "SELECT * FROM comments WHERE post_id = ? ORDER BY comment_date DESC";
            $stmt = $connDb->prepare($sql);
            $stmt->execute([$post_id]);
            return $stmt->fetchAll();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    public function delete($post_id, $user_id)
    {
        try {
            $sql = "DELETE FROM comments WHERE post_id = ? AND user_id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$post_id, $user_id]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>