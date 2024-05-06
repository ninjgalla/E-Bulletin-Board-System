<?php
// Include database connection
include('config.php');

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Fetch username from the session
$username = $_SESSION['username'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) {
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO feedback (username, feedback) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $feedback);

    // Set parameters and execute
    $feedback = $_POST['feedback'];
    if ($stmt->execute()) {
        // Close statement
        $stmt->close();

        // Redirect back to the dashboard after successful submission
        header("Location: user_bulletin_feed.php");
        exit;
    } else {
        // Handle database error
        echo "Error: " . $conn->error;
    }
} else {
    // Redirect back to the dashboard if form is not submitted
    header("Location: user_bulletin_feed.php");
    exit;
}
?>
