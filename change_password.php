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
            color: red;
        }

        /* Make the username text color gray */
        #username {
            color: gray;
        }

        /* Style for navbar and side navbar */
        .navbar {
            background-color: maroon;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px; /* Adjust the margin to add space between menu items */
            position: relative;
        }

        .navbar a:hover::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -3px; /* Adjust the value to control the distance of the underline from text */
            width: 100%;
            height: 2px;
            background-color: white;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .sidenav a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 25px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            background-color: #444;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div>
            <a href="user_dashboard.php">Home</a>
            <a href="#" onclick="openNav()">Profile</a>
            <a href="#" onclick="openFeedbackPopup()">Feedback</a>
        </div>
        <div></div> <!-- Placeholder for menu options on the right if needed -->
    </div>

    <!-- Side navbar content -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Profile Settings</a>
        <a href="change_password.php">Change Password</a>
        <a href="logout.php">Logout</a> <!-- Logout button -->
    </div>

     <!-- Feedback popup form -->
     <div id="feedbackPopup" class="feedback-popup">
        <form class="feedback-form" action="submit_feedback.php" method="post">
            <h2>Feedback Form</h2>
            <label for="feedback">Your Feedback:</label>
            <textarea id="feedback" name="feedback" required></textarea>
            <input type="submit" value="Submit">
            <button type="button" class="close-btn" onclick="closeFeedbackPopup()">Close</button>
        </form>
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
        // Function to open the side navbar
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        // Function to close the side navbar
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

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
