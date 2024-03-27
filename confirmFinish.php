<?php
include('server.php');

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

// Check if the finish button was clicked
if (isset($_POST["finish"])) {
    $user = $_POST["user"];

    // Update the appointment status to "Finished"
    $updateSql = "UPDATE appointments SET status = 'Finished' WHERE user = '$user'";
    $updateResult = $conn->query($updateSql);

    if ($updateResult) {
        // Appointment status updated successfully
        echo "<script>alert('Appointment marked as finished.'); window.location.href = 'photographerProfile.php';</script>";
    } else {
        // Failed to update appointment status
        echo "<script>alert('Error updating appointment status.'); window.location.href = 'photographerProfile.php';</script>";
    }
} else {
    // Invalid access to the page
    echo "<script>alert('Invalid request.'); window.location.href = 'photographerProfile.php';</script>";
}
?>
