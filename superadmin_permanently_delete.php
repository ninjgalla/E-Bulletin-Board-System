<?php
// Include database connection
include('config.php');

// Check if the ID parameter is set
if(isset($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Construct the SQL query to delete the item from the database
    $sql = "DELETE FROM bulletin_files WHERE id = '$id'";

    // Execute the SQL query
    if(mysqli_query($conn, $sql)) {
        echo "Item permanently deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "ID parameter is not set.";
}

// Close the database connection
mysqli_close($conn);
?>
