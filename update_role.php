<?php
// Include database connection
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['userId'];
    $newRole = $_POST['role'];

    // Update user's role in the database
    $update_query = "UPDATE users SET RoleID = ? WHERE UserID = ?";
    $stmt = $conn->prepare($update_query);

    // Map the new role name to RoleID
    $roleId = null;
    switch ($newRole) {
        case 'User':
            $roleId = 1;
            break;
        case 'Admin':
            $roleId = 2;
            break;
        case 'Super Admin':
            $roleId = 3;
            break;
        // Add more cases for additional roles if needed
    }

    // Bind parameters and execute query
    $stmt->bind_param("ii", $roleId, $userId);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect back to user management page with success message
        header("Location: superadmin_user_management.php?success=Role updated successfully.");
        exit;
    } else {
        // Redirect back to user management page with error message
        header("Location: superadmin_user_management.php?error=Failed to update role. Please try again later.");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to user management page
    header("Location: superadmin_user_management.php");
    exit;
}
