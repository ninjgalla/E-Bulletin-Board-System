<?php
// Connect to the database
$db = new mysqli("localhost", "root", "", "ebulletin_system");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get current date and time
$currentDateTime = date("Y-m-d H:i:s");

// Query for scheduled uploads
$sql = "SELECT * FROM bulletin_files WHERE schedule <= ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $currentDateTime);
$stmt->execute();
$result = $stmt->get_result();

// Process scheduled uploads
while ($row = $result->fetch_assoc()) {
    // Process each scheduled upload as needed
    // For example, move the file to a specific location
    $sourceFilePath = "uploads/" . $row['filename'];
    $destinationFilePath = "processed_uploads/" . $row['filename'];
    if (rename($sourceFilePath, $destinationFilePath)) {
        // Update database to reflect that the file has been processed
        $updateSql = "UPDATE bulletin_files SET processed = 1 WHERE id = ?";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->bind_param("i", $row['id']);
        $updateStmt->execute();
        // Log the successful processing
        echo "File '{$row['filename']}' processed successfully.\n";
    } else {
        // Log any errors that occur during processing
        echo "Error processing file '{$row['filename']}'.\n";
    }
}

// Close database connection
$stmt->close();
$db->close();
?>
