<?php
include('server.php');
// Check if the user and photographer data is provided
if (isset($_GET['user']) && isset($_GET['photographer'])) {
    $user = $_GET['user'];
    $photographer = $_GET['photographer'];

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve the updated data from the form
        $newPackage = $_POST['package'];
        $newDateTime = $_POST['datetime'];
        $newPrice = $_POST['price'];

        // Update the appointment in the database
        $updateSql = "UPDATE appointments
                      SET package = '$newPackage',
                          datetime = '$newDateTime',
                          price = '$newPrice'
                      WHERE user = '$user'
                      AND photographer = '$photographer'";

            if ($conn->query($updateSql) === TRUE) {
                echo "Appointment updated successfully!";
                header("Location: dashboard.php");
                exit;
        } else {
            echo "Error updating appointment: " . $conn->error;
        }
    }

    // Retrieve the current appointment data from the database
    $appointmentSql = "SELECT * FROM appointments
                    WHERE user = '$user'
                    AND photographer = '$photographer'";
    
    $appointmentResult = $conn->query($appointmentSql);
    $row = $appointmentResult->fetch_assoc();
    $currentPackage = $row['package'];
    $currentDateTime = $row['datetime'];
    $currentPrice = $row['price'];
    ?>

    <!-- Edit Appointment Form -->
    <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Package</title>
            <!-- Add your CSS and JS files here -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/profilestyle.css">
        </head>
        <body>
    <h2>Edit Appointment</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="package">Package:</label>
            <input type="text" name="package" value="<?php echo $currentPackage; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="datetime">Date and Time:</label>
            <input type="datetime-local" name="datetime" value="<?php echo $currentDateTime; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo $currentPrice; ?>" class="form-control" step="0.01" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
    </body>
    <?php
} else {
    echo "User and photographer data not provided.";
}
?>
