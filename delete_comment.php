<?php
// delete_comment.php
include 'config.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentId = $_POST['comment_id'];

    // Delete the comment from the database
    $sql = "DELETE FROM comments WHERE comment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $commentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete comment.']);
    }

    $stmt->close();
    $conn->close();
}
?>
