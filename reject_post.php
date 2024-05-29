<?php
// Connect to the database
$db = new mysqli("localhost", "root", "", "ebulletin_system");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if ID, action, and remarks are set in POST
if(isset($_POST['id']) && isset($_POST['action']) && isset($_POST['remarks'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $remarks = $db->real_escape_string($_POST['remarks']);

    // Update remarks
    $updateRemarksSql = "UPDATE bulletin_files SET remarks = ? WHERE id = ?";
    $updateRemarksStmt = $db->prepare($updateRemarksSql);
    $updateRemarksStmt->bind_param("si", $remarks, $id);

    if ($updateRemarksStmt->execute()) {
        // Update status based on action
        if ($action === 'reject') {
            // Update status to 'rejected'
            $updateStatusSql = "UPDATE bulletin_files SET status = 'rejected' WHERE id = ?";
            $updateStatusStmt = $db->prepare($updateStatusSql);
            $updateStatusStmt->bind_param("i", $id);

            if ($updateStatusStmt->execute()) {
                echo "Post rejected successfully.";
            } else {
                echo "Error: " . $db->error;
            }
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Error updating remarks: " . $db->error;
    }
} else {
    echo "Invalid request.";
}

// Close database connection
$db->close();
?>
