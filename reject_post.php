<?php
// Connect to the database
$db = new mysqli("localhost", "root", "", "ebulletin_system");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if ID and action are set in POST
if(isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    // Update status based on action
    if($action === 'reject') {
        $updateSql = "UPDATE bulletin_files SET status = 'rejected' WHERE id = ?";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->bind_param("i", $id);

        if ($updateStmt->execute()) {
            echo "Post rejected successfully.";
        } else {
            echo "Error: " . $db->error;
        }
    } else {
        // Handle other actions if needed
        echo "Invalid action.";
    }
} else {
    echo "Invalid request.";
}

// Close database connection
$db->close();
?>
