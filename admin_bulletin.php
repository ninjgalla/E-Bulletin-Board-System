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
        .file-item {
            display: flex;
            align-items: center;
            padding: 10px; /* Adjust spacing */
            margin: 10px 0; /* Adjust margin to add space between items */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
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
    margin-top: 40px;
    position: fixed; /* Fix position */
    left: 50px; /* Adjust left spacing */
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
    top: 40%;
    left: 30px;
    transform: translateY(-50%);
    text-align: left;
    padding: 10px;
    border-radius: 5px;
}

    </style>
</head>
<body>
<div class="navbar">
    <div>
        <a href="admin_dashboard.php" class="logo">TUPM-COS EBBS</a>
    </div>
    <div>
        <a href="admin_upload.php">Upload</a>
        <a href="admin_bulletin_feed.php">Bulletin Feed</a>
        <a href="admin_archive.php">Archive</a>
        <a href="admin_profile_settings.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="hamburger" onclick="toggleSideNavbar()">
        <i class="fas fa-bars"></i>
    </div>
</div>

<div class="side-navbar" id="sideNavbar">
    <div class="close-btn" onclick="toggleSideNavbar()">
        <i class="fas fa-times"></i>
    </div>
    <a href="admin_upload.php">Upload</a>
    <a href="admin_bulletin_feed.php">Bulletin Feed</a>
    <a href="admin_archive.php">Archive</a>
    <a href="admin_profile_settings.php">Profile</a>
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
        $sql = "SELECT * FROM bulletin_files WHERE is_archived = 0 AND schedule <= NOW() ORDER BY upload_time DESC"; // Modify the query to fetch only non-archived files with a schedule in the past or current time
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

        items[currentIndex].style.display = 'block';

        const currentVideo = items[currentIndex].querySelector('video');

        if (currentVideo) {
            currentVideo.autoplay = true;
            currentVideo.muted = true;

            currentVideo.currentTime = 0;
            currentVideo.play();

            currentVideo.addEventListener('ended', function() {
                showNextItem(); // Call showNextItem() when the video ends
            });

            currentVideo.onerror = function() {
                setTimeout(showNextItem, 3000);
            };
        } else {
            setTimeout(showNextItem, 3000);
        }

        // Update title and description
        const titleElement = document.getElementById('fileTitle');
        const descriptionElement = document.getElementById('fileDescription');
        const fileInfoElement = document.getElementById('fileInfo');

        const currentFile = items[currentIndex];
        const title = currentFile.dataset.title;
        const description = currentFile.dataset.description;

        titleElement.textContent = title;
        descriptionElement.textContent = description;

        // Check if the title and description are short
        if (title.length <= 20 && description.length <= 100) {
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
    window.location.href = "admin_bulletin.php";
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
