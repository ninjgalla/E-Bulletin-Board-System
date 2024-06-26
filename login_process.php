<?php
session_start();

// Include database connection
include('config.php');

// Retrieve form data and sanitize inputs
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check user credentials and retrieve user data
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    // User found, fetch user data including their role
    $user = mysqli_fetch_assoc($result);
    $role = $user['RoleID'];

    // Set session variable for username
    $_SESSION['username'] = $username;

    // Redirect based on user role
    switch ($role) {
        case 1: // Super Admin role
            header("Location: superadmin_bulletin.php");
            break;
        case 2: // Admin
            header("Location: admin_bulletin.php");
            break;
        case 3: // User role
            header("Location: user_bulletin_feed.php");
            break;
        default:
            // Invalid role, redirect back to login page
            header("Location: index.php");
            break;
    }
    exit; // Stop further execution
} else {
    // Set error message
    $_SESSION['error'] = "Invalid username or password. Please try again.";

    // Redirect back to login page
    header("Location: index.php");
    exit; // Stop further execution
}
?>
