<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Include database connection
include('config.php');

// Fetch username from the session
$username = $_SESSION['username'];

?>

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
            max-width: 500px; /* Maximum width for post container */
            width: 100%; /* Ensure full width on smaller screens */
            margin: 20px auto; /* Center the container */
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 50px;
            margin-top: 50px;
        }


        .post-title {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .post-media {
            max-width: 100%;
            margin-bottom: 10px;
        }

        .post-description {
            text-align: left;
            overflow: hidden;
            max-height: 100px;
            margin-bottom: 10px;
        }

        .see-more {
            color: blue;
            cursor: pointer;
            display: inline; /* Ensure "See more" is initially visible */
        }

        .see-less {
            color: blue;
            cursor: pointer;
            display: none;
        }

        .more,
        .less {
            cursor: pointer;
            color: blue;
        }

        /* Comment field  */
        .comment-container {
            display: flex;
            align-items: center;
            width: 100%; /* Extend the width to occupy the full container */
        }

        .comment-field {
            flex: 1; /* Make the comment field flex to occupy available space */
            padding: 8px;
            margin-top: 10px;
            margin-right: 5px; /* Adjusted to create space between field and button */
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
            position: relative; /* Positioning for the placeholder */
        }

        .comment-field:focus {
            outline: none;
            border-color: blue;
        }

        .comment-field::placeholder {
            color: #aaa;
            position: absolute; /* Position the placeholder */
            left: 10px; /* Adjusted to position the placeholder */
        }

        .comment-field:hover {
            border-color: #999;
        }

        .comment-button {
            padding: 8px 12px;
            border: none;
            margin-top: 9px;
            background-color: darkred;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .comment-button:hover {
            background-color: maroon;
        }

        /* Media queries for responsiveness */
        @media only screen and (max-width: 600px) {
            .post-container {
                max-width: 90%; /* Reduce maximum width for smaller screens */
            }

            .comment-field {
                padding: 8px; /* Adjust padding for comment field on smaller screens */
                width: calc(100% - 10px); /* Extend the width to occupy the available space */
            }
        }


    </style>
</head>
<body>
    <div class="navbar">
    <div>
        <a href="user_bulletin_feed.php">Home</a>
        <a href="profile_settings.php">Profile</a>
    </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
<?php
include "config.php"; // Include the database connection file

// Query to fetch data from the bulletin_files table
$sql = "SELECT id, title, description, filename, filetype FROM bulletin_files WHERE is_archived = 0"; // Assuming you only want non-archived files
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Iterate through each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Generate HTML for each post container dynamically
        echo '<div class="post-container">';
        echo '<h2 class="post-title">' . $row['title'] . '</h2>';
        // Check if the description is long
        if (strlen($row['description']) > 100) {
            echo '<p class="description">' . substr($row['description'], 0, 100) . ' <span class="more">... <a href="#" class="see-more">See more</a></span></p>';
            echo '<p class="full-description" style="display: none;">' . $row['description'] . ' <span class="less" style="display: none;"><a href="#" class="see-less">See less</a></span></p>';
        } else {
            // If description is short, display it without "See more" link
            echo '<p class="description">' . $row['description'] . '</p>';
        }
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
       // Add a comment container with text field and button
        echo '<div class="comment-container">';
        echo '<form method="post" action="submit_comment.php">'; // Set the action to submit_comment.php
        echo '<input type="hidden" name="post_id" value="' . $row['id'] . '">'; // Add a hidden input for post_id
        echo '<input type="text" name="comment" class="comment-field" placeholder="Add a comment...">';
        echo '<button type="submit" class="comment-button">Post</button>';
        echo '</form>'; // Close form
        echo '</div>'; // Close comment-container
        echo '</div>'; // Close post-container
        
    }
} else {
    // If no rows are returned, display a message
    echo "No posts found.";
}

// Close the database connection
mysqli_close($conn);
?>


<script>
    // JavaScript for "See more" and "See less" functionality
    var seeMoreLinks = document.querySelectorAll('.see-more');
    var seeLessLinks = document.querySelectorAll('.see-less');

    seeMoreLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var post = this.closest('.post-container');
            post.querySelector('.description').style.display = 'none';
            post.querySelector('.full-description').style.display = 'block';
            post.querySelector('.less').style.display = 'inline';
            this.style.display = 'none';
            post.querySelector('.see-less').style.display = 'inline'; // Show "See less"
            console.log("See more clicked");
        });
    });

    seeLessLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var post = this.closest('.post-container');
            post.querySelector('.description').style.display = 'block';
            post.querySelector('.full-description').style.display = 'none';
            post.querySelector('.more').style.display = 'inline';
            post.querySelector('.see-more').style.display = 'inline'; // Show "See more"
            this.style.display = 'none';
            console.log("See less clicked");
        });
    });

</script>

</body>
</html>
