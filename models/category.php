<?php

class Category
{
    private $conn;
    private $table = 'category';

    public $id;
    public $name;

    private $connDb;

    #
    public function __construct($connDb)
    {
        $this->connDb = $connDb;
    }

    #
    public function getAll()
    {
        try {
            $query = "SELECT * FROM $this->table";
            $stmt = $this->connDb->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    public function getById($id)
    {
        try {
            $query = "SELECT * FROM $this->table WHERE id = ?";
            $stmt = $this->connDb->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>