<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            background-color: #f5f5f5;
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


        .hamburger {
            display: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        .side-navbar {
            position: fixed;
            top: 0;
            right: -250px;
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
        }

        .side-navbar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }

        .side-navbar a:hover {
            background-color: #575757;
        }

        @media (max-width: 768px) {
            .navbar a {
                display: none;
            }
            .navbar .logo {
                display: block;
            }
            .hamburger {
                display: block;
            }
        }

        .archive-container {
            width: calc(100% - 80px);
            max-width: 1200px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
            padding: 20px;
            overflow: auto;
            display: flex;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .sorting-buttons {
            position: absolute;
            top: 20px; /* Adjust the top position as needed */
            left: 20px; /* Adjust the left position as needed */
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            z-index: 999; /* Ensure the buttons are above other content */
        }

        .sorting-buttons button {
            background-color: #800000;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 5px 0;
            cursor: pointer;
            border-radius: 5px;
            font-size: 12px;
            height: 30px;
            line-height: 20px;
        }

        .sorting-buttons button:hover {
            background-color: #575757;
        }

        .photo-container,
        .video-container {
            position: relative;
                    width: 150px; /* Set the width of the photo container */
                    height: 150px; /* Set the height of the photo container */
                    margin: 10px; /* Add margin around each photo container */
                    overflow: hidden; /* Hide any overflow */
                    border-radius: 10px; /* Add rounded corners */
                    display: inline-block; /* Display photos in a row */
                    margin-top: 50px;
        }

        .file-photo,
        .file-video {
            width: 100%; /* Make the photo fill the container */
                    height: 100%; /* Make the photo fill the container */
                    object-fit: cover; /* Cover the entire container */
        }

        .files-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .file-options {
                    position: absolute;
                    top: 5px;
                    right: 5px;
                    z-index: 1;
                    background-color: rgba(255, 255, 255, 0.8);
                    border-radius: 5px;
                    display: none;
                }

                .file-menu {
                    display: none;
                    position: absolute;
                    top: 30px;
                    right: 0;
                    background-color: #fff;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    z-index: 2;
                }

                .file-menu.show {
                    display: block;
                }

                .file-menu button {
                    display: block;
                    width: 100%;
                    padding: 5px 10px;
                    text-align: left;
                    border: none;
                    background: none;
                    cursor: pointer;
                }

                .file-menu button:hover {
                    background-color: #f2f2f2;
                }

        .photo-container:hover .file-options {
            display: block;
        }
        .video-container:hover .file-options {
            display: block;
        }
        .file-container {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 20px; /* Adjust the top position as needed */
            left: 20px; /* Adjust the left position as needed */
            z-index: 1000; /* Ensure the dropdown is above other content */
        }

        /* Dropdown button */
        .dropbtn {
            background-color: #800000;
            color: white;
            padding: 5px 15px;
            font-size: 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .dropbtn-a {
            background-color: #800000;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
}

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown menu on hover */
        .dropdown-menu:hover .dropdown-content {
            display: block;
        }

        .file-item p {
                color: maroon; /* Set font color to maroon */
                text-transform: uppercase; /* Capitalize all letters */
                font-weight: bold;
            }

            .action-buttons {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.action-buttons button {
    background-color: #800000;
    color: white;
    border: none;
    padding: 10px 10px; /* Reduced padding for smaller size */
    margin: 10px 5px; /* Added space between buttons and ensured enough top and bottom margin */
    cursor: pointer;
    border-radius: 5px;
    font-size: 12px; /* Reduced font size */
    width: 140px; /* Set a fixed width to ensure same size */
    height: 40px; /* Increased height for better readability */
}

.action-buttons button:hover {
    background-color: #575757;
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
            .dropbtn-a {
                display: none;
            }
        }

        .select-all {
    position: absolute;
    top: 60px; /* Adjust as needed */
    left: 20px; /* Adjust as needed */
}

    /* Style for the checkbox */
    .select-all input[type="checkbox"] {
        display: none;
    }

    /* Style for the button label */
    .select-all label {
    background-color: #800000;
    color: white;
    border: none;
    padding: 5px 13px;
    margin: 5px 0;
    cursor: pointer;
    border-radius: 5px;
    font-size: 12px;
    display: inline-block;
}

    /* Hover effect */
    .select-all label:hover {
        background-color: #575757;
        .indent {
    margin-left: 20px; /* Adjust indentation as needed */
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
            <button class="dropbtn-a">Bulletin</button>
            <div class="dropdown-content" id="bulletinDropdown">
                <a href="superadmin_bulletin.php">Bulletin Board</a>
                <a href="superadmin_bulletin_feed.php">Bulletin Feed</a>
            </div>
        </div>
        <!-- End of Dropdown menu -->
        <!-- Dropdown menu for Posts -->
        <div class="dropdown" onmouseover="showPostsDropdown()" onmouseout="hidePostsDropdown()">
            <button class="dropbtn-a">Posts</button>
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

<div class="file-container">
    <div class="archive-container">
        <div class="dropdown-menu">
            <button class="dropbtn">Sort</button>
            <div class="dropdown-content">
                <a href="#" onclick="sortFiles('date')">Sort by Date</a>
                <a href="#" onclick="sortFiles('alphabetical')">Sort Alphabetically</a>
            </div>
        </div>

<!-- "Select All" checkbox -->
<div class="select-all">
    <input type="checkbox" id="selectAllCheckbox" onchange="toggleAllCheckboxes(this)">
    <label for="selectAllCheckbox">Select All</label>
</div>



        <form id="fileForm">
            <div class="files-wrapper">

                <?php
function truncate_title($title, $max_length) {
    // Check if title length is within max_length
    if (strlen($title) <= $max_length) {
        return $title;
    }

    // Truncate title and add ellipsis
    return substr($title, 0, $max_length - 3) . '...';
}

include('config.php');

$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'date';

if ($sortOrder == 'alphabetical') {
    $sql = "SELECT * FROM bulletin_files WHERE is_archived = 1 ORDER BY title ASC";
} else {
    $sql = "SELECT * FROM bulletin_files WHERE is_archived = 1 ORDER BY upload_time DESC";
}

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo '<div class="file-item">';

    if ($row["filetype"] == "photo") {
        echo '<div class="photo-container">';
        echo '<input type="checkbox" name="fileIds[]" value="' . $row["id"] . '" class="file-checkbox" style="position: absolute; top: 10px; left: 10px;">';
        echo '<img src="uploads/' . $row["filename"] . '" class="file-photo">';
        // Truncate the title
        echo '<h4>' . truncate_title($row["title"], 50) . '</h4>';
        // Add menu icon and options
        echo '<div class="file-options">';
        echo '<i class="fas fa-ellipsis-v file-menu-icon" onclick="toggleFileMenu(event)"></i>'; // Menu icon
        echo '<div class="file-menu">';
        echo '<button type="button" onclick="permanentlyDelete(' . $row["id"] . ')">Permanently Delete</button>';
        echo '<button type="button" onclick="restore(' . $row["id"] . ')">Restore</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>'; // Close photo-container
        // Add title below the file
        echo '<p>' . truncate_title($row["title"], 20) . '</p>';
    } elseif ($row["filetype"] == "video") {
        echo '<div class="video-container">';
        echo '<input type="checkbox" name="fileCheckbox[]" value="' . $row["id"] . '" class="file-checkbox" style="position: in line; top: 10px; left: 10px;">';
        echo '<video src="uploads/' . $row["filename"] . '" class="file-video" controls></video>'; // Video element
        // Truncate the title
        echo '<h4>' . truncate_title($row["title"], 50) . '</h4>';
        // Add menu icon and options
        echo '<div class="file-options">';
        echo '<i class="fas fa-ellipsis-v file-menu-icon" onclick="toggleFileMenu(event)"></i>'; // Menu icon
        echo '<div class="file-menu">';
        echo '<button type="button" onclick="permanentlyDelete(' . $row["id"] . ')">Permanently Delete</button>';
        echo '<button type="button" onclick="restore(' . $row["id"] . ')">Restore</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>'; // Close video-container
        // Add title below the file
        echo '<p>' . truncate_title($row["title"], 20) . '</p>';
    }
    echo '</div>'; // Close file-item
    
}
?>

            </div>
        </form>

        <div class="action-buttons" id="actionButtons" style="display: none;">
            <button onclick="deleteSelected()">Permanently Delete Selected</button>
            <button onclick="restoreSelected()">Restore Selected</button>
        </div>

    </div>
</div>



<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    // Function to toggle file menu options
    function toggleFileMenu(event) {
        var fileOptions = event.target.closest('.file-options');
        var fileMenu = fileOptions.querySelector('.file-menu');
        if (fileMenu.style.display === 'block') {
            fileMenu.style.display = 'none';
        } else {
            var allFileMenus = document.querySelectorAll('.file-menu');
            allFileMenus.forEach(function(menu) {
                menu.style.display = 'none';
            });
            fileMenu.style.display = 'block';
        }
    }

    // Function to permanently delete file
    function permanentlyDelete(id) {
        if (confirm("Are you sure you want to permanently delete this file?")) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        alert("File permanently deleted.");
                        location.reload();
                    } else {
                        alert("Error deleting file: " + xhr.statusText);
                    }
                }
            };
            xhr.open("GET", "superadmin_permanently_delete.php?id=" + id, true);
            xhr.send();
        }
    }

    // Function to restore file
    function restore(id) {
        if (confirm("Are you sure you want to restore this file?")) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        alert(xhr.responseText);
                        location.reload();
                    } else {
                        alert("Error restoring file: " + xhr.statusText);
                    }
                }
            };
            xhr.open("GET", "superadmin_restore_file.php?id=" + id, true);
            xhr.send();
        }
    }

    // Function to sort files
    function sortFiles(order) {
        window.location.href = "superadmin_archive.php?sort=" + order;
    }

    // Function to toggle side navbar
    function toggleSideNavbar() {
        var sideNavbar = document.getElementById('sideNavbar');
        if (sideNavbar.style.right === '0px') {
            sideNavbar.style.right = '-250px'; 
        } else {
            sideNavbar.style.right = '0px'; 
        }
    }

    // Function to automatically close side navbar on larger screens
    function closeSideNavbarOnLargeScreen() {
        var sideNavbar = document.getElementById('sideNavbar');
        var screenWidth = window.innerWidth;
        if (screenWidth > 768) { 
            sideNavbar.style.right = '-250px'; 
        }
    }

