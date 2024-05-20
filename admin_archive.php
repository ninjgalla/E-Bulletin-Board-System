<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive</title>
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

        .file-item img,
        .file-item video {
            width: 300px; /* Set width to 100% */
            height: auto; /* Let the height adjust proportionally */
            border-radius: 8px; /* Add border radius */
        }

        .file-info {
            float: left;
            width: 300px; /* Adjust width as needed */
            padding-right: 20px; /* Add some spacing */
            text-align: center; /* Center-align text */
            position: fixed; /* Fix position */
           
        }

        .file-info h4 {
            text-transform: uppercase; /* Convert text to uppercase */
            color: maroon;
            text-align: center;
        }

        .file-container {
            margin-top: 50px;
            display: flex;
            flex-wrap: wrap; /* Allow items to wrap to the next line if there isn't enough space */
            justify-content: center; /* Center align items horizontally */
        }

        .file-item {
            margin: 10px; /* Add margin between items */
        }
        
         /* Add styles for the menu icon container */
.menu-icon-container {
    position: relative;
    display: inline-block;
}

/* Add styles for the menu icon */
.menu-icon {
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
    margin: 15px;
}

.menu-icon::before,
.menu-icon::after,
.menu-icon div {
    content: "";
    position: absolute;
    width: 4px;
    height: 4px;
    background-color: maroon;
    border-radius: 50%;
    transition: all 0.3s ease;
}

/* Adjust spacing between dots */
.menu-icon::before {
    top: -7px;
    margin-right: 5px; /* Decreased spacing between dots */
}

.menu-icon::after {
    bottom: -7px;
    margin-right: 5px; /* Decreased spacing between dots */
}

.menu-icon div {
    top: 50%;
    transform: translateY(-50%);
}

  /* Add styles for popup menu */
   .popup-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            z-index: 1;
            top: 0; /* Position relative to the container */
            right: 30px; /* Adjust the distance from the right */
        }

        .popup-menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .popup-menu ul li {
            padding: 5px 0;
        }

        .popup-menu ul li a {
            color: #333;
            text-decoration: none;
            display: block;
        }

        .popup-menu ul li a:hover {
            background-color: #f2f2f2;
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
</div>

 
    <div class="file-container">
    <?php
    // Include database connection
    include('config.php');

    // Fetch archived files from the database
    $sql = "SELECT * FROM bulletin_files WHERE is_archived = 1 ORDER BY upload_time DESC";
    $result = $conn->query($sql);

    // Display archived files
    while ($row = $result->fetch_assoc()) {
        // Display each archived file
        echo '<div class="file-item">';
        echo '<div class="menu-icon-container">'; // Start menu icon container
        if ($row["filetype"] == "photo") {
            echo '<img src="uploads/' . $row["filename"] . '" alt="' . $row["title"] . '">';
        } elseif ($row["filetype"] == "video") {
            echo '<video controls>';
            echo '<source src="uploads/' . $row["filename"] . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
        }
        // Add the menu icon
        echo '<div class="menu-icon" onclick="toggleMenu(this)"><div></div><div></div><div></div></div>';
        // Add the popup menu
        echo '<div class="popup-menu">';
        echo '<ul>';
        echo '<li><a href="#" onclick="permanentlyDelete(' . $row["id"] . ')">Permanently Delete</a></li>';
        echo '<li><a href="#" onclick="restore(' . $row["id"] . ')">Restore</a></li>';

        echo '</ul>';
        echo '</div>'; // Close popup menu
        echo '</div>'; // End menu icon container
        echo '<div class="file-info">';
        echo '<h4>' . $row["title"] . '</h4>';
        echo '</div>'; // Close file-info
        echo '</div>'; // Close file-item
    }

    // Close the database connection
    $conn->close();
    ?>
    </div>



    <script>

function redirectToUploadPage() {
    window.location.href = "admin_upload.php";
}

function redirectToAdminBulletin() {
    window.location.href = "admin_bulletin.php";
}

function toggleMenu(menu) {
    var popupMenu = menu.parentElement.querySelector('.popup-menu');
    popupMenu.style.display = popupMenu.style.display === 'block' ? 'none' : 'block';
}

// Function to permanently delete file
function permanentlyDelete(id) {
    if (confirm("Are you sure you want to permanently delete this file?")) {
        // Send an AJAX request to permanently delete the file
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Reload the page after successful deletion
                    alert("File permanently deleted.");
                    location.reload();
                } else {
                    // Handle errors
                    alert("Error deleting file: " + xhr.statusText);
                }
            }
        };
        xhr.open("GET", "admin_permanently_delete.php?id=" + id, true);
        xhr.send();
    }
}

function restore(id) {
    if (confirm("Are you sure you want to restore this file?")) {
        // Send an AJAX request to restore the file
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Reload the page after successful restoration
                    alert(xhr.responseText);
                    location.reload();
                } else {
                    // Handle errors
                    alert("Error restoring file: " + xhr.statusText);
                }
            }
        };
        xhr.open("GET", "admin_restore_file.php?id=" + id, true);
        xhr.send();
    }
}




</script>



</body>
</html>
