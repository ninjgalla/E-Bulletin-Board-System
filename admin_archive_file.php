<?php
// Check if file_id parameter is provided and valid
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $fileId = $_GET['id'];
    
    // Connect to the database
    $db = new mysqli("localhost", "root", "", "ebulletin_system");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Prepare SQL statement to update the is_archived column
    $sql_update = "UPDATE bulletin_files SET is_archived = 1 WHERE id = ?";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->bind_param("i", $fileId);

    // Execute the update statement
    if ($stmt_update->execute()) {
        echo "File archived successfully";

        // Close the update statement
        $stmt_update->close();
        
        // Fetch the archived file information
        $sql_fetch = "SELECT filename FROM bulletin_files WHERE id = ?";
        $stmt_fetch = $db->prepare($sql_fetch);
        $stmt_fetch->bind_param("i", $fileId);
        $stmt_fetch->execute();
        $result = $stmt_fetch->get_result();

        // Check if file exists and move it to admin_archived.php
        if ($row = $result->fetch_assoc()) {
            $filename = $row['filename'];
            $oldFilePath = "uploads/$filename";
            $newFilePath = "admin_archived/$filename";
            if (file_exists($oldFilePath)) {
                if (rename($oldFilePath, $newFilePath)) {
                    echo "File moved to archive directory";
                } else {
                    echo "Error moving file to archive directory";
                }
            } else {
                echo "File does not exist in uploads directory";
            }
        } else {
            echo "Error fetching file information";
        }

        // Close prepared statement
        $stmt_fetch->close();
    } else {
        echo "Error archiving file: " . $db->error;
    }

    // Close the database connection
    $db->close();
} else {
    echo "Invalid file ID";
}
?>
