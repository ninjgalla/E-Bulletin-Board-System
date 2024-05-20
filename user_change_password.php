<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Include configuration file and database connection
require_once 'config.php';

// Fetch username from the session
$username = $_SESSION['username'];

// Define variables and initialize with empty values
$current_password = $new_password = $confirm_new_password = "";
$current_password_err = $new_password_err = $confirm_new_password_err = "";
$message = "";
$password_change_successful = false; // Initialize as false

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs and check for errors

    // Retrieve form data
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_new_password = $_POST["confirm_new_password"];

    // Validate current password
    if (empty(trim($current_password))) {
        $current_password_err = "Please enter your current password.";
    }

    // Validate new password
    if (empty(trim($new_password))) {
        $new_password_err = "Please enter a new password.";
    } elseif (strlen(trim($new_password)) < 8) {
        $new_password_err = "Password must have at least 8 characters.";
    }

    // Validate confirm new password
    if (empty(trim($confirm_new_password))) {
        $confirm_new_password_err = "Please confirm the new password.";
    } elseif ($new_password != $confirm_new_password) {
        $confirm_new_password_err = "Password did not match.";
    }

    // Check if there are no validation errors
    if (empty($current_password_err) && empty($new_password_err) && empty($confirm_new_password_err)) {
        // Check if the current password is correct
        $sql = "SELECT password FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($stored_password);
                if ($stmt->fetch()) {
                    if ($current_password == $stored_password) {
                        // Update the user's password in the database
                        $sql_update = "UPDATE users SET password = ? WHERE username = ?";
                        if ($stmt_update = $conn->prepare($sql_update)) {
                            $stmt_update->bind_param("ss", $new_password, $username);
                            if ($stmt_update->execute()) {
                                $password_change_successful = true;
                                $message = "Password changed successfully!";
                            } else {
                                $message = "Error changing password. Please try again later.";
                            }
                            $stmt_update->close();
                        } else {
                            $message = "Error changing password. Please try again later.";
                        }
                    } else {
                        $current_password_err = "The current password you entered is incorrect.";
                    }
                }
            } else {
                $message = "User not found.";
            }

            $stmt->close();
        } else {
            $message = "Error changing password. Please try again later.";
        }
    } else {
        // Set error message
        $message = "Please correct the errors in the form.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
            color: red;
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
        <!-- If no profile picture is available, display a default image -->
        <img src="user.png" alt="Default Profile Picture" class="profile-img" id="profile-picture">
    <?php endif; ?>
</div>

<a href="user_profile_settings.php">User Info</a>
<a href="user_change_username.php">Change Username</a>
<a href="user_change_password.php">Change Password</a>
</div>




<div class="container">
    <h1>Change Password</h1>
    <?php if (!empty($message)): ?>
        <div class="message <?php echo ($password_change_successful ? '' : 'error-message'); ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly style="color: gray;">
            <!-- Empty placeholder element to ensure consistent grid gap -->
            <div></div>
        </div>
        <div class="form-group">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" aria-describedby="current_password_err">
            <span class="error-message" id="current_password_err"><?php echo $current_password_err; ?></span>
        </div>
        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" aria-describedby="new_password_err">
            <span class="error-message" id="new_password_err"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-group">
            <label for="confirm_new_password">Confirm New Password:</label>
            <input type="password" name="confirm_new_password" id="confirm_new_password" aria-describedby="confirm_new_password_err">
            <span class="error-message" id="confirm_new_password_err"><?php echo $confirm_new_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" value="Change Password">
        </div>
    </form>
</div>




    </script>
</body>
</html>
