<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('config.php');

// Check if id is provided in the request
if (isset($_GET['id'])) {
    // Sanitize the id
    $postId = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch comments from the database for the given postId
    $sql = "SELECT user_id, comment_text FROM comments WHERE post_id = '$postId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $comments = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }
        // Send JSON response
        echo json_encode($comments);
    } else {
        // Error fetching comments
        echo json_encode(array('error' => 'Error fetching comments'));
    }
} else {
    // No id provided in the request
    echo json_encode(array('error' => 'No id provided'));
}

// Close the database connection
mysqli_close($conn);
?>
