<?php
class Review {
    public $id;
    public $product_id;
    public $rating;
    public $comment;
    public $posted_by_id;
    public $date_posted;

    private $connDb;

    #
    public function __construct($connDb) {
        $this->connDb = $connDb;
    }

    #
    function create() {
        try {
            $sql = "INSERT INTO review (product_id, rating, comment, posted_by_id, date_posted) 
                    VALUES ('" . $this->product_id . "', '" . $this->rating . "', '" . $this->comment . "', '" . $this->posted_by_id . "', '" . $this->date_posted . "')";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function update() {
        try {
            $sql = "UPDATE review 
                    SET rating = '" . $this->rating . "', 
                        comment = '" . $this->comment . "' 
                    WHERE id = '" . $this->id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function getByProduct($productId) {
        try {
            $sql = "SELECT * FROM review WHERE product_id = '" . $productId . "'";
            $result = mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
            $rows = [];
            while ($row = mysqli_fetch_object($result)) {
                $rows[] = $row;
            }
            return $rows;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function getAll() {
        try {
            $sql = "SELECT * FROM review";
            $result = mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
            $rows = [];
            while ($row = mysqli_fetch_object($result)) {
                $rows[] = $row;
            }
            return $rows;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function delete($id) {
        try {
            $sql = "DELETE FROM review WHERE id = '" . $id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>