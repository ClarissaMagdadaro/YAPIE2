<?php

class Favorite
{
    private $user_id;
    private $product_id;

    private $connDb;

    #
    public function __construct($connDb)
    {
        $this->connDb = $connDb;
    }

    #
    public function save()
    {
        try {
            $sql = "INSERT INTO favorite (user_id, product_id) VALUES (?, ?)";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$this->user_id, $this->product_id]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    public static function getFavoritesByUserId($user_id)
    {
        try {
            global $conn;
            $sql = "SELECT * FROM favorite WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    public function delete($user_id, $product_id)
    {
        try {
            $sql = "DELETE FROM favorite WHERE user_id = ? AND product_id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$user_id, $product_id]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>