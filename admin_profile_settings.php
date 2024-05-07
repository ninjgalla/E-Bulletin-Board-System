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
    <title>Profile Settings</title>
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

        /* Updated CSS for file-item */
        .file-item {
            display: flex;
            align-items: center;
            padding: 10px; /* Adjust spacing */
            margin: 10px 0; /* Adjust margin to add space between items */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        /* CSS for file-details */
        .file-details {
            flex: 1; /* Take remaining space */
            padding-right: 20px; /* Add space between text and image */
        }

        /* CSS for file-media */
        .file-media {
            flex-shrink: 0; /* Prevent media from shrinking */
        }

        /* CSS for file-media img and video */
        .file-media img,
        .file-media video {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px; /* Add border radius */
        }

        /* Close button style */
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white; /* Set background color */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 10px); /* Adjusted to leave space on the right */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: maroon;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
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

        /* Additional styling for icons */
        .user-icon,
        .key-icon {
            width: 27px; /* Adjust the size of the icon */
            margin-right: 5px; /* Adjust the spacing between the icon and text */
            cursor: pointer; /* Add cursor pointer to indicate clickability */
        }

        .user-icon {
            margin-bottom: 10px; /* Add margin-bottom for space between icons */
        }

        .navbar-icons {
            display: flex;
            align-items: center;
            margin-left: 35px;
            margin-top: 25px; /* Add margin-top for space */
        }

        .navbar-icons-container {
            display: flex;
            align-items: center;
            flex-direction: column; /* Align icons vertically */
        }

        .navbar-icons-container a {
            text-decoration: none; /* Remove underline from profile link */
            color: black; /* Change text color of profile link */
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

<!-- Icons below the navbar -->
<div class="navbar-icons">
        <div class="navbar-icons-container">
            <!-- User icon -->
            <img class="user-icon" src="user_Icon.png" alt="User Icon" onclick="location.href='admin_profile_settings.php';">
            <!-- Key icon -->
            <img class="key-icon" src="key_icon.png" alt="Key Icon" onclick="location.href='admin_change_password.php';">
        </div>
    </div>

    <!-- Change Username form -->
    <div class="container">
        <h2>Change Username</h2>
        <?php if (!empty($_GET['message'])): ?>
            <?php $message = htmlspecialchars($_GET['message']); ?>
            <div class="message <?php echo ($username_change_successful ? 'success-message' : 'error-message'); ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="change_username_handler.php" method="post">
            <div class="form-group">
                <label for="current_username">Current Username:</label>
                <input type="text" name="current_username" id="current_username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="new_username">New Username:</label>
                <input type="text" name="new_username" id="new_username">
                <?php if (!empty($new_username_err)): ?>
                    <span class="error-message"><?php echo $new_username_err; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="submit" value="Change Username">
            </div>
        </form>
    </div>


    <script>

        function redirectToUploadPage() {
            window.location.href = "admin_upload.php";
        }

        function redirectToAdminBulletin() {
    window.location.href = "admin_bulletin.php";
}
    </script>
</body>
</html>
