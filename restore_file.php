<?php
// Include database connection
include('config.php');

// Check if ID is provided
if(isset($_GET['id'])) {
    // Prepare and bind the parameterized query
    $sql = "UPDATE bulletin_files SET is_archived = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);

    // Execute the statement
    if ($stmt->execute()) {
        echo "File restored successfully.";
    } else {
        echo "Error restoring file: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "File ID not provided.";
}

// Close the database connection
$conn->close();
?>
