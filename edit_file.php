<?php
// Include the database configuration file
require_once "config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all necessary data is provided
    if (isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["description"])) {
        // Sanitize the input data
        $id = $_POST["id"];
        $title = htmlspecialchars($_POST["title"]);
        $description = htmlspecialchars($_POST["description"]);

        // Update the record in the database
        $sql = "UPDATE bulletin_files SET title='$title', description='$description' WHERE id='$id'";
        if ($db->query($sql) === TRUE) {
            // Redirect back to the page where the user can view the files
            header("Location: admin_upload.php");
            exit;
        } else {
            echo "Error updating record: " . $db->error;
        }
    } else {
        echo "Incomplete data provided.";
    }
} else {
    echo "Invalid request.";
}
?>
