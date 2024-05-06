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
        
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: white; /* Set navbar background color */
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

        .file-container {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; /* Hide overflow content */
            position: relative; /* Position relative for absolute positioning */
            height: 100vh; /* Full height */
            max-width: 800px; /* Adjust max width as needed */
            margin: 0 auto; /* Center horizontally */
        }
        .file-inner {
            display: flex;
            flex-direction: column;
            transition: transform 0.5s ease; /* Smooth slide transition */
        }
       /* Updated CSS for file-item */
                /* CSS for file-item */
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
        
        /* CSS for feedback popup form */
        .feedback-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .feedback-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .feedback-form h2 {
            margin-top: 0;
        }

        .feedback-form label {
            display: block;
            margin-bottom: 10px;
        }

        .feedback-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
        }

        .feedback-form input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: maroon;
            color: white;
            border: none;
            cursor: pointer;
        }

        .feedback-form .close-btn {
            margin-top: 10px;
            background-color: #ccc;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .active {
            display: block;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Reset the default margin */
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
        <a href="user_bulletin_feed.php">Home</a>
        <a href="user_profile_settings.php">Profile</a>
    </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>

      <!-- Icons below the navbar -->
<div class="navbar-icons">
    <div class="navbar-icons-container">
        <!-- User icon -->
        <img class="user-icon" src="user_Icon.png" alt="User Icon" onclick="location.href='user_profile_settings.php';">
        <!-- Key icon -->
        <img class="key-icon" src="key_icon.png" alt="Key Icon" onclick="location.href='user_change_password.php';">
    </div>
</div>
    
    

    <!-- Change Username form -->
    <div class="container">
        <h2>Change Username</h2>
        <?php if (!empty($_GET['message'])): ?>
            <?php $message = htmlspecialchars($_GET['message']); ?>
            <div class="message <?php echo ($username_change_successful ? 'success-message' : 'error-message'); ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="user_change_username_handler.php" method="post">
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
        // Other JavaScript functions for navbar and popup forms

        function openFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "block";
        }

        function closeFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "none";
        }
    </script>
</body>
</html>
