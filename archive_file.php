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
        $sql_fetch = "SELECT * FROM bulletin_files WHERE id = ?";
        $stmt_fetch = $db->prepare($sql_fetch);
        $stmt_fetch->bind_param("i", $fileId);
        $stmt_fetch->execute();
        $result = $stmt_fetch->get_result();

        // Move the file to admin_archived.php
        if ($row = $result->fetch_assoc()) {
            $filename = $row['filename'];
            // Move the file to admin_archived.php
            rename("uploads/$filename", "admin_archived/$filename");
        }

        // Close prepared statement
        $stmt_fetch->close();

        // Close the database connection
        $db->close();
    } else {
        echo "Error archiving file: " . $db->error;
    }
} else {
    echo "Invalid file ID";
}
?>
