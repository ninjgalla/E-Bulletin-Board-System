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
        .photo-container {
            position: relative;
            width: 150px; /* Set the width of the photo container */
            height: 150px; /* Set the height of the photo container */
            margin: 10px; /* Add margin around each photo container */
            overflow: hidden; /* Hide any overflow */
            border-radius: 10px; /* Add rounded corners */
            display: inline-block; /* Display photos in a row */
            margin-top: 50px;
        }

        .file-photo {
            width: 100%; /* Make the photo fill the container */
            height: 100%; /* Make the photo fill the container */
            object-fit: cover; /* Cover the entire container */
        }

        .delete-icon {
            position: absolute;
            top: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
            visibility: hidden; /* Hide the icons by default */
        }

        .edit-icon {
            position: absolute;
            top: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
            width: 15px;
            height: 15px;
            display: block; /* Display as block-level element */
            margin-top: 30px;
            margin-left: 20px;
            visibility: hidden; /* Hide the icons by default */
        }
        .photo-container:hover .delete-icon,
.photo-container:hover .edit-icon {
    visibility: visible; /* Display icons when photo-container is hovered */
}

        /* Image containers for videos */
        .video-container {
            position: relative;
            width: 150px; /* Set the width of the video container */
            height: 150px; /* Set the height of the video container */
            margin: 10px; /* Add margin around each video container */
            overflow: hidden; /* Hide any overflow */
            border-radius: 10px; /* Add rounded corners */
            display: inline-block; /* Display videos in a row */
        }

        .file-video {
            width: 100%; /* Make the video fill the container */
            height: 100%; /* Make the video fill the container */
            object-fit: cover; /* Cover the entire container */
        }

        .plus-icon {
            width: 50%; /* Make the plus icon fill the container */
            height: 50%; /* Make the plus icon fill the container */
            margin-top: 40px;
            margin-left: 50px;
            cursor: pointer; /* Add cursor pointer */
        }

        .upload-form {
            display: none;
            position: fixed;
            z-index: 1;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 60%; /* Reduced width */
            max-width: 400px;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            margin-right: 10px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        /* Upload form content */
        .form-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center align the content */
        }

        /* Form input fields */
        input[type="file"],
        input[type="text"],
        textarea {
            margin-bottom: 15px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Form submit button */
        input[type="submit"] {
            background-color: maroon; /* Change the background color to maroon */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block; /* Ensure the button takes up only necessary space */
        }

        input[type="submit"]:hover {
            background-color: #800000; /* Darken the maroon color on hover */
        }

        /* CSS for schedule input field */
        input[type="datetime-local"] {
            margin-bottom: 15px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* CSS styles for pop-up and form */
        .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            max-width: 400px;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .popup .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            margin-right: 10px;
        }
        .popup .close:hover,
        .popup .close:focus {
            color: black;
            text-decoration: none;
        }
        .popup .form-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 10px;
        }
        .popup input[type="text"] {
            margin-bottom: 15px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .popup input[type="submit"] {
            background-color: maroon;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block;
        }
        .popup input[type="submit"]:hover {
            background-color: #800000;
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

        
/* CSS for the "Archive Selected Files" button */
.archive-button {
    background-color: maroon;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    position: absolute;
    top: 20px; /* Adjust from the top */
    right: 20px; /* Adjust from the right */
}


.archive-button:hover {
    background-color: gray; 
}

    </style>
</head>
<body>
<div class="navbar">
    <div>
        <a href="admin_dashboard.php" class="logo">TUPM-COS EBBS</a>
    </div>
    <div>
        <!-- Dropdown menu for Bulletin Feed -->
        <div class="dropdown" onmouseover="showDropdown()" onmouseout="hideDropdown()">
            <button class="dropbtn">Bulletin</button>
            <div class="dropdown-content" id="bulletinDropdown">
                <a href="admin_bulletin.php">Bulletin Board</a>
                <a href="admin_bulletin_feed.php">Bulletin Feed</a>
            </div>
        </div>
        <!-- End of Dropdown menu -->
        <a href="admin_upload.php">Upload</a>
        <a href="admin_archive.php">Archive</a>
        <a href="admin_profile_settings.php">Profile</a>
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
        <a href="admin_bulletin_feed.php">Bulletin Feed</a>
        <a href="admin_bulletin.php">Bulletin Board</a>
        <a href="admin_upload.php">Upload</a>
        <a href="admin_archive.php">Archive</a>
        <a href="admin_profile_settings.php">Profile</a>
        <a href="logout.php">Logout</a>
</div>


<div class="content">
    <!-- Archive selected files button container -->
    <div id="archiveButtonContainer" style="display: none;">
        <!-- Archive selected files button -->
        <button class="archive-button" onclick="archiveSelectedFiles()">Archive Selected Files</button>
    </div>
    <!-- Photo container with plus icon -->
    <div class="photo-container">
        <img src="plus_icon1.png" alt="Plus Icon" class="plus-icon" onclick="openUploadForm()">
    </div>
    
    <!-- Upload file pop-up form -->
    <div id="uploadForm" class="upload-form">
        <span class="close" onclick="closeUploadForm()">&times;</span>
        <div class="form-content">
            <h2>Upload File</h2>
            <form action="admin_upload_process.php" method="post" enctype="multipart/form-data">
                <label for="fileToUpload">Select File:</label>
                <input type="file" name="fileToUpload" id="fileToUpload" required><br>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required><br>
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="4" required></textarea><br>
                <label for="schedule">Schedule:</label>
                <input type="datetime-local" name="schedule" id="schedule" required><br> <!-- Added scheduling input -->
                <input type="submit" value="Upload" name="submit">
            </form>
        </div>
    </div>

    <?php
    // Fetch uploaded files from the database
    $db = new mysqli("localhost", "root", "", "ebulletin_system");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $sql = "SELECT * FROM bulletin_files WHERE is_archived = 0 ORDER BY upload_time DESC"; // Modify the query to fetch only non-archived files
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
            echo '<input type="checkbox" name="fileCheckbox[]" value="' . $row["id"] . '" class="file-checkbox" style="position: absolute; top: 10px; left: 10px;">';
            echo '<img src="uploads/' . $row["filename"] . '" class="file-photo">';
            echo '<span class="delete-icon" onclick="archiveFile(' . $row["id"] . ')"><i class="fas fa-trash-alt"></i></span>';
            echo '<span class="edit-icon" onclick=\'openEditForm(' . $row["id"] . ', ' . $title . ', ' . $description . ', ' . $filename . ', ' . $schedule . ')\'><i class="fas fa-edit"></i></span>';
            echo '</div>';
        } elseif ($row["filetype"] == "video") {
            echo '<div class="video-container">';
            echo '<input type="checkbox" name="fileCheckbox[]" value="' . $row["id"] . '" class="file-checkbox">';
            echo '<video src="uploads/' . $row["filename"] . '" class="file-video" controls></video>';
            echo '<span class="delete-icon" onclick="archiveFile(' . $row["id"] . ')"><i class="fas fa-trash-alt"></i></span>';
            echo '<span class="edit-icon" onclick=\'openEditForm(' . $row["id"] . ', ' . $title . ', ' . $description . ', ' . $filename . ', ' . $schedule . ')\'><i class="fas fa-edit"></i></span>';
            echo '</div>';
        }
    }
    ?>
