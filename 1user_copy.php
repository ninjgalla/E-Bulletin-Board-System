<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Feed</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: white;
            color: maroon;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: maroon;
            text-decoration: none;
            margin-right: 15px;
            position: relative;
            transition: font-weight 0s;
            font-weight: normal;
        }

        .navbar a:hover {
            font-weight: bold;
        }

        .navbar a:hover::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -3px;
            width: 100%;
            height: 2px;
            background-color: maroon;
        }

        .post-container {
            width: 500px; /* Adjust the width as needed */
            margin: 20px auto; /* Center the container */
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .post-title {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .post-media {
            max-width: 100%;
            margin-bottom: 10px;
        }

        .post-description {
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="1user_copy.php">Home</a>
            <a href="profile_settings.php">Profile</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <?php
include "config.php"; // Include the database connection file

// Query to fetch data from the bulletin_files table
$sql = "SELECT title, description, filename, filetype FROM bulletin_files WHERE is_archived = 0"; // Assuming you only want non-archived files
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Iterate through each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Generate HTML for each post container dynamically
        echo '<div class="post-container">';
        echo '<h2 class="post-title">' . $row['title'] . '</h2>';
        echo '<p class="post-description">' . $row['description'] . '</p>';
        // Check if the file type is an image
        if (strpos($row['filetype'], 'photo') !== false) {
            echo '<img class="post-media" src="uploads/' . $row['filename'] . '" alt="' . $row['title'] . '">';
        }
        // Check if the file type is a video
        elseif (strpos($row['filetype'], 'video') !== false) {
            echo '<video class="post-media" controls>';
            echo '<source src="uploads/' . $row["filename"] . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
        }
        echo '</div>';
    }
} else {
    // If no rows are returned, display a message
    echo "No posts found.";
}

// Close the database connection
mysqli_close($conn);
?>


</body>
</html>
