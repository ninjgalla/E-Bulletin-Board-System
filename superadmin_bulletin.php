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
    <title>EBBS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
        }
        

        * {
            font-family: inherit;
        }

        body {
    margin: 0;
    padding: 0;
    background-image: url('background.svg'); /* Set background image */
    background-color: #f5f5f5; /* Fallback background color */
    background-size: cover; /* Cover the entire background */
    background-repeat: no-repeat; /* Prevent the image from repeating */
}


.navbar {
            background-color: #800000; /* Set navbar background color */
            color: maroon;
            padding: 15px 40px; /* Adjust padding to increase width */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
            opacity: 0; /* Initially hide the navbar */
            transition: opacity 0.3s; /* Add transition effect */
        }

        .navbar:hover {
            opacity: 1; /* Show the navbar on hover */
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

        /* For Announcements */
        .file-container {
            overflow: hidden;
            position: absolute; /* Position the container */
            right: 100px; /* Adjust the distance from the right side */
            top: 55%; /* Position from the vertical center */
            transform: translateY(-50%); /* Adjust to vertically center */
        }

        .file-inner {
            display: flex;
            flex-direction: column;
        }

        /* Updated CSS for file-item */

        @keyframes panInFromRight {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(0);
        }
    }

    @keyframes panOutToRight {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(100%);
        }
    }
        .file-item {
        display: flex;
        align-items: center;
        padding: 10px; /* Adjust spacing */
        margin: 10px 0; /* Adjust margin to add space between items */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
        animation-fill-mode: forwards; /* Retain the last keyframe state */
    }

        /* CSS for file-media */
        .file-media {
            flex-shrink: 0; /* Prevent media from shrinking */
        }

        /* CSS for file-media img and video */
        .file-media img,
        .file-media video {
            width: 100%; /* Set width to 100% */
            height: auto; /* Let the height adjust proportionally */
            max-width: 200%; /* Adjust as needed */
            max-height: 400px; /* Adjust as needed */
            border-radius: 8px; /* Add border radius */
        }

        .file-info {
    float: left;
    width: 600px; /* Adjust width as needed */
    padding-right: 20px; /* Add some spacing */
    text-align: center; /* Center-align text */
    margin-top: 110px;
    position: fixed; /* Fix position */
    left: 100px; /* Adjust left spacing */
    background-color: rgba(255, 255, 255, 0.8); /* Set opacity to 50% */
    border-radius: 10px; /* Add border radius for rounded corners */
    padding: 20px; /* Add padding for content */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
}

.file-info h2 {
    text-transform: uppercase; /* Convert text to uppercase */
    color: maroon;
    text-align: center;
}

.file-description {
    margin-bottom: 20px; /* Add some spacing between items */
}

.file-info p {
    font-size: 19px;
    text-align: justify;
    white-space: pre-wrap; /* Preserve spaces and line breaks */
}


        .file-info.centered {
            text-align: center; /* Center-align text */
        }

        .hamburger {
            display: none; /* Hidden by default */
            font-size: 24px; /* Adjust font size for hamburger icon */
            color: white; /* Set font color to white */
            cursor: pointer;
        }

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

        .center-left {
    position: absolute;
    top: 30%;
    left: 100px;
    transform: translateY(-50%);
    text-align: right;
    padding: 10px;
    border-radius: 5px;
    margin-top: 150px;
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

<div class="file-info" id="fileInfo">
    <!-- Placeholder for title and description -->
    <h2 id="fileTitle"></h2>
    <p id="fileDescription"></p>
</div>

<div class="file-container">
    <div class="file-inner" id="fileInner">
        <?php
        // Fetch uploaded files from the database
        $sql = "SELECT * FROM bulletin_files 
                WHERE is_archived = 0 
                  AND schedule <= NOW()
                ORDER BY upload_time DESC";

        $result = $conn->query($sql);
        $count = 0;

        // Display uploaded files
        while ($row = $result->fetch_assoc()): ?>
            <div class="file-item<?php echo ($count == 0) ? ' active' : ''; ?>" style="display: <?php echo ($count == 0) ? 'block' : 'none'; ?>;" 
                data-title="<?php echo $row["title"]; ?>" data-description="<?php echo $row["description"]; ?>">
                <div class="file-media">
                    <?php if ($row["filetype"] == "photo"): ?>
                        <img src="uploads/<?php echo $row["filename"]; ?>" alt="<?php echo $row["title"]; ?>">
                    <?php elseif ($row["filetype"] == "video"): ?>
                        <video controls>
                            <source src="uploads/<?php echo $row["filename"]; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                </div>
            </div>
            <?php $count++; ?>
        <?php endwhile; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.file-item');
    let currentIndex = -1;

    function showNextItem() {
        currentIndex = (currentIndex + 1) % items.length;

        items.forEach(item => {
            item.style.display = 'none';
        });

        const currentItem = items[currentIndex];
        currentItem.style.display = 'block';
        currentItem.style.animation = 'panInFromRight 1s ease-in-out forwards';

        const currentVideo = currentItem.querySelector('video');

        if (currentVideo) {
            currentVideo.autoplay = true;
            currentVideo.muted = true;

            currentVideo.currentTime = 0;
            currentVideo.play();

            currentVideo.addEventListener('ended', function() {
                setTimeout(() => {
                    currentItem.style.animation = 'panOutToRight 1s ease-in-out forwards';
                    setTimeout(showNextItem, 1000);
                }, 3000); // Show video for 2 seconds before panning out
            });

            currentVideo.onerror = function() {
                setTimeout(() => {
                    currentItem.style.animation = 'panOutToRight 1s ease-in-out forwards';
                    setTimeout(showNextItem, 1000);
                }, 3000);
            };
        } else {
            setTimeout(() => {
                currentItem.style.animation = 'panOutToRight 1s ease-in-out forwards';
                setTimeout(showNextItem, 1000);
            }, 3000); // Show image for 2 seconds before panning out
        }

        // Update title and description
        const titleElement = document.getElementById('fileTitle');
        const descriptionElement = document.getElementById('fileDescription');
        const fileInfoElement = document.getElementById('fileInfo');

        const title = currentItem.dataset.title;
        const description = currentItem.dataset.description;

        titleElement.textContent = title;
        descriptionElement.textContent = description;

        // Check if the title and description are short
        if (title.length <= 50 && description.length <= 350) {
            fileInfoElement.classList.add('center-left');
        } else {
            fileInfoElement.classList.remove('center-left');
        }
    }

    showNextItem();
});
</script>





<script>
function redirectToUploadPage() {
    window.location.href = "upload.html";
}

function redirectToAdminBulletin() {
    window.location.href = "superadmin_bulletin.php";
}
</script>

<script>
function toggleSideNavbar() {
    var sideNavbar = document.getElementById('sideNavbar');
    if (sideNavbar.style.right === '0px') {
        sideNavbar.style.right = '-250px'; // Collapse side navbar
    } else {
        sideNavbar.style.right = '0px'; // Expand side navbar
    }
}

function closeSideNavbarOnLargeScreen() {
    var sideNavbar = document.getElementById('sideNavbar');
    var screenWidth = window.innerWidth;
    if (screenWidth > 768) { // Adjust the threshold as needed
        sideNavbar.style.right = '-250px'; // Collapse side navbar if screen width is greater than 768px
    }
}

window.onload = closeSideNavbarOnLargeScreen;
window.onresize = closeSideNavbarOnLargeScreen;
</script>
</body>
</html>
