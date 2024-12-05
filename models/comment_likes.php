<?php

class CommentLike
{
    private $comment_id;
    private $user_id;

    private $connDb;

    #
    public function __construct($connDb, $comment_id, $user_id)
    {
        $this->connDb = $connDb;
        $this->comment_id = $comment_id;
        $this->user_id = $user_id;
    }

    #
    public function save()
    {
        try {
            $sql = "INSERT INTO comment_likes (comment_id, user_id) VALUES (?, ?)";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$this->comment_id, $this->user_id]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    public static function getLikesByCommentId($connDb, $comment_id)
    {
        try {
            $sql = "SELECT count(id) FROM comment_likes WHERE comment_id = ?";
            $stmt = $connDb->prepare($sql);
            $stmt->execute([$comment_id]);
            $row = $stmt->fetch();
            return $row[0];
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>