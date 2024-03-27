<?php
include('server.php');
// Retrieve the appointment ID from the AJAX request
$appointmentId = $_POST['appointmentId'];

// Update the status in the database
$updateStatusSql = "UPDATE appointments SET status = 'Success!' WHERE id = '$appointmentId'";
$conn->query($updateStatusSql);

// Send a response to indicate the success of the update
echo "Status updated successfully";
?>
