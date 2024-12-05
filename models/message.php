<?php

class Message {
    private $conn;
    private $id;
    private $sender_id;
    private $receiver_id;
    private $subject;
    private $message_text;
    private $message_date;
    private $status;

    // Constructor accepts a database connection to avoid global scope reliance
    public function __construct($db, $sender_id, $receiver_id, $subject, $message_text, $status, $id = null) {
        $this->conn = $db;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->subject = $subject;
        $this->message_text = $message_text;
        $this->message_date = date('Y-m-d H:i:s');
        $this->status = $status;
        if ($id) {
            $this->id = $id;
        }
    }

    // Save a new message
    public function save() {
        try {
            $sql = "INSERT INTO message (sender_id, receiver_id, subject, message_text, message_date, status) 
                    VALUES (:sender_id, :receiver_id, :subject, :message_text, :message_date, :status)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':sender_id', $this->sender_id);
            $stmt->bindParam(':receiver_id', $this->receiver_id);
            $stmt->bindParam(':subject', $this->subject);
            $stmt->bindParam(':message_text', $this->message_text);
            $stmt->bindParam(':message_date', $this->message_date);
            $stmt->bindParam(':status', $this->status);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "Error saving message: " . $e->getMessage();
            return false;
        }
    }

    // Get all messages by receiver_id
    public static function getMessagesByReceiverId($db, $receiver_id) {
        try {
            $sql = "SELECT * FROM message WHERE receiver_id = :receiver_id ORDER BY message_date DESC";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':receiver_id', $receiver_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Error retrieving messages: " . $e->getMessage();
            return false;
        }
    }

    // Mark a message as read
    public function markAsRead() {
        try {
            $this->status = 'read';

            $sql = "UPDATE message SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':id', $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "Error marking message as read: " . $e->getMessage();
            return false;
        }
    }

    // Delete a message
    public static function deleteMessage($db, $id) {
        try {
            $sql = "DELETE FROM message WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "Error deleting message: " . $e->getMessage();
            return false;
        }
    }
}
?>