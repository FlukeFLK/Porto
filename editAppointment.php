<?php
include('server.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the appointment ID from the submitted form data
    $appointmentId = $_POST['appointmentId'];

    // Perform any necessary validation or sanitization on the appointment ID

    // Get the new datetime from the submitted form data
    $newDatetime = $_POST['datetime'];

    // Perform any necessary validation or sanitization on the new datetime

    // Update the appointment's datetime in the database
    $updateSql = "UPDATE appointments SET datetime = '$newDatetime' WHERE id = '$appointmentId'";
    $updateResult = $conn->query($updateSql);

    if ($updateResult) {
        // Appointment datetime updated successfully
        // Redirect back to the photographer profile page or handle accordingly
        header('Location: photographerProfile.php');
        exit;
    } else {
        // Error updating the appointment datetime
        // Handle the error scenario appropriately
        echo "Error updating appointment datetime.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
    <!-- Add your CSS and JS files here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profilestyle.css">
</head>
<body>
    <h1>Edit Appointment</h1>
    <form method="post" action="editAppointment.php">

        <!-- Include any input fields or form elements necessary for editing -->
        <div>
            <label for="datetime">New Datetime:</label>
            <input type="datetime-local" name="datetime" id="datetime" required>
        </div>
        <input type="hidden" name="appointmentId" value="<?php echo $_POST['appointmentId']; ?>">
        <button type="submit" name="edit" class="btn btn-primary">Save Changes</button>
    </form>
</body>
</html>
