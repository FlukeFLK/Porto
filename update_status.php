<?php
include('server.php');

// Get the photographer and datetime values from the query parameters
$photographer = $_GET['photographer'];
$datetime = $_GET['datetime'];

// Update the status in the database to "Success!"
$updateStatusSql = "UPDATE appointments SET status = 'Success!' WHERE photographer = '$photographer' AND datetime = '$datetime'";

// Execute the update query
if ($conn->query($updateStatusSql) === TRUE) {
    // Status updated successfully
    echo "Status updated successfully";
} else {
    // Error updating status
    echo "Error updating status: " . $conn->error;
}

// Close the database connection or perform any necessary cleanup

?>
