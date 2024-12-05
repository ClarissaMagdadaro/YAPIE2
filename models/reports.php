<?php
class Report {
    public $id;
    public $post_id;
    public $comment_id;
    public $user_id;
    public $report_date;
    public $reason;

    private $connDb;

    #
    public function __construct($connDb) {
        $this->connDb = $connDb;
    }

    #
    function save() {
        try {
            $this->report_date = date('Y-m-d H:i:s'); // Current date/time for the report
            $sql = "INSERT INTO reports (post_id, comment_id, user_id, report_date, reason) 
                    VALUES ('" . $this->post_id . "', '" . $this->comment_id . "', '" . $this->user_id . "', '" . $this->report_date . "', '" . $this->reason . "')";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function getById($id) {
        try {
            $sql = "SELECT * FROM reports WHERE id = '" . $id . "'";
            $result = mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
            return mysqli_fetch_object($result);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function getAll() {
        try {
            $sql = "SELECT * FROM reports";
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
            $sql = "DELETE FROM reports WHERE id = '" . $id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>