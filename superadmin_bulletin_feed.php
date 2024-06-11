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
    <title>Admin Dashboard</title>
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Include FontAwesome for social media icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>EBBS</title>
    <style>

        /* Inherit font-family for all other elements */
        * {
            font-family: inherit;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Set background color */
        }
        .navbar {
            background-color: #800000; /* Set navbar background color */
            color: maroon;
            padding: 15px 40px; /* Adjust padding to increase width */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
            position: relative;
            transition: font-weight 0s; /* Add transition effect */
            font-weight: normal; /* Set normal font weight */
        }

        .navbar .logo {
            font-weight: bold; /* Added bold font weight */
            margin-left: 10px; /* Adjusted left margin */
        }

        .navbar a:hover {
            font-weight: bold; /* Make text bold on hover */
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

        .navbar .logo {
            font-weight: bold; /* Added bold font weight */
            margin-left: -10px; /* Adjusted left margin */
            font-size: 20px; /* Increased font size */
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            margin-top: 50px;
            flex-wrap: wrap;
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
            margin-bottom: 10px;
            white-space: pre-wrap; /* Preserve line breaks and wrap long lines */
            overflow: visible;
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

    .hamburger {
    display: none; /* Hidden by default */
    font-size: 24px; /* Adjust font size for hamburger icon */
    color: white; /* Set font color to white */
    cursor: pointer;
}

/* Side navbar styles */
.side-navbar {
    position: fixed;
    top: 0;
    right: -250px; /* Initially hide the side navbar on the right */
    width: 250px;
    height: 100%;
    background-color: #800000;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    padding-top: 60px;
    z-index: 1000;
    transition: right 0.3s ease;
    font-size: 16px;
    color: white;
}

/* Close button */
.close-btn {
    position: absolute;
    top: 15px;
    left: 15px;
    font-size: 24px;
    color: white;
    cursor: pointer;
    color: white;
}

.side-navbar a {
    color: white;
    display: block;
    padding: 10px 20px;
    text-decoration: none;
}

.side-navbar a:hover {
    background-color: #575757; /* Change background on hover */
}

/* Ensure responsiveness */
@media (max-width: 768px) {
    .navbar a {
        display: none; /* Hide navbar links */
    }
    .navbar .logo {
        display: block; /* Ensure the logo is always displayed */
    }
    .hamburger {
        display: block; /* Show hamburger menu */
    }
}

.dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
    background-color: #800000;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #800000;
        }

         /* Hide the dropdown content when screen size is small */
         @media only screen and (max-width: 768px) {
            .dropdown-content {
                display: none;
            }
        }
         /* Hide the dropdown content when screen size is small */
         @media only screen and (max-width: 768px) {
            .dropbtn {
                display: none;
            }
        }
        .indent {
    margin-left: 20px; /* Adjust indentation as needed */
}
.delete-icon {
    cursor: pointer;
    color: red;
    margin-left: 10px;
    font-weight: bold;
}

.share-buttons {
    display: flex;
    justify-content: space-around;
    margin-top: 10px;
}

.share-buttons {
    display: flex;
    justify-content: space-around;
    margin-top: 10px;
}

.share-buttons a {
    text-decoration: none;
    color: white;
    background-color: #3b5998; /* Facebook blue */
    padding: 5px 10px; /* Smaller padding */
    border-radius: 5px;
    transition: background-color 0.3s;
    font-size: 12px; /* Smaller font size */
}

.share-buttons a i {
    margin-right: 3px; /* Smaller icon spacing */
    font-size: 12px; /* Smaller icon size */
}

.share-buttons a:hover {
    background-color: #2d4373;
}

.share-buttons a:nth-child(2) {
    background-color: #1da1f2; /* Twitter blue */
}

.share-buttons a:nth-child(2):hover {
    background-color: #0c85d0;
}

.share-buttons a:nth-child(3) {
    background-color: #E4405F; /* Instagram gradient */
}

.share-buttons a:nth-child(3):hover {
    background-color: #D62976;
}



    </style>
</head>
<body>
<div class="navbar">
    <div>
        <a href="superadmin_bulletin.php" class="logo">TUPM-COS EBBS</a>
    </div>
    <div>
        <!-- Dropdown menu for Bulletin Feed -->
        <div class="dropdown" onmouseover="showDropdown()" onmouseout="hideDropdown()">
            <button class="dropbtn">Bulletin</button>
            <div class="dropdown-content" id="bulletinDropdown">
                <a href="superadmin_bulletin.php">Bulletin Board</a>
                <a href="superadmin_bulletin_feed.php">Bulletin Feed</a>
            </div>
        </div>
        <!-- End of Dropdown menu -->
        <!-- Dropdown menu for Posts -->
        <div class="dropdown" onmouseover="showPostsDropdown()" onmouseout="hidePostsDropdown()">
            <button class="dropbtn">Posts</button>
            <div class="dropdown-content" id="postsDropdown">
                <a href="superadmin_upload.php">Uploads</a>
                <!-- <a href="superadmin_approved_post.php">Approved</a>
                <a href="superadmin_for_approval.php">For Approval</a>
                <a href="superadmin_rejected.php">Rejected</a> -->
            </div>
        </div>
        <!-- End of Dropdown menu -->
        <a href="superadmin_archive.php">Archive</a>
        <a href="superadmin_profile_settings.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="hamburger" onclick="toggleSideNavbar()">
        <i class="fas fa-bars"></i>
    </div>
</div>

<!-- Side navbar -->
<div class="side-navbar" id="sideNavbar">
    <div class="close-btn" onclick="toggleSideNavbar()">
        <i class="fas fa-times"></i>
        </div>
    <a>Bulletin</a>
    <div class="indent">
        <a href="superadmin_bulletin_feed.php">Bulletin Feed</a>
        <a href="superadmin_bulletin.php">Bulletin Board</a>
    </div>
    <a>Posts</a>
    <div class="indent">    
        <a href="superadmin_upload.php">Uploads</a>
        <!-- <a href="superadmin_approved_post.php">Approved</a>
        <a href="superadmin_for_approval.php">For Approval</a>
        <a href="superadmin_rejected.php">Rejected</a> -->
    </div>
    <a href="superadmin_archive.php">Archive</a>
    <a>Profile</a>
    <div class="indent">
        <a href="superadmin_profile_settings.php">Profile Info</a>
        <a href="superadmin_change_username.php">Change Username</a>
        <a href="superadmin_change_password.php">Change Password</a>
    </div>
    <a href="logout.php">Logout</a>
</div>

<?php
include "config.php"; // Include the database connection file

// Query to fetch data from the bulletin_files table
$sql = "SELECT * FROM bulletin_files 
WHERE is_archived = 0 
  AND schedule <= NOW()
ORDER BY upload_time DESC";
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) { 
    // Iterate through each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Generate HTML for each post container dynamically
        echo '<div class="post-container">';
        echo '<h2 class="post-title">' . $row['title'] . '</h2>';
        
        // Display the schedule time
        echo '<p class="post-schedule">Posted on: ' . date('F j, Y, g:i a', strtotime($row['schedule'])) . '</p>';

        // Display truncated description with "See more" link for long descriptions
        $description = $row['description'];
        $maxLength = 100; // Maximum length of the description
        if (strlen($description) > $maxLength) {
            // Truncate the description
            $truncatedDescription = substr($description, 0, $maxLength) . '...';
            echo '<p class="post-description">' . $truncatedDescription;
            // Add a "See more" link to toggle full description
            echo '<a href="#" class="see-more-link" data-toggle="description-' . $row['id'] . '">See more</a>';
            echo '</p>';
            // Hidden full description
            echo '<p class="full-description" id="description-' . $row['id'] . '" style="display: none;">' . $description;
            // Add a "See less" link to toggle back to truncated description
            echo '<a href="#" class="see-less-link" data-toggle="description-' . $row['id'] . '">See less</a>';
            echo '</p>';
        } else {
            // Display the full description if it's short
            echo '<p class="post-description">' . $description . '</p>';
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

        // Social media share buttons
        $postUrl = urlencode('https://www.facebook.com/TUPMCOS' . $row['id']);
        $postTitle = urlencode($row['title']);
        echo '<div class="share-buttons">';
        echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $postUrl . '" target="_blank"><i class="fab fa-facebook"></i> Share on Facebook</a>';
        echo '<a href="https://twitter.com/intent/tweet?text=' . $postTitle . '&url=' . $postUrl . '" target="_blank"><i class="fab fa-twitter"></i> Share on Twitter</a>';
        echo '<a href="https://www.instagram.com/?url=' . $postUrl . '" target="_blank"><i class="fab fa-instagram"></i> Share on Instagram</a>';
        echo '</div>';

        echo '</div>'; // Close the post container
    }
} else {
    echo 'No posts found.';
}

