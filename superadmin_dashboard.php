<?php
// Connect to your database (replace these with your actual database credentials)
$host = 'localhost';
$dbname = 'ebulletin_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch post titles and their respective comments counts
    $sql = "SELECT bulletin_files.title, COUNT(comments.comment_id) AS comments_count
            FROM bulletin_files
            LEFT JOIN comments ON bulletin_files.id = comments.post_id
            WHERE bulletin_files.is_archived = 0
            GROUP BY bulletin_files.id";

    $stmt = $pdo->query($sql);
    $postsWithComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <style>

html, body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
        }

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

        .main-content {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        #postChart {
            margin-top: 20px;
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
            display: none; /* Initially hide the dropdown content */
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

        /* Show the dropdown content on hover */
        .dropdown:hover .dropdown-content {
            display: block;
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



    <div class="main-content">
        <h2>Post Interaction Statistics</h2>
        <div>
            <canvas id="postChart" width="600" height="400"></canvas>
        </div>
    </div>

    <script>

        function redirectToUploadPage() {
            window.location.href = "upload.html";
        }

        function redirectToAdminBulletin() {
    window.location.href = "superadmin_bulletin.php";
        }

            // Convert PHP array to JavaScript array
        const postsWithComments = <?php echo json_encode($postsWithComments); ?>;
// Extract post titles and comments counts
const postTitles = postsWithComments.map(post => {
    const maxLength = 20; // Set the maximum length for the titles
    if (post.title.length > maxLength) {
        return post.title.substring(0, maxLength) + '...'; // Truncate and add ellipsis
    } else {
        return post.title;
    }
});
const commentsCounts = postsWithComments.map(post => post.comments_count);

// Render chart using Chart.js
const ctx = document.getElementById("postChart").getContext("2d");
const myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: postTitles,
        datasets: [{
            label: "Number of Comments",
            data: commentsCounts,
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

    </script>

<script>
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

    // Function to handle window resize events
    function handleResize() {
        closeSideNavbarOnLargeScreen(); // Close side navbar if needed
        resizeChart(); // Resize chart if needed
    }

    // Function to resize the chart
    function resizeChart() {
        var canvas = document.getElementById("postChart");
        var container = canvas.parentNode;

        // Set the canvas width to the container width
        canvas.width = container.offsetWidth;

        // Redraw the chart
        myChart.resize();
    }

    // Call the function when the window loads and when it is resized
    window.onload = handleResize;
    window.onresize = handleResize;
</script>

</body>
</html>
