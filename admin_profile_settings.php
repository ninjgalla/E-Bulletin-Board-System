<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$host = "localhost"; // Assuming your database is hosted locally
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "ebulletin_system"; // Your database name

// Establish database connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection is successful
if (!$connection) {
    die("Error: Database connection failed. " . mysqli_connect_error());
}

// Initialize variables to prevent undefined variable warnings
$userId = $firstName = $lastName = $email = $tupId = '';
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

    // Update user information in the database
    $update_query = "UPDATE users SET first_name='$firstName', last_name='$lastName', email='$email', TUP_id='$tupId' WHERE UserID='$userId'";
    $update_result = mysqli_query($connection, $update_query);

    // Check if the update was successful
    if ($update_result) {
        // Set success message
        $success_message = "User information updated successfully.";
    } else {
        // If the update fails, log the error or display a user-friendly message
        error_log("Error: " . mysqli_error($connection));
        $error_message = "Error updating user information. Please try again later.";
    }
}

// Fetch user details from the database
$sql = "SELECT UserID, first_name, last_name, email, TUP_id FROM users";
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if ($result) {
    // Fetch data (assuming there's only one row)
    $row = mysqli_fetch_assoc($result);
    
    // Assign fetched data to variables
    $userId = $row['UserID']; // Adjusted column name here
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];
    $email = $row['email'];
    $tupId = $row['TUP_id'];
} else {
    // If the query fails, log the error or display a user-friendly message
    error_log("Error: " . mysqli_error($connection));
    $error_message = "Error fetching user information.";
}

// Close the connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <style>
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
        .success-message {
    color: green;
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
    <!-- Display the user's profile picture from the database if available -->
    <?php if (!empty($profilePicture)) : ?>
        <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="User Profile Picture" class="profile-img" id="profile-picture">
    <?php else : ?>
        <!-- If no profile picture is available, display a default image -->
        <img src="user.png" alt="Default Profile Picture" class="profile-img" id="profile-picture">
    <?php endif; ?>
</div>

<a href="admin_profile_settings.php">User Info</a>
<a href="admin_change_username.php">Change Username</a>
<a href="admin_change_password.php">Change Password</a>
</div>


<div class="container">
    <h1>User Info</h1>
    <?php if (!empty($success_message)) : ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form id="profile-update-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" readonly style="color: gray;">

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>" readonly style="color: gray;">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <label for="tupId">TUP ID:</label>
        <input type="text" id="tupId" name="tupId" value="<?php echo htmlspecialchars($tupId); ?>" readonly style="color: gray;">
        
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
</script>

</body>
</html>