// Close the database connection
mysqli_close($conn);
?>






<!-- JavaScript code... -->
<script>
function deleteComment(commentId) {
    if (confirm("Are you sure you want to delete this comment?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_comment.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Comment deleted successfully.");
                    location.reload(); // Reload the page to reflect the changes
                } else {
                    alert("Error deleting comment: " + response.message);
                }
            }
        };
        xhr.send("comment_id=" + commentId);
    }
}
</script>
<script>
    // Function to save the current scroll position before submitting a comment
    function saveScrollPosition() {
        // Save the current scroll position in a session variable
        sessionStorage.setItem('scrollPosition', window.scrollY || window.pageYOffset);
    }

    // Function to restore the scroll position after the page reloads
    function restoreScrollPosition() {
        var scrollPos = sessionStorage.getItem('scrollPosition');
        if (scrollPos !== null) {
            window.scrollTo(0, parseInt(scrollPos)); // Parse the scroll position as an integer
            sessionStorage.removeItem('scrollPosition'); // Remove the saved scroll position from session storage
        }
    }

    // Call the function when the window loads
    window.onload = function() {
        restoreScrollPosition();

        // Add event listeners to comment buttons
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

        // AJAX submission for comment form
        document.querySelectorAll('.comment-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent form submission
                var formData = new FormData(this); // Create form data object
                var postId = formData.get('post_id'); // Get post ID from form data
                var commentContainer = this.parentElement.nextElementSibling; // Get the comment container

                // Send AJAX request to submit the comment
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'superadmin_submit_comment.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // On success, reload the comment section without page reload
                        commentContainer.innerHTML = xhr.responseText;
                        commentContainer.style.display = 'block'; // Keep the comment section open
                    } else {
                        // On failure, handle the error
                        console.error('Error submitting comment: ' + xhr.status);
                    }
                };
                xhr.onerror = function() {
                    console.error('Error submitting comment: Network error');
                };
                xhr.send(formData); // Send form data
            });
        });
    };

    // Function to toggle side navbar
    function toggleSideNavbar() {
        var sideNavbar = document.getElementById('sideNavbar');
        if (sideNavbar.style.right === '0px') {
            sideNavbar.style.right = '-250px'; // Collapse side navbar
        } else {
            sideNavbar.style.right = '0px'; // Expand side navbar
        }
    }

    // Function to automatically close side navbar on larger screens
    function closeSideNavbarOnLargeScreen() {
        var sideNavbar = document.getElementById('sideNavbar');
        var screenWidth = window.innerWidth;
        if (screenWidth > 768) { // Adjust the threshold as needed
            sideNavbar.style.right = '-250px'; // Collapse side navbar if screen width is greater than 768px
        }
    }

    // Call the function when the window is resized
    window.onresize = closeSideNavbarOnLargeScreen;

 // Function to toggle visibility of full and truncated descriptions
