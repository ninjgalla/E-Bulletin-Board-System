<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Include configuration file and database connection
require_once 'config.php';

// Fetch user details for the form
$sql_select = "SELECT UserID, first_name, last_name, email, TUP_id FROM users WHERE username = ?";

if ($stmt_select = $conn->prepare($sql_select)) {
    // Bind parameters to the statement
    $stmt_select->bind_param("s", $_SESSION['username']);
    
    // Attempt to execute the prepared statement
    if ($stmt_select->execute()) {
        // Store result
        $stmt_select->store_result();
        
        // Check if a user exists
        if ($stmt_select->num_rows == 1) {
            // Bind result variables
            $stmt_select->bind_result($userId, $firstName, $lastName, $email, $tupId);
            
            // Fetch data
            $stmt_select->fetch();
        } else {
            // No user found with the given username
            echo "Error: User not found.";
        }
    } else {
        // Output error for debugging
        echo "Error fetching user details: " . $stmt_select->error;
    }

    // Close statement
    $stmt_select->close();
} else {
    // Output error for debugging
    echo "Error: " . $conn->error;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Get form data
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $tupId = $_POST['tupId'];

    // Prepare an update statement using prepared statement
    $sql_update = "UPDATE users SET first_name=?, last_name=?, email=?, TUP_id=? WHERE UserID=?";
    
    if ($stmt_update = $conn->prepare($sql_update)) {
        // Bind parameters to the statement
        $stmt_update->bind_param("ssssi", $firstName, $lastName, $email, $tupId, $userId);
        
        // Attempt to execute the prepared statement
        if ($stmt_update->execute()) {
            // Redirect back to admin_profile_settings.php after successful update
            header("Location: admin_profile_settings.php");
            exit; // Ensure that no further code is executed after the redirect
        } else {
            // Output error for debugging
            echo "Error updating profile: " . $stmt_update->error;
        }

        // Close statement
        $stmt_update->close();
    } else {
        // Output error for debugging
        echo "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
