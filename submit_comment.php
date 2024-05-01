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

// Retrieve the username from the session
$username = $_SESSION['username'];

// Query to retrieve the user ID from the users table based on the username
$sql = "SELECT UserID FROM users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful and if a row was returned
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the user ID from the result set
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['UserID']; // Retrieve the user ID
} else {
    // If the query fails or no row is returned, handle the error
    echo "Error retrieving user ID.";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both comment and post_id are provided
    if (!empty($_POST['comment']) && isset($_POST['post_id'])) {
        // Sanitize input
        $comment_text = mysqli_real_escape_string($conn, $_POST['comment']);
        $post_id = intval($_POST['post_id']); // Convert to integer

        // Get the current timestamp
        $comment_timestamp = date('Y-m-d H:i:s');

        // Insert the comment into the database
        $sql = "INSERT INTO comments (post_id, user_id, comment_text, comment_timestamp) 
        VALUES ('$post_id', '$user_id', '$comment_text', '$comment_timestamp')";

        if (mysqli_query($conn, $sql)) {
             // Redirect back to the dashboard after successful submission
                header("Location: user_bulletin_feed.php");
                exit;
        } else {
            // Error inserting comment
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Comment or post_id is missing
        echo "Both comment and post ID are required.";
    }
} else {
    // If the form is not submitted via POST method, redirect to an error page or display a message
    echo "Error: Form submission method is not POST.";
}

// Close the database connection
mysqli_close($conn);
?>
