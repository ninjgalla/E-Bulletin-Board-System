<?php
// Database connection parameters
$host = "localhost";
$user_name = "root";
$password = "";
$database = "ebulletin_system";

// Create connection
$conn = mysqli_connect($host, $user_name, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
