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
        /* Inherit font-family for all other elements */
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
            padding: 10px;
            text-decoration: none;
            display: block;
            color: maroon;
            transition: 0.3s;
            margin-bottom: 30px;
            margin-left: 30px;
            font-size: larger;
            margin-top: 30px;
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
        }

        .profile-picture label:hover {
            background-color: #800000;
        }

        .empty-profile {
            background-color: red;
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
<div class="sidebar">
    <div class="profile-picture">
        <img src="user.png" alt="User Profile Picture" class="profile-img" id="profile-picture">
        <input type="file" id="profile-image-upload" accept="image/*">
        
    </div>

    <a href="admin_profile_settings.php">User Info</a>
    <a href="admin_change_username.php">Change Username</a>
    <a href="admin_change_password.php">Change Password</a>
</div>


    <!-- Change Username form -->
<div class="container">
    <h1>Change Username</h1>
    <?php if (!empty($_GET['message'])): ?>
        <?php $message = htmlspecialchars($_GET['message']); ?>
        <div class="message <?php echo ($username_change_successful ? 'success-message' : 'error-message'); ?>"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="admin_change_username_handler.php" method="post">
        <div class="form-group">
            <label for="current_username">Current Username:</label>
            <input type="text" name="current_username" id="current_username" value="<?php echo htmlspecialchars($username); ?>" readonly>
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
