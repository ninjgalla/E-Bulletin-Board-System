<!-- change_password_handler.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: login.php");
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
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $sql = "UPDATE users SET password = ? WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $hashed_password, $username);
            if ($stmt->execute()) {
                $password_change_successful = true;
                $message = "Password changed successfully!";
            } else {
                $message = "Error changing password. Please try again later.";
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <?php if (!empty($message)): ?>
            <div class="message <?php echo ($password_change_successful ? '' : 'error-message'); ?>"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
</body>
</html>
