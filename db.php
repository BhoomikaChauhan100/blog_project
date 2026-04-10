<?php
// Start session (optional but recommended globally)
//session_start();

// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "blog_system";

// Create connection
//$conn = new mysqli($host, $username, $password, $database);
$conn = new mysqli($host, $username, $password, $database, 3307);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset (important for proper text handling)
$conn->set_charset("utf8mb4");
?>