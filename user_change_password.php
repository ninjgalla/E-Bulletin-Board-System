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
    <title>Profile Settings</title>
    <style>
       html, body {
            margin: 0;
            font-family: Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Inherit font-family for all other elements */
        * {
            font-family: inherit;
        }

        .container {
            max-width: 400px;
            margin: -30px auto 0; /* Adjusted margin for positioning */
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
            color: red;
        }

        /* Make the username text color gray */
        #username {
            color: gray;
        }

        /* Style for navbar and side navbar */
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
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* CSS for popup form */
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
    <!-- Navbar -->
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


    <div class="container">
        <h2>Change Password</h2>
        <?php if (!empty($message)): ?>
            <div class="message <?php echo ($password_change_successful ? '' : 'error-message'); ?>"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password">
                <span class="error-message"><?php echo $current_password_err; ?></span>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password">
                <span class="error-message"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm New Password:</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password">
                <span class="error-message"><?php echo $confirm_new_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Change Password">
            </div>
        </form>
    </div>

    <script>

         // Function to open the feedback popup
         function openFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "block";
        }

        // Function to close the feedback popup
        function closeFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "none";
        }
    </script>
</body>
</html>
