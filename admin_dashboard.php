<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            background-color: #e4f2f2; /* Set background color */
        }
        .navbar {
            background-color: #e4f2f2; /* Set navbar background color */
            color: maroon;
            padding: 15px 40px; /* Adjust padding to increase width */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
        }
        .navbar a {
            color: maroon;
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

        /* Rectangle shape with rounded corners and white background */
        .rectangle {
            width: 20%; /* Decreased width */
            max-width: 1000px; /* Adjusted maximum width */
            height: 350px; /* Added height */
            margin: auto; /* Center the rectangle horizontally */
            padding: 20px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0px 15px 15px rgba(0, 0, 0, 0.1); /* Add shadow */
            position: fixed; /* Position the rectangle */
            top: 50%; /* Position it vertically at 50% from the top */
            transform: translateY(-50%); /* Center it vertically */
            left: 27px; /* Position it 20px from the left side */
            margin-bottom: 20px;
            text-align: center; /* Center align text */
            margin-top: 20px;
        }

        .username {
            color: maroon; /* Set username color to maroon */
        }

        .user-role {
            padding-bottom: 20px; /* Add some padding below user role */
        }

        .horizontal-line {
            border-bottom: 1px solid #ccc; /* Add gray horizontal line */
            margin-top: 30px; /* Add some space between user role and line */
            margin-bottom: 10px; /* Add some space between line and bottom */
            width: 50%; /* Set the width of the horizontal line */
            width: 50%; /* Set the width of the horizontal line */
            margin: 10px auto; /* Center the line horizontally and add some margin */
        }
        .account-details {
            text-align: left; /* Left-align the text */
            margin-left: 43px;
            font-size: 15px;
        }

        .account-details p {
            margin: 5px 0; /* Add some spacing between paragraphs */
        }
        .button {
            background-color: maroon;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 40px auto 0; /* Center the button horizontally */
        }

        .content {
            width: 900px;
            height: 490px;
            background-color: #f1f8f8;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: auto; /* Align the rectangle to the center-right */
            margin-right: 40px; /* Ensure no margin on the right */
            margin-top: 30px; /* Add margin from the top */
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

    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="admin_dashboard.php" class="logo">TUPM-COS EBBS</a>
        </div>
        <div>
            <a href="admin_archive.php">Archive</a>
            <a href="admin_feedback.php">Feedback</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

<div class="rectangle">
            <?php
            // Fetch user information from the database
            $db = new mysqli("localhost", "root", "", "ebulletin_system");
            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }
            
            $sql_user = "SELECT users.username, users.email, roles.RoleName 
                        FROM users 
                        INNER JOIN roles ON users.RoleID = roles.RoleID 
                        WHERE users.RoleID = '1'"; // Adjust the query to fit your database schema and conditions
            
            $result_user = $db->query($sql_user);

            if ($result_user->num_rows > 0) {
                $userData = $result_user->fetch_assoc();
                $username = $userData['username'];
                $email = $userData['email'];
                $userRole = $userData['RoleName'];

                echo "<h2 class='username' style='color: maroon;'>$username</h2>";
                echo "<p class='user-role'>$userRole</p>";
                echo "<div class='horizontal-line'></div>"; // Add horizontal line
                echo "<h2 style='color: maroon;'>Account details:</h2>"; // Add Account details heading with color maroon
                echo "<div class='account-details'>"; // Open container for account details
                echo "<p><strong>Username:</strong> $username</p>"; // Display username
                echo "<p><strong>Email:</strong> $email</p>"; // Display email
                echo "</div>"; // Close container for account details
            } else {
                echo "User not found";
            }

            $db->close();
            ?>
         <button class="button" onclick="redirectToAdminBulletin()">Show Announcements</button>
</div>
<div class="content">
      <!-- Photo container with plus icon -->
        <div class="photo-container">
            <img src="plus_icon1.png" alt="Plus Icon" class="plus-icon" onclick="openUploadForm()">
        </div>


          <!-- Upload file pop-up form -->
        <div id="uploadForm" class="upload-form">
            <span class="close" onclick="closeUploadForm()">&times;</span>
            <div class="form-content">
                <h2>Upload File</h2>
                <form action="upload_process.php" method="post" enctype="multipart/form-data">
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

            <!-- Fetch uploaded files from the bulletin_files table -->
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
                if ($row["filetype"] == "photo") {
                    echo '<div class="photo-container">';
                    echo '<a href="uploads/' . $row["filename"] . '" download>';
                    echo '<img class="file-photo" src="uploads/' . $row["filename"] . '" alt="' . $row["title"] . '">';
                    echo '</a>';
                    echo '<i class="fas fa-trash delete-icon" onclick="archiveFile(' . $row["id"] . ')"></i>';
                    echo '<img src="edit.png" alt="Edit Icon" class="edit-icon">';
                    echo '</div>';
                } elseif ($row["filetype"] == "video") {
                    echo '<div class="video-container">';
                    echo '<video class="file-video" controls>';
                    echo '<source src="uploads/' . $row["filename"] . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                    echo '<i class="fas fa-trash delete-icon" onclick="archiveFile(' . $row["id"] . ')"></i>';
                    echo '<img src="edit.png" alt="Edit Icon" class="edit-icon">';
                    echo '</div>';
                }
                
            }

            $db->close();
            ?>

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

    // Function to redirect to admin bulletin page
    function redirectToAdminBulletin() {
        window.location.href = "admin_bulletin.php";
    }

    // Function to archive file
    function archiveFile(id) {
        if (confirm("Are you sure you want to archive this file?")) 
        {
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
            xhr.open("GET", "archive_file.php?id=" + id, true);
            xhr.send();
        }
}
</script>
</body>
</html>
