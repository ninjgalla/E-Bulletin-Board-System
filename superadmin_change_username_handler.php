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

// Fetch username from the session
$username = $_SESSION['username'];

// Define variables and initialize with empty values
$new_username = "";
$new_username_err = "";
$message = "";
$username_change_successful = false; // Initialize as false

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate new username
    if (empty(trim($_POST["new_username"]))) {
        $new_username_err = "Please enter a new username.";
    } else {
        $param_new_username = trim($_POST["new_username"]);

        // Prepare a select statement to check if the new username is already taken
        $sql_check_username = "SELECT UserID FROM users WHERE username = ?";
        if ($stmt_check_username = $conn->prepare($sql_check_username)) {
            // Bind variables to the prepared statement as parameters
            $stmt_check_username->bind_param("s", $param_new_username);

            // Attempt to execute the prepared statement
            if ($stmt_check_username->execute()) {
                // Store result
                $stmt_check_username->store_result();

                if ($stmt_check_username->num_rows == 1) {
                    $new_username_err = "This username is already taken.";
                } else {
                    $new_username = $param_new_username;
                }
            } else {
                $message = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt_check_username->close();
        } else {
            $message = "Oops! Something went wrong. Please try again later.";
        }
    }


    // Check input errors before updating the database
    if (empty($new_username_err)) {
        // Prepare an update statement
        $sql_update_username = "UPDATE users SET username = ? WHERE username = ?";
        if ($stmt_update_username = $conn->prepare($sql_update_username)) {
            // Bind variables to the prepared statement as parameters
            $stmt_update_username->bind_param("ss", $new_username, $username);

            // Attempt to execute the prepared statement
            if ($stmt_update_username->execute()) {
                // Username updated successfully. Update the session variable and set flag to true
                $_SESSION['username'] = $new_username;
                $username_change_successful = true;
                $message = "Username changed successfully!";
            } else {
                $message = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt_update_username->close();
        } else {
            $message = "Oops! Something went wrong. Please try again later.";
        }
    }
}

// Close connection
$conn->close();
// Redirect back to profile_settings.php
header("Location: superadmin_change_username.php?message=" . urlencode($message));
exit;
?>