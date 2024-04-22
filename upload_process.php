<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define upload directory
    $uploadDir = "uploads/";

    // Check if file is uploaded successfully
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        // Extract file details
        $fileName = basename($_FILES["fileToUpload"]["name"]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $title = $_POST["title"];
        $description = $_POST["description"];

        // Generate a unique filename to prevent overwriting
        $uniqueFileName = uniqid() . '.' . $fileType;
        $targetPath = $uploadDir . $uniqueFileName;

        // Check if file already exists
        if (file_exists($targetPath)) {
            echo "Sorry, file already exists.";
        } else {
            // Check if the file meets certain criteria (you can adjust this)
            if ($_FILES["fileToUpload"]["size"] > 25000000) { // 25MB limit
                echo "Sorry, your file is too large.";
            } elseif (!in_array($fileType, array("jpg", "jpeg", "png", "gif", "mp4", "avi", "mov"))) { // Allowed file types
                echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, AVI, MOV files are allowed.";
            } else {
                // Determine the file type based on the extension
                if (in_array($fileType, array("jpg", "jpeg", "png", "gif"))) {
                    $fileType = "photo";
                } elseif (in_array($fileType, array("mp4", "avi", "mov"))) {
                    $fileType = "video";
                }

                // Attempt to move the uploaded file to the specified directory
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetPath)) {
                    // File uploaded successfully, now insert file details into database
                    $db = new mysqli("localhost", "root", "", "ebulletin_system");
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    }

                    // Prepare SQL statement to insert file details into the database
                    $sql = "INSERT INTO bulletin_files (filename, title, description, filetype) VALUES (?, ?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("ssss", $uniqueFileName, $title, $description, $fileType);

                    // Execute the prepared statement
                    if ($stmt->execute()) {
                        // Close statement and database connection
                        $stmt->close();
                        $db->close();
                        
                        // Redirect to admin_dashboard.php
                        header("Location: admin_dashboard.php");
                        exit;
                    } else {
                        echo "Error uploading file: " . $stmt->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
