<?php
// Include database connection
include('config.php');

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$TUP_id = $_POST['TUP_id'];

// Assign RoleID based on the role selected in the form, default to 1 (user)
if (isset($_POST['role'])) {
    switch ($_POST['role']) {
        case 'admin':
            $RoleID = 2;
            break;
        case 'superadmin':
            $RoleID = 3;
            break;
        case 'user':
        default:
            $RoleID = 1;
            break;
    }
} else {
    $RoleID = 3; // Default to user role if no role is provided
}

// Check if email already exists
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Email already exists, handle the error appropriately (e.g., display a message to the user)
    $email_error = "Email already exists. Please use a different email address.";
} else {
    // Insert user into database
    $insert_query = "INSERT INTO users (username, email, password, first_name, last_name, TUP_id, RoleID) VALUES ('$username', '$email', '$password', '$first_name', '$last_name', '$TUP_id', '$RoleID')";
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
