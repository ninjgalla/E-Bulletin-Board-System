<?php
// Fetch files from database
$db = new mysqli("localhost", "root", "", "bulletin_files");
$result = $db->query("SELECT * FROM bulletin_files ORDER BY upload_time DESC");
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Board</title>
    <style>
        .file-container {
            display: flex;
            flex-wrap: wrap;
        }
        .file-item {
            margin: 10px;
        }
    </style>
</head>
<body>
    <h2>Bulletin Board</h2>
    <div class="file-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="file-item">
                <?php if ($row["filetype"] == "photo"): ?>
                    <img src="uploads/<?php echo $row["filename"]; ?>" alt="Photo">
                <?php elseif ($row["filetype"] == "video"): ?>
                    <video controls>
                        <source src="uploads/<?php echo $row["filename"]; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
                <p>Uploader: <?php echo $row["uploader"]; ?></p>
                <p>Uploaded on: <?php echo $row["upload_time"]; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
