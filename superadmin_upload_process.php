<?php
// Connect to the database
$db = new mysqli("localhost", "root", "", "ebulletin_system");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to process scheduled uploads
function processScheduledUploads($db) {
    // Get current date and time
    $currentDateTime = date("Y-m-d H:i:s");

    // Query for scheduled uploads
    $sql = "SELECT * FROM bulletin_files WHERE schedule <= ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $currentDateTime);
    $stmt->execute();
    $result = $stmt->get_result();

    // Process scheduled uploads
    while ($row = $result->fetch_assoc()) {
        // Process each scheduled upload as needed
        // For example, move the file to a specific location
        $sourceFilePath = "uploads/" . $row['filename'];
        $destinationFilePath = "processed_uploads/" . $row['filename'];

        // Check if the source file exists
        if (file_exists($sourceFilePath)) {
            // Check if the destination directory exists, if not create it
            if (!is_dir('processed_uploads')) {
                mkdir('processed_uploads', 0777, true);
            }

            // Attempt to rename (move) the file
            if (rename($sourceFilePath, $destinationFilePath)) {
                // Update database to reflect that the file has been edited
                $updateSql = "UPDATE bulletin_files SET edited = 1 WHERE id = ?";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bind_param("i", $row['id']);
                $updateStmt->execute();

                // Log the successful processing
                echo "File '{$row['filename']}' processed successfully.\n";
            } else {
                // Log any errors that occur during processing
                echo "Error processing file '{$row['filename']}'.\n";
            }
        } else {
            echo "Source file '{$row['filename']}' does not exist.\n";
        }
    }

    // Close statement
    $stmt->close();
}

// Call function to process scheduled uploads
processScheduledUploads($db);

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
        $schedule = $_POST["schedule"]; // Added to retrieve scheduled date and time
        $endTime = $_POST["endTime"]; // Added to retrieve end time

        // Get uploader's username from session
        session_start();
        $uploader = $_SESSION["username"]; // Assuming you have a session storing the username

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
                    // Prepare SQL statement to insert file details into the database
                    $sql = "INSERT INTO bulletin_files (filename, title, description, filetype, schedule, end_time, uploader) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("sssssss", $uniqueFileName, $title, $description, $fileType, $schedule, $endTime, $uploader); // Bind uploader and end time parameters

                    // Execute the prepared statement
                    if ($stmt->execute()) {
                        // Close statement
                        $stmt->close();

                        // Redirect to admin_dashboard.php
                        header("Location: superadmin_upload.php");
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


// Close database connection
$db->close();
?>
