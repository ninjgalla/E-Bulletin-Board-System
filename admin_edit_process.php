<?php
// admin_edit_process.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if all required fields are filled
    if (isset($_POST["editId"]) && isset($_POST["editTitle"]) && isset($_POST["editDescription"]) && isset($_POST["editSchedule"])) {
        
        // Retrieve data from the form
        $id = $_POST["editId"];
        $new_title = $_POST["editTitle"];
        $new_description = $_POST["editDescription"];
        $new_schedule = $_POST["editSchedule"];
        
        // File upload handling
        $targetDir = "uploads/";
        $fileName = basename($_FILES["editFile"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if a file is uploaded
        if (!empty($fileName)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["editFile"]["tmp_name"], $targetFilePath)) {
                // Determine file type (photo or video)
                $allowedPhotoTypes = array('png', 'jpeg', 'jpg', 'gif');
                $fileType = in_array($fileType, $allowedPhotoTypes) ? 'photo' : 'video';

                // Assuming you have a database connection
                $db_host = "localhost";
                $db_user = "root";
                $db_pass = "";
                $db_name = "ebulletin_system";

                // Create connection
                $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare and execute SQL statement to update the item
                $sql = "UPDATE bulletin_files SET title = ?, description = ?, filename = ?, filetype = ?, schedule = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $new_title, $new_description, $fileName, $fileType, $new_schedule, $id);

                if ($stmt->execute()) {
                    // Item updated successfully, redirect to admin_upload.php
                    header("Location: admin_upload.php");
                    exit();
                } else {
                    // Error occurred while updating item
                    echo "Error updating item: " . $conn->error;
                }

                // Close statement and connection
                $stmt->close();
                $conn->close();
            } else {
                // Error uploading file
                echo "Error uploading file.";
            }
        } else {
            // No file uploaded, update only other fields
            // Assuming you have a database connection
            $db_host = "localhost";
            $db_user = "root";
            $db_pass = "";
            $db_name = "ebulletin_system";

            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute SQL statement to update the item
            $sql = "UPDATE bulletin_files SET title = ?, description = ?, schedule = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $new_title, $new_description, $new_schedule, $id);

            if ($stmt->execute()) {
                // Item updated successfully, redirect to admin_upload.php
                header("Location: admin_upload.php");
                exit();
            } else {
                // Error occurred while updating item
                echo "Error updating item: " . $conn->error;
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
        
    } else {
        // Missing required fields
        echo "Please fill all required fields.";
    }
    
} else {
    // Redirect if accessed directly
    header("Location: index.php");
    exit();
}
?>
