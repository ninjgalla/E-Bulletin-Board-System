<?php
// Database connection parameters
$host = "localhost";
$user_name = "root";
$password = "";
$database = "ebulletin_system";

// Create connection
$conn = mysqli_connect($host, $user_name, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if action is set to delete
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Check if fileIds array is set
        if (isset($_POST['fileIds']) && is_array($_POST['fileIds'])) {
            // Loop through the selected file IDs and delete them
            foreach ($_POST['fileIds'] as $fileId) {
                // Get the filename from the database
                $sql = "SELECT filename FROM bulletin_files WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $fileId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    $filename = $row['filename'];

                    // Delete the file from the file system
                    $filePath = 'uploads/' . $filename;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Delete the file record from the database
                    $sql = "DELETE FROM bulletin_files WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $fileId);
                    $stmt->execute();
                }
            }
            // Return success response
            http_response_code(200);
            echo "Selected files permanently deleted.";
        } else {
            // Return error response if fileIds array is not set or not an array
            http_response_code(400);
            echo "No files selected for deletion.";
        }
    } else {
        // Return error response if action is not set to delete
        http_response_code(400);
        echo "Invalid action.";
    }
} else {
    // Return error response if request method is not POST
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