document.querySelectorAll('.see-more-link').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor behavior
        var targetId = this.getAttribute('data-toggle');
        var targetElement = document.getElementById(targetId);
        var truncatedDescription = targetElement.previousElementSibling; // Get the truncated description
        truncatedDescription.style.display = 'none'; // Hide the truncated description
        targetElement.style.display = 'block'; // Show the full description
        this.style.display = 'none'; // Hide the "See more" link
        var seeLessLink = document.querySelector('[data-toggle="' + targetId + '"].see-less-link');
        seeLessLink.style.display = 'inline'; // Show the "See less" link
    });
});
document.querySelectorAll('.see-less-link').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor behavior
        var targetId = this.getAttribute('data-toggle');
        var targetElement = document.getElementById(targetId);
        targetElement.style.display = 'none'; // Hide the full description
        var seeMoreLink = document.querySelector('[data-toggle="' + targetId + '"].see-more-link');
        seeMoreLink.style.display = 'inline'; // Show the "See more" link
        this.style.display = 'none'; // Hide the "See less" link
        var truncatedDescription = targetElement.previousElementSibling; // Get the truncated description
        truncatedDescription.style.display = 'block'; // Show the truncated description
    });
});
</script>

<script>
    // Function to show the dropdown menu
    function showDropdown() {
        var dropdown = document.getElementById("bulletinDropdown");
        dropdown.style.display = "block";
    }

    // Function to hide the dropdown menu
    function hideDropdown() {
        var dropdown = document.getElementById("bulletinDropdown");
        dropdown.style.display = "none";
    }
</script>
</body>
</html>

