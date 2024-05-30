<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fileIds']) && !empty($_POST['fileIds'])) {
        $fileIds = $_POST['fileIds'];

        // Include the database connection file
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

        foreach ($fileIds as $fileId) {
            $fileId = intval($fileId);
            $sql = "UPDATE bulletin_files SET is_archived = 0 WHERE id = $fileId";

            if ($conn->query($sql) === TRUE) {
                echo "File restored successfully. ";
            } else {
                echo "Error restoring file: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No files selected for restoration.";
    }
} else {
    echo "Invalid request method.";
}
?>
