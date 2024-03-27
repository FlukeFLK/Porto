<?php
// Include the database connection file
include 'server.php';
// Get the username of the user to be deleted
$username = $_GET['username'];
// Delete the user from the database
$sql = "DELETE FROM user WHERE username='$username'";
$result = $conn->query($sql);
// Check if the user was deleted successfully
if ($result) {
    // Redirect to the users page with a success message
    header("Location: dashboard.php?message=user deleted successfully");
} else {
    // Redirect to the users page with an error message
    header("Location: dashboard.php?message=Error deleting user");
}
?>