</div>

 
<!-- Edit pop-up form -->
<div id="editForm" class="popup">
    <span class="close" onclick="closeEditForm()">&times;</span>
    <div class="form-content">
        <h2>Edit File</h2>
        <form action="admin_edit_process.php" method="post" enctype="multipart/form-data">
            <!-- File upload input -->
            <label for="editFile">Upload File:</label>
            <div class="file-input-container">
                <input type="file" name="editFile" id="editFile" onchange="updateFileName(this)">
            </div><br>
            <!-- Field for displaying uploaded file name -->
            <label for="fileUploaded">File Uploaded:</label>
            <input type="text" id="fileUploaded" value="No file chosen" readonly><br>
            <!-- Existing code for other input fields -->
            <label for="editTitle">Title:</label>
            <input type="text" name="editTitle" id="editTitle" value="<?php echo $currentTitle; ?>" required><br>
            <label for="editDescription">Description:</label>
            <textarea name="editDescription" id="editDescription" rows="4" required><?php echo $currentDescription; ?></textarea><br>
            <label for="editSchedule">Schedule:</label>
            <input type="datetime-local" name="editSchedule" id="editSchedule" value="<?php echo $currentSchedule; ?>" required><br>
            <input type="hidden" name="editId" id="editId" value="<?php echo $postId; ?>"> <!-- Hidden field to store post ID -->
            <input type="submit" value="Save Changes" name="submit">
        </form>
    </div>
