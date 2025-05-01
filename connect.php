<?php
$host = 'localhost';
$db   = 'register_db';  // Using the database you showed in your list
$user = 'root';        // Default XAMPP username
$pass = '';            // Default XAMPP password (empty)

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Don't close the connection here! Leave it open for other scripts to use
?>