<?php
// admin_approve_post.php
$db = new mysqli("localhost", "root", "", "ebulletin_system");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$id = $_GET['id'];
$status = $_GET['status']; // 'approved' or 'rejected'

$sql = "UPDATE bulletin_files SET status='$status' WHERE id='$id'";
if ($db->query($sql) === TRUE) {
    echo "Post status updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}

$db->close();
?>
