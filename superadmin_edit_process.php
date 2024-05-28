<?php
// admin_edit_process.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if all required fields are filled
    if (isset($_POST["editId"]) && isset($_POST["editTitle"]) && isset($_POST["editDescription"]) && isset($_POST["editSchedule"])) {
        
        // Retrieve data from the form and sanitize input
        $id = intval($_POST["editId"]);
        $new_title = htmlspecialchars(trim($_POST["editTitle"]), ENT_QUOTES, 'UTF-8');
        $new_description = htmlspecialchars(trim($_POST["editDescription"]), ENT_QUOTES, 'UTF-8');
        $new_schedule = htmlspecialchars(trim($_POST["editSchedule"]), ENT_QUOTES, 'UTF-8');
        
        // Establish database connection
        $conn = new mysqli("localhost", "root", "", "ebulletin_system");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if a file is uploaded
        if (!empty($_FILES["editFile"]["name"])) {
            // File upload handling
            $targetDir = "uploads/";
            $fileName = basename($_FILES["editFile"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowedPhotoTypes = array('png', 'jpeg', 'jpg', 'gif');
            $allowedVideoTypes = array('mp4', 'mov', 'avi');
            $allowedFileTypes = array_merge($allowedPhotoTypes, $allowedVideoTypes);
            
            // Validate file type
            if (!in_array($fileType, $allowedFileTypes)) {
                echo "Invalid file type.";
                exit();
            }

            // Upload file to server
            if (move_uploaded_file($_FILES["editFile"]["tmp_name"], $targetFilePath)) {
                // Determine file type (photo or video)
                $fileType = in_array($fileType, $allowedPhotoTypes) ? 'photo' : 'video';

                // Prepare and execute SQL statement to update the item with file
                $sql = "UPDATE bulletin_files SET title = ?, description = ?, filename = ?, filetype = ?, schedule = ?, edited = 1 WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $new_title, $new_description, $fileName, $fileType, $new_schedule, $id);
            } else {
                // Error uploading file
                echo "Error uploading file.";
                exit();
            }
        } else {
            // Prepare and execute SQL statement to update the item without file
            $sql = "UPDATE bulletin_files SET title = ?, description = ?, schedule = ?, edited = 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $new_title, $new_description, $new_schedule, $id);
        }

        // Execute SQL statement
        if ($stmt->execute()) {
            // Item updated successfully, redirect to admin_upload.php
            header("Location: superadmin_upload.php");
            exit();
        } else {
            // Error occurred while updating item
            echo "Error updating item: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
        
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
