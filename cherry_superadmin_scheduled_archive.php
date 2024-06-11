<?php
// Connect to the database
$db = new mysqli("localhost", "root", "", "ebulletin_system");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Query for scheduled archives
$sql = "SELECT * FROM bulletin_files WHERE end_time <= NOW() AND is_archived = 0";
$result = $db->query($sql);

// Process scheduled archives
while ($row = $result->fetch_assoc()) {
    $updateSql = "UPDATE bulletin_files SET is_archived = 1 WHERE id = ?";
    $updateStmt = $db->prepare($updateSql);
    $updateStmt->bind_param("i", $row['id']);
    $updateStmt->execute();
    echo "File '{$row['filename']}' archived successfully.\n";
}

// Close statement and database connection
$result->free();
$db->close();
?>
