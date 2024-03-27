<?php
include('server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    // Retrieve the user value from the form
    $user = $_POST["user"];

    // Delete the appointment from the database
    $deleteSql = "DELETE FROM appointments WHERE user = '$user'";
    if ($conn->query($deleteSql) === TRUE) {
        // Appointment deleted successfully
        echo '<script>alert("Appointment deleted successfully."); window.location.href = "photographerProfile.php";</script>';
        exit(); // Terminate the script to prevent further execution
    } else {
        // Error deleting the appointment
        echo '<script>alert("Error deleting appointment: ' . $conn->error . '"); window.location.href = "photographerProfile.php";</script>';
        exit(); // Terminate the script to prevent further execution
    }
} else {
    // Invalid request or delete parameter not set
    echo '<script>alert("Invalid request."); window.location.href = "photographerProfile.php";</script>';
    exit(); // Terminate the script to prevent further execution
}
?>
