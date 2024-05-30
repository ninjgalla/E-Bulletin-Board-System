<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
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
    text-shadow: black;
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
    background-color: white;
}

.navbar .logo {
    font-weight: bold; /* Added bold font weight */
    margin-left: -10px; /* Adjusted left margin */
    font-size: 20px; /* Increased font size */
}

.content {
    width: calc(100% - 80px); /* Adjusted width to fill the screen with 40px margin on each side */
    max-width: 1200px; /* Set maximum width to maintain readability */
    height: calc(100vh - 80px); /* Adjusted height to fill the vertical space with 40px margin on top and bottom */
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 40px auto; /* Center the content horizontally and provide 40px margin on top and bottom */
    padding: 20px; /* Add padding for inner content */
    overflow: auto; /* Add overflow to enable scrolling if content exceeds screen size */
    position: relative;
}

/* Image containers for photos */
.photo-container,
.video-container {
    position: relative;
    width: 150px; /* Set the width of the container */
    height: auto; /* Allow the height to adjust based on content */
    margin: 10px; /* Add margin around each container */
    overflow: hidden; /* Hide any overflow */
    border-radius: 10px; /* Add rounded corners */
    display: inline-block; /* Display containers in a row */
    margin-top: 50px; /* Adjust the top margin as needed */
    vertical-align: top; /* Align containers to the top */
}

.file-photo,
.file-video {
    width: 100%; /* Make the photo or video fill the container */
    height: 150px; /* Set height to leave space for buttons */
    object-fit: cover; /* Cover the entire container */
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

    .dropdown-content {
        display: none;
    }

    .dropbtn {
        display: none;
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

.approve-btn,
.reject-btn {
    display: inline-block;
    margin: 0 5px;
    padding: 5px 10px; /* Adjust padding for button size */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px; /* Adjust font size */
    background-color: #800000;
    color: white;
}

.approve-btn {
    background-color: #28a745; /* Green color */
    color: white;
}

.reject-btn {
    background-color: #dc3545; /* Red color */
    color: white;
}

.photo-container .approve-btn,
.video-container .approve-btn,
.photo-container .reject-btn,
.video-container .reject-btn {
    position: absolute;
    bottom: 5px; /* Adjust the distance from the bottom */
    z-index: 1;
    color: white;
    cursor: pointer;
    padding: 5px 10px; /* Adjust padding for button size */
    font-size: 12px; /* Adjust font size */
}

.photo-container .approve-btn,
.video-container .approve-btn {
    left: 5px; /* Adjust the distance from the left */
}

.photo-container .reject-btn,
.video-container .reject-btn {
    left: calc(5px + 10px + 60px); /* Adjust the distance from the left */
}

.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 60px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.post-title {
    font-weight: bold;
    text-transform: uppercase;
    color: maroon;
    cursor: pointer;
    text-align: center;
    margin-top: 10px; /* Adjust margin as needed */
}

.post-title:hover {
    text-decoration: underline;
}
.indent {
    margin-left: 20px; /* Adjust indentation as needed */
}

h2{
    color: maroon;
    text-align: center;
}

</style>
</head>
<body>
<div class="navbar">
    <div>
        <a href="superadmin_dashboard.php" class="logo">TUPM-COS EBBS</a>
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
                <a href="superadmin_approved_post.php">Approved</a>
                <a href="superadmin_for_approval.php">For Approval</a>
                <a href="superadmin_rejected.php">Rejected</a>
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
        <a href="superadmin_approved_post.php">Approved</a>
        <a href="superadmin_for_approval.php">For Approval</a>
        <a href="superadmin_rejected.php">Rejected</a>
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



<div class="content">
    <h2>For Approval</h2>
    <?php
    // Fetch uploaded files from the database
    $db = new mysqli("localhost", "root", "", "ebulletin_system");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $sql = "SELECT * FROM bulletin_files WHERE is_archived = 0 AND status != 'approved' AND status != 'rejected' ORDER BY upload_time DESC";


    $result = $db->query($sql);

    // Display uploaded files
    while ($row = $result->fetch_assoc()) {
        $currentSchedule = isset($row["schedule"]) ? date('Y-m-d\TH:i', strtotime($row["schedule"])) : "";
    
        // Escape special characters in title and description
        $title = htmlspecialchars(json_encode($row["title"]), ENT_QUOTES);
        $description = htmlspecialchars(json_encode($row["description"]), ENT_QUOTES);
        $filename = htmlspecialchars(json_encode($row["filename"]), ENT_QUOTES);
        $schedule = htmlspecialchars(json_encode($currentSchedule), ENT_QUOTES);
    
        if ($row["filetype"] == "photo") {
            echo '<div class="photo-container">';
            echo '<img src="uploads/' . $row["filename"] . '" class="file-photo">';
            echo '<div class="post-title" onclick="openModal(' . $title . ', ' . $description . ', ' . $schedule . ', ' . $row["id"] . ')">' . htmlspecialchars($row["title"]) . '</div>';
            echo '</div>';
        } elseif ($row["filetype"] == "video") {
            echo '<div class="video-container">';
            echo '<video src="uploads/' . $row["filename"] . '" class="file-video" controls></video>';
            echo '<div class="post-title" onclick="openModal(' . $title . ', ' . $description . ', ' . $schedule . ', ' . $row["id"] . ')">' . htmlspecialchars($row["title"]) . '</div>';
            echo '</div>';
        }
    }
    ?>
</div>

<!-- Modal -->
<div id="postModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2 id="modalTitle"></h2>
    <p id="modalDescription"></p>
    <p><strong>Schedule:</strong> <span id="modalSchedule"></span></p>
    <label for="modalRemarks">Remarks:</label>
    <textarea id="modalRemarks" rows="4" cols="50"></textarea>
    <br><br>
    <button class="approve-btn" id="modalApproveBtn">Approve</button>
    <button class="reject-btn" id="modalRejectBtn">Reject</button>
  </div>
</div>

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

    function showDropdown() {
        // Code to show the dropdown content
        document.getElementById("bulletinDropdown").style.display = "block";
    }

    function hideDropdown() {
        // Code to hide the dropdown content
        document.getElementById("bulletinDropdown").style.display = "none";
    }

    // Call the function when the window loads and when it is resized
    window.onload = closeSideNavbarOnLargeScreen;
    window.onresize = closeSideNavbarOnLargeScreen;

    // Function to approve a post
    function approvePost(id) {
        var remarks = document.getElementById("modalRemarks").value; // Get remarks from textarea
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert('Post ' + id + ' approved');
                location.reload();
            }
        };
        xhttp.open("POST", "approve_post.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + id + "&action=approve&remarks=" + encodeURIComponent(remarks)); // Include remarks in the request
    }

    // Function to reject a post
    function rejectPost(id) {
        var remarks = document.getElementById("modalRemarks").value; // Get remarks from textarea
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert('Post ' + id + ' rejected');
                location.reload();
            }
        };
        xhttp.open("POST", "reject_post.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + id + "&action=reject&remarks=" + encodeURIComponent(remarks)); // Include remarks in the request
    }


    // Function to open the modal
    function openModal(title, description, schedule, id) {
        document.getElementById("modalTitle").textContent = title;
        document.getElementById("modalDescription").textContent = description;
        document.getElementById("modalSchedule").textContent = schedule;
        document.getElementById("modalApproveBtn").onclick = function() {
            approvePost(id);
        };
        document.getElementById("modalRejectBtn").onclick = function() {
            rejectPost(id);
        };
        document.getElementById("postModal").style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("postModal").style.display = "none";
    }
</script>
</body>
</html>
