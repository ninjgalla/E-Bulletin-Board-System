<?php
// Check if post ID is provided
if(isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Connect to the database
    $db = new mysqli("localhost", "root", "", "ebulletin_system");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Prepare and execute query to fetch post details
    $sql = "SELECT * FROM bulletin_files WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if post exists
    if ($result->num_rows > 0) {
        // Fetch post details
        $row = $result->fetch_assoc();

        // Return post details as JSON
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        // Post not found
        echo json_encode(array('error' => 'Post not found'));
    }

    // Close database connection
    $stmt->close();
    $db->close();
} else {
    // No post ID provided
    echo json_encode(array('error' => 'No post ID provided'));
}
?>
