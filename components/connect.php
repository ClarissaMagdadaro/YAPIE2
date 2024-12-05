<?php
// Database connection settings
$host = 'localhost';       // Database host
$dbname = 'arte_db'; // Replace this with your actual database name
$username = 'root';        // Default username for XAMPP
$password = '';            // Default password is empty for XAMPP

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