// Function to delete selected files
function deleteSelected() {
    if (confirm("Are you sure you want to permanently delete the selected files?")) {
        var form = document.getElementById('fileForm');
        var formData = new FormData(form);
        formData.append('action', 'delete');

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    alert("Selected files permanently deleted.");
                    location.reload();
                } else {
                    alert("Error deleting files: " + xhr.statusText);
                }
            }
        };
        xhr.open("POST", "superadmin_bulk_delete.php", true);
        xhr.send(formData);
    }
}


    // Function to restore selected files
    function restoreSelected() {
        var form = document.getElementById('fileForm');
        var formData = new FormData(form);
        formData.append('action', 'restore');

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    alert("Selected files restored.");
                    location.reload();
                } else {
                    alert("Error restoring files: " + xhr.statusText);
                }
            }
        };
        xhr.open("POST", "superadmin_bulk_restore.php", true);
        xhr.send(formData);
    }

    // Function to toggle all checkboxes
    function toggleAllCheckboxes(checkbox) {
        var checkboxes = document.querySelectorAll('input[name="fileIds[]"]');
        checkboxes.forEach(function(cb) {
            cb.checked = checkbox.checked;
        });
        toggleActionButtons();
    }

    // Function to toggle action buttons based on checkbox status
    function toggleActionButtons() {
        var checkboxes = document.querySelectorAll('input[name="fileIds[]"]');
        var actionButtons = document.getElementById('actionButtons');
        var checked = false;
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checked = true;
            }
        });
        if (checked) {
            actionButtons.style.display = 'block';
        } else {
            actionButtons.style.display = 'none';
        }
    }

    // Attach event listeners when the window is fully loaded
    window.onload = function() {
        closeSideNavbarOnLargeScreen();

        document.addEventListener('change', function(event) {
            if (event.target.matches('input[name="fileIds[]"]')) {
                toggleActionButtons();
            }
        });
    };

     // Function to toggle all checkboxes
     function toggleAllCheckboxes(checkbox) {
        var checkboxes = document.querySelectorAll('input[name="fileIds[]"]');
        checkboxes.forEach(function(cb) {
            cb.checked = checkbox.checked;
        });
        toggleActionButtons();
    }
</script>

</body>
</html>
