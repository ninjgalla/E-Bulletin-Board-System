<?php
// Fetch uploaded files from the database
$db = new mysqli("localhost", "root", "", "ebulletin_system");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT * FROM bulletin_files ORDER BY upload_time DESC";
$result = $db->query($sql);

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <style>
        .file-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .file-item {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .file-item img,
        .file-item video {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Uploaded Files</h2>
    <div class="file-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="file-item">
                <?php if ($row["filetype"] == "photo"): ?>
                    <img src="uploads/<?php echo $row["filename"]; ?>" alt="<?php echo $row["title"]; ?>">
                <?php elseif ($row["filetype"] == "video"): ?>
                    <video controls>
                        <source src="uploads/<?php echo $row["filename"]; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
                <h3><?php echo $row["title"]; ?></h3>
                <p><?php echo $row["description"]; ?></p>
                
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
