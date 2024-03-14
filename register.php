<?php
// Include database connection
include('config.php');

// Retrieve form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

// Check if email already exists
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Email already exists, handle the error appropriately (e.g., display a message to the user)
    echo "Email already exists. Please use a different email address.";
} else {
    // Insert user into database
    $insert_query = "INSERT INTO users (username, email, password, first_name, last_name) VALUES ('$username', '$email', '$password', '$first_name', '$last_name')";
    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        // Registration successful, redirect to login page or any other page
        header("Location: index.php");
    } else {
        // Registration failed, redirect back to registration page or handle the error appropriately
        echo "Registration failed. Please try again.";
    }
}
?>
