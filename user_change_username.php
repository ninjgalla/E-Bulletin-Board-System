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

// Fetch profile picture from the database (assuming you have a table called 'users')
$query = "SELECT profile_picture FROM users WHERE username = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($profilePicture);
    $stmt->fetch();
    $stmt->close();
}

// Initialize variables to prevent undefined variable warnings
$userId = $firstName = $lastName = $email = $tupId = $profilePictureDB = '';
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
    if ($_FILES['profilePicture']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["profilePicture"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
            // Save the file path to the database
            $profilePictureDB = $targetFilePath;
        } else {
            $error_message = "Error uploading the profile picture.";
        }
    } else {
        // If no new file is uploaded, retain the old profile picture
        $profilePictureDB = isset($_POST['existingProfilePicture']) ? $_POST['existingProfilePicture'] : '';
    }

    // Update user information in the database
    $update_query = "UPDATE users SET first_name=?, last_name=?, email=?, TUP_id=?, profile_picture=? WHERE UserID=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $firstName, $lastName, $email, $tupId, $profilePictureDB, $userId);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        $success_message = "User information updated successfully.";
    } else {
        $error_message = "Error updating user information. Please try again later.";
    }

    $stmt->close();
}

// Fetch user details from the database only if the form is not submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $sql = "SELECT UserID, first_name, last_name, email, TUP_id, profile_picture FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $firstName, $lastName, $email, $tupId, $profilePictureDB);
    $stmt->fetch();
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
    <title>Profile Settings</title>
    <style>
        * {
            font-family: inherit;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
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

        .container {
            max-width: 500px;
            margin: 60px auto 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
            justify-items: center;
        }

        label {
            font-weight: bold;
            
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: maroon;
        }

        input[type="text"],
        input[type="password"] {
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

        .message {
            margin-bottom: 10px;
            color: green; /* Default color */
        }

        .error-message {
            color: green;
        }

        .success-message {
            color: green;
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
    </style>
</head>
<body>
<div class="navbar">
        <div>
            <a href="user_bulletin_feed.php" class="logo">TUPM-COS EBBS</a>
        </div>
        <div>
            <a href="user_profile_settings.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
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
               
                <input type="file" id="profile-image-upload" name="profilePicture" onchange="document.getElementById('profile-picture-form').submit();">
                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">
                <input type="hidden" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
                <input type="hidden" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <input type="hidden" name="tupId" value="<?php echo htmlspecialchars($tupId); ?>">
                <input type="hidden" name="existingProfilePicture" value="<?php echo htmlspecialchars($profilePicture); ?>">
            </form>
        </div>
        <a href="admin_profile_settings.php">User Info</a>
        <a href="admin_change_username.php">Change Username</a>
        <a href="admin_change_password.php">Change Password</a>
    </div>

    <a href="user_profile_settings.php">User Info</a>
    <a href="user_change_username.php">Change Username</a>
    <a href="user_change_password.php">Change Password</a>
</div>


    <!-- Change Username form -->
<div class="container">
    <h1>Change Username</h1>
    <?php if (!empty($_GET['message'])): ?>
        <?php $message = htmlspecialchars($_GET['message']); ?>
        <div class="message <?php echo ($username_change_successful ? 'success-message' : 'error-message'); ?>"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="user_change_username_handler.php" method="post">
        <div class="form-group">
            <label for="current_username">Current Username:</label>
            <input type="text" name="current_username" id="current_username" value="<?php echo htmlspecialchars($username); ?>" readonly style="color: gray;">
            <!-- Empty placeholder element to ensure consistent grid gap -->
            <div></div>
        </div>
        <div class="form-group">
            <label for="new_username">New Username:</label>
            <input type="text" name="new_username" id="new_username">
            <?php if (!empty($new_username_err)): ?>
                <span class="error-message"><?php echo $new_username_err; ?></span>
            <?php endif; ?>
            <!-- Empty placeholder element to ensure consistent grid gap -->
            <div></div>
        </div>
        <div class="form-group">
            <input type="submit" value="Change Username">
        </div>
    </form>
</div>



    </script>
</body>
</html>
