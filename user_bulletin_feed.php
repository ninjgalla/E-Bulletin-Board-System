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
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>EBBS</title>
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
    flex-direction: column; /* Change to column layout for comments */
    align-items: stretch; /* Stretch items to fill container width */
    width: 100%; /* Extend the width to occupy the full container */
    margin-top: 10px; /* Adjust the top margin to create space */
}

    .comment {
        margin-top: 10px; /* Add margin between comments */
        padding: 5px; /* Add padding for each comment */
        border-radius: 5px; /* Add border-radius for rounded corners */
    }

    .comment:nth-child(even) {
        background-color: lightgray; /* Add background color for even numbered comments */
    }

    .comment:nth-child(odd) {
        background-color: #f0f0f0; /* Add background color for odd numbered comments */
    }

    .comment-field {
    flex: 1; /* Make the comment field flex to occupy available space */
    padding: 8px;
    margin-top: 1px; /* Adjust the top margin */
    margin-right: 10px; /* Adjusted to create space between field and button */
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    transition: border-color 0.3s;
    position: relative; /* Positioning for the placeholder */
    width: calc(100% - 100px); /* Adjust the width of the comment field */
    /* Subtract the width of the post button from 100% */
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
    padding: 5px 12px;
    border: none;
    margin-top: 10px; /* Adjust the top margin */
    background-color: inherit; /* Use the same color as the container background */
    color: black; /* Set font color to black */
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    position: relative; /* Position the line relative to the button */
}

    .comment-button::before {
        content: '';
        position: absolute;
        top: -10px; /* Adjust to position the line above the button */
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #ccc; /* Color of the line */
    }

    .comment-button:hover {
        background-color: #eef1f3; /* Gray background when hovering */
    }

    .comment-button::after {
    content: '';
    position: absolute;
    left: 0;
    width: 100%;
    height: 1px;
    background-color: #ccc; /* Color of the line */
    bottom: -10px; /* Adjust to position the line below the button */
}

.post-button {
    padding: 8px 12px;
    border: none;
    margin-top: 10px; /* Adjust the top margin */
    background-color: blue; /* Change the background color of the post button */
    color: white; /* Set font color to white */
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100px; /* Set a fixed width for the post button */
    margin-left: 10px; /* Add some margin to separate the post button from the comment field */
}

    .post-button:hover {
        background-color: navy; /* Darker background color when hovering */
    }

    /* CSS for comments */
    .comments-section {
        margin-bottom: 5px;
        padding: 8px;
        border-radius: 5px;
        margin-top: 1px;
        margin-left: -8px;
       
    }

    @media only screen and (max-width: 600px) {
        .post-container {
            max-width: 90%; /* Reduce maximum width for smaller screens */
        }

        .comment-field {
            padding: 8px; /* Adjust padding for comment field on smaller screens */
            width: calc(100% - 100px); /* Adjust the width of the comment field */
            /* Subtract the width of the post button from 100% */
        }

        .post-button {
            width: 80px; /* Set a fixed width for the post button */
            margin-left: 10px; /* Add some margin to separate the post button from the comment field */
        }
    }

    @media only screen and (min-width: 601px) {
        .comment-field {
            width: calc(100% - 120px); /* Adjust the width of the comment field */
            /* Subtract the width of the post button and some additional margin from 100% */
        }

        .post-button {
            width: 100px; /* Set a fixed width for the post button */
            margin-left: 10px; /* Add some margin to separate the post button from the comment field */
        }
    }
    </style>

</head>
<body>
    <div class="navbar">
    <div>
        <a href="user_bulletin_feed.php">Home</a>
        <a href="user_profile_settings.php">Profile</a>
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
            echo '<p class="post-description">' . substr($row['description'], 0, 100) . ' <span class="more">... <a href="#" class="see-more">See more</a></span></p>';
            echo '<p class="full-description" style="display: none;">' . $row['description'] . ' <span class="less" style="display: none;"><a href="#" class="see-less">See less</a></span></p>';
        } else {
            // If description is short, display it without "See more" link
            echo '<p class="post-description">' . $row['description'] . '</p>';
        }
        // Check if the file type is an image or video and display accordingly
        if (strpos($row['filetype'], 'photo') !== false) {
            echo '<img class="post-media" src="uploads/' . $row['filename'] . '" alt="' . $row['title'] . '">';
        } elseif (strpos($row['filetype'], 'video') !== false) {
            echo '<video class="post-media" controls>';
            echo '<source src="uploads/' . $row["filename"] . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
        }

        // Add a comment button
        echo '<button class="comment-button" data-post-id="' . $row['id'] . '"><i class="fa-regular fa-comment" style="color: #000000;"></i> Comment</button>';

        // Add a comment container with text field and button (hidden initially)
        echo '<div class="comment-container" style="display: none;">';
        echo '<form method="post" action="submit_comment.php">'; // Set the action to submit_comment.php
       
        echo '<input type="hidden" name="post_id" value="' . $row['id'] . '">'; // Add a hidden input for post_id
        echo '<input type="text" name="comment" class="comment-field" placeholder="Add a comment...">';
        echo '<button type="submit" class="post-button">Post</button>';
        echo '</form>'; // Close form

       // Container to display comments
        echo '<div class="comments-section">'; 

        // Fetch comments for the post from the server using AJAX
        $postId = $row['id'];
        $sqlComments = "SELECT user_id, comment_text FROM comments WHERE post_id = '$postId'";
        $resultComments = mysqli_query($conn, $sqlComments);
        if ($resultComments) {
            $counter = 0;
            while ($comment = mysqli_fetch_assoc($resultComments)) {
                $bgColor = ($counter % 2 == 0) ? 'lightgray' : '#f0f0f0'; // Alternate background colors
                echo '<div class="comment" style="background-color: ' . $bgColor . ';">'. 'User '. $comment['user_id'] .': ' . $comment['comment_text'] . '</div>';
                $counter++;
            }
        } else {
            echo '<div>Error fetching comments.</div>';
        }
        echo '</div>'; // Close comments-section

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


<!-- JavaScript code... -->
<script>
     document.querySelectorAll('.comment-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var postId = this.getAttribute('data-post-id');
            var commentContainer = this.nextElementSibling;

            // Capture the current scroll position
            var scrollPos = window.scrollY || window.pageYOffset;

            // Toggle the visibility of the comment container
            if (commentContainer.style.display === 'none') {
                // Show the comment container
                commentContainer.style.display = 'block';
            } else {
                // Hide the comment container
                commentContainer.style.display = 'none';
            }

            // Restore the scroll position after a short delay
            setTimeout(function() {
                window.scrollTo(0, scrollPos);
            }, 100);
        });
    });
</script>

</body>
</html>
