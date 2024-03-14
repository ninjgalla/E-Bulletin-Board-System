<?php
// Check if file was uploaded without errors
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $filename = $_FILES["file"]["name"];
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed_types = array("jpg", "jpeg", "png", "gif", "mp4", "mov", "avi");

    // Check if file type is allowed
    if (in_array(strtolower($filetype), $allowed_types)) {
        // Move uploaded file to desired directory
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($filename);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert file info into database
            $title = $_POST["title"];
            $description = $_POST["description"];
            $uploader = "John Doe"; // Example uploader name, replace with actual user
            $db = new mysqli("localhost", "root", "", "ebulletin_system");
            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }
            $query = "INSERT INTO bulletin_files (filename, filetype, title, description, uploader) VALUES ('$filename', '" . ($filetype == "mp4" || $filetype == "mov" || $filetype == "avi" ? "video" : "photo") . "', '$title', '$description', '$uploader')";
            if ($db->query($query) === TRUE) {
                header("Location: admin_dashboard.php");
            } else {
                echo "Error uploading file: " . $db->error;
            }
            $db->close();
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Invalid file type. Allowed types: JPG, JPEG, PNG, GIF, MP4, MOV, AVI.";
    }
} else {
    echo "Error uploading file.";
}
?>
