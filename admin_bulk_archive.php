<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if fileIds are sent in the request body
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['fileIds']) && is_array($data['fileIds'])) {
        // Database connection
        $db = new mysqli("localhost", "root", "", "ebulletin_system");
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Archive each selected file
        foreach ($data['fileIds'] as $fileId) {
            // Perform the archive operation (update the database, for example)
            // Example query to update the is_archived flag in the database
            $sql = "UPDATE bulletin_files SET is_archived = 1 WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $fileId);
            $stmt->execute();
            $stmt->close();
        }
        echo "Files archived successfully";
    } else {
        echo "Invalid data received";
    }
} else {
    // If request method is not POST, return an error message
    echo "Invalid request method";
}
?>
