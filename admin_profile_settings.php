<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Include database connection
require_once 'config.php';

// Fetch username from the session
$username = $_SESSION['username'];

// Placeholder for the profile picture
$profilePicture = '';

// Fetch user details from the database
$query = "SELECT UserID, username, first_name, last_name, email, TUP_id, profile_picture FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($userId, $username, $firstName, $lastName, $email, $tupId, $profilePicture);
    $stmt->fetch();
} else {
    // Handle the case where the user is not found
    $error_message = "User not found.";
}

// Close the statement
$stmt->close();

// Initialize variables to prevent undefined variable warnings
$success_message = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $tupId = $_POST['tupId'];

    // Handle profile picture upload
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["profilePicture"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
            // Save the file path to the database
            $profilePicture = $targetFilePath;
        } else {
            $error_message = "Error uploading the profile picture.";
        }
    } else {
        // If no new file is uploaded, retain the old profile picture
        $profilePicture = isset($_POST['existingProfilePicture']) ? $_POST['existingProfilePicture'] : '';
    }

    // Update user information in the database
    $update_query = "UPDATE users SET first_name=?, last_name=?, email=?, TUP_id=?, profile_picture=?, username=? WHERE UserID=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $firstName, $lastName, $email, $tupId, $profilePicture, $username, $userId);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        $success_message = "User information updated successfully.";
    } else {
        $error_message = "Error updating user information. Please try again later.";
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <title>Profile Settings</title>
        <style>
            /* Your existing CSS styles */
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 500px;
                margin: 60px auto 30px;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                
            }

            .navbar {
                background-color: #800000;
                color: maroon;
                padding: 15px 40px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1);
            }

            .navbar a {
                color: white;
                text-decoration: none;
                margin-right: 15px;
                position: relative;
                transition: font-weight 0s;
                font-weight: normal;
            }

            .navbar .logo {
                font-weight: bold;
                margin-left: 10px;
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

            .navbar .logo {
                font-weight: bold;
                margin-left: -10px;
                font-size: 20px;
            }

            .sidebar {
                height: calc(100vh - 60px);
                width: 250px;
                position: fixed;
                top: 60px;
                left: 0;
                background-color: white;
                padding-top: 0;
                box-shadow: 2px 0 rgba(0, 0, 0, 0.1);
                z-index: 999;
                margin-top: -7px;
            }

            .sidebar a {
                padding: 20px;
                text-decoration: none;
                display: block;
                color: maroon;
                transition: 0.3s;
                margin-bottom: 20px; /* Adjusted margin-bottom value */
                margin-left: 30px;
                font-size: larger;
                margin-top: 40px;
            }

            .sidebar a:hover {
                font-weight: bold;
            }

            h1 {
                text-align: center;
                margin-bottom: 30px;
                color: maroon;
            }

            form {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-gap: 20px;
                justify-items: center;
            }

            label {
                font-weight: bold;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            select {
                width: calc(100% - 10px);
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                margin-right: 100px;
            }

            input[type="submit"] {
                width: auto;
                padding: 10px 20px;
                background-color: maroon;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
                grid-column: span 2;
            }

            input[type="submit"]:hover {
                background-color: #800000;
            }

            .profile-picture {
                position: relative; /* Make the container relative for absolute positioning */
                text-align: center;
                margin-bottom: 20px;
                padding-top: 20px;
            }

            .profile-img {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 10px;
                border: 2px solid maroon;
            }

            input[type="file"] {
                display: none;
            }

            .profile-picture label {
                cursor: pointer;
                background-color: maroon;
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                transition: background-color 0.3s;
                font-size: smaller;
                position: absolute;
                left: 50%;
                bottom: -30px; /* Adjust the vertical position */
                transform: translateX(-50%);
                margin-bottom: 0px; /* Add space between the button and sidebar links */
                margin-top: 100px;
            }

            .profile-picture img {
                display: block; /* Ensure the image is displayed as a block element */
                margin: 0 auto; /* Center the image */
            }

            .profile-picture label:hover {
                background-color: #800000;
            }

            .empty-profile {
                background-color: red;
            }

            .success-message {
                color: green;
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

            @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
        }
            @media (max-width: 768px) {
            .container {
                max-width: 350px;
                margin: 60px auto 30px;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
               
            }
            form {
                display: grid;
                grid-template-columns: 1fr 2fr;
                grid-gap: 20px;
                justify-items: left;
            }
            input[type="submit"] {
                width: auto;
                padding: 10px 20px;
                background-color: maroon;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
                text-align: center; /* Center the button */
                margin: 0 auto; /* Center horizontally */
                display: block; /* Ensure the button occupies the full width */
            }

            input[type="submit"]:hover {
                background-color: #800000;
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



        </style>
    </head>
    <body>

    <div class="navbar">
    <div>
        <a href="admin_bulletin.php" class="logo">TUPM-COS EBBS</a>
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
        <div class="dropdown" onmouseover="showPostsDropdown()" onmouseout="hidePostsDropdown()">
            <button class="dropbtn">Posts</button>
            <div class="dropdown-content" id="postsDropdown">
                <a href="admin_upload.php">Uploads</a>
                <a href="admin_approved_post.php">Approved</a>
                <a href="admin_for_approval.php">For Approval</a>
                <a href="admin_rejected.php">Rejected</a>
            </div>
        </div>
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
    <a>Bulletin</a>
    <div class="indent">
        <a href="admin_bulletin_feed.php">Bulletin Feed</a>
        <a href="admin_bulletin.php">Bulletin Board</a>
    </div>
    <a>Posts</a>
    <div class="indent">    
        <a href="admin_upload.php">Uploads</a>
        <a href="admin_approved_post.php">Approved</a>
        <a href="admin_for_approval.php">For Approval</a>
        <a href="admin_rejected.php">Rejected</a>
    </div>
    <a href="admin_archive.php">Archive</a>
    <a>Profile</a>
    <div class="indent">
        <a href="admin_profile_settings.php">Profile Info</a>
        <a href="admin_change_username.php">Change Username</a>
        <a href="admin_change_password.php">Change Password</a>
    </div>
    <a href="logout.php">Logout</a>
</div>


<div class="sidebar">
    <div class="profile-picture">
        <!-- Display the user's profile picture from the database if available -->
        <?php if (!empty($profilePicture)) : ?>
            <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="User Profile Picture" class="profile-img" id="profile-picture">
        <?php else : ?>
            <img src="user.png" alt="Default Profile Picture" class="profile-img" id="profile-picture">
        <?php endif; ?>
        <form id="profile-picture-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <label for="profile-image-upload" class="profile-picture-button">Change Picture</label>
            <input type="file" id="profile-image-upload" name="profilePicture" onchange="document.getElementById('profile-picture-form').submit();">
            <!-- Hidden input field for the user ID -->
            <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">
            <!-- Other hidden input fields for user information -->
            <input type="hidden" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
            <input type="hidden" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="hidden" name="tupId" value="<?php echo htmlspecialchars($tupId); ?>">
            <input type="hidden" name="existingProfilePicture" value="<?php echo htmlspecialchars($profilePicture); ?>">
        </form>
    </div>
    <a href="admin_profile_settings.php">Profile</a>
    <a href="admin_change_username.php">Change Username</a>
    <a href="admin_change_password.php">Change Password</a>
    
</div>

<div class="container">
        <h1>Profile Info</h1>
        <?php if (!empty($success_message)) : ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <form id="profile-update-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <!-- Hidden input field for the user ID -->
            <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">

            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="tupId">TUP ID:</label>
            <input type="text" id="tupId" name="tupId" value="<?php echo htmlspecialchars($tupId); ?>">


           
            <!-- Hidden input field for the existing profile picture -->
            <input type="hidden" name="existingProfilePicture" value="<?php echo htmlspecialchars($profilePicture); ?>">

            <input type="submit" name="submit" value="Save Changes"> 
        </form>
    </div>

    <script>
    document.getElementById('profile-picture').addEventListener('click', function() {
        document.getElementById('profile-image-upload').click();
    });

    // Update profile picture preview
    document.getElementById('profile-image-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profile-picture').src = reader.result;
        };
        reader.readAsDataURL(file);
    });

    function toggleSideNavbar() {
        var sideNavbar = document.getElementById('sideNavbar');
        if (sideNavbar.style.right === '0px') {
            sideNavbar.style.right = '-250px';
        } else {
            sideNavbar.style.right = '0px';
        }
    }

    function closeSideNavbarOnLargeScreen() {
        var sideNavbar = document.getElementById('sideNavbar');
        var screenWidth = window.innerWidth;
        if (screenWidth > 768) {
            sideNavbar.style.right = '-250px';
        }
    }

    window.onload = closeSideNavbarOnLargeScreen;
    window.onresize = closeSideNavbarOnLargeScreen;
    </script>
    </body>
    </html>

