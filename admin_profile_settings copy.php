<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000; /* Ensure the navbar stays on top */
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

        .sidebar {
            height: calc(100vh - 60px); /* Adjust height to fit the remaining space */
            width: 250px;
            position: fixed;
            top: 60px; /* Adjust top position to ensure it starts below the navbar */
            left: 0;
            background-color: #e4f2f2; /* Set sidebar background color */
            padding-top: 15px;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1); /* Add shadow */
            z-index: 999; /* Ensure the sidebar is behind the navbar */
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
            font-weight: bold; /* Make the font bolder on hover */
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 80px; /* Add margin to avoid overlapping with navbar */
            z-index: 1; /* Ensure the content is above the sidebar */
            background-color: #ffffff; /* Set content background color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow */
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
    <a href="admin_profile_settings.php">User Info</a>
    <a href="admin_change_username.php">Change Username</a>
    <a href="admin_change_password.php">Change Password</a>
</div>



</body>
</html>
