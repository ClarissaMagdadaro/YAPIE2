<?php
class Tag {
    public $id;
    public $name;

    private $connDb;

    #
    public function __construct($connDb) {
        $this->connDb = $connDb;
    }

    #
    function save() {
        try {
            $sql = "INSERT INTO tag (name) VALUES ('" . $this->name . "')";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function update() {
        try {
            $sql = "UPDATE tag SET name = '" . $this->name . "' WHERE id = '" . $this->id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function getAll() {
        try {
            $sql = "SELECT * FROM tag";
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
    function getById($id) {
        try {
            $sql = "SELECT * FROM tag WHERE id = '" . $id . "'";
            $result = mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
            return mysqli_fetch_object($result);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function delete($id) {
        try {
            $sql = "DELETE FROM tag WHERE id = '" . $id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>