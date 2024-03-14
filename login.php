<?php
session_start();

// Include database connection
include('config.php');

// Retrieve form data and sanitize inputs
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check user credentials
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    // User found, set session variable and redirect to dashboard or home page
    $_SESSION['username'] = $username;
    header("Location: user_dashboard.php");
    exit; // Stop further execution
} else {
    // Invalid credentials, redirect back to login page
    header("Location: index.php");
    exit; // Stop further execution
}
?>