</div>



<script>
    // Function to open the upload form
    function openUploadForm() {
        document.getElementById("uploadForm").style.display = "block";
    }

    // Function to close the upload form
    function closeUploadForm() {
        document.getElementById("uploadForm").style.display = "none";
    }

    // Function to archive file
    function archiveFile(id) {
        if (confirm("Are you sure you want to archive this file?")) {
            // Send an AJAX request to archive the file
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Reload the page after successful archiving
                        alert("File archived successfully.");
                        location.reload();
                    } else {
                        // Handle errors
                        alert("Error archiving file: " + xhr.statusText);
                    }
                }
            };
            xhr.open("GET", "admin_archive_file.php?id=" + id, true);
            xhr.send();
        }
    }

    // Function to open edit form popup
    function openEditForm(id, title, description, fileName, schedule) {
        console.log("Opening edit form for file:", id, title, description, fileName, schedule);
        document.getElementById("editId").value = id; // Set file ID
        document.getElementById("editTitle").value = title; // Set current title
        document.getElementById("editDescription").value = description; // Set current description
        document.getElementById("fileUploaded").value = fileName; // Set current file name
        document.getElementById("editSchedule").value = schedule; // Set current schedule
        document.getElementById("editForm").style.display = "block"; // Display edit form
    }

    // Function to close edit form popup
    function closeEditForm() {
        document.getElementById("editForm").style.display = "none"; // Hide edit form
    }

    // Function to update the file name label
    function updateFileName(input) {
        var fileName = input.files[0].name; // Get the file name
        var label = document.getElementById("selectedFileName"); // Get the label element
        label.textContent = fileName; // Update the label text
    }

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

// Function to archive selected files
function archiveSelectedFiles() {
    var checkboxes = document.querySelectorAll('.file-checkbox:checked');
    var fileIds = [];
    checkboxes.forEach(function(checkbox) {
        fileIds.push(checkbox.value);
    });

    // Confirm archive action with user
    var confirmation = confirm("Are you sure you want to archive the selected files?");
    if (confirmation) {
        // If user confirms, proceed with archiving
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Refresh page or update UI as needed
                    location.reload(); // For example, refresh page
                } else {
                    // Handle error
                    console.error('Archive request failed');
                }
            }
        };
        xhr.open('POST', 'admin_bulk_archive.php'); // Change the URL to admin_bulk_archive.php
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({ fileIds: fileIds }));
    } else {
        // If user cancels, do nothing
        return;
    }
}
// Add event listener to the checkbox
document.addEventListener('DOMContentLoaded', function() {
    var checkboxes = document.querySelectorAll('.file-checkbox');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Get reference to the archive button container
            var archiveButtonContainer = document.getElementById('archiveButtonContainer');

            // If checkbox is checked and at least one checkbox is checked, show the archive button; otherwise, hide it
            if (this.checked && document.querySelectorAll('.file-checkbox:checked').length > 0) {
                archiveButtonContainer.style.display = 'block';
            } else {
                archiveButtonContainer.style.display = 'none';
            }
        });
    });
});



</script>
</body>
</html>
