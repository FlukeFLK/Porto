<?php
// Include the database connection file
include 'server.php';
// Get the username of the photographer to be deleted
$username = $_GET['username'];
// Delete the photographer from the database
$sql = "DELETE FROM photographer WHERE username='$username'";
$result = $conn->query($sql);
// Check if the photographer was deleted successfully
if ($result) {
    // Redirect to the photographers page with a success message
    header("Location: dashboard.php?message=Photographer deleted successfully");
} else {
    // Redirect to the photographers page with an error message
    header("Location: dashboard.php?message=Error deleting photographer");
}
?>