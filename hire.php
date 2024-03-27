<?php
include('server.php');

// Check if the form was submitted
if (isset($_POST['hire'])) {
    // Get the values from the form
    $photographer = $_POST['photographer'];
    $package = $_POST['package'];
    $user = $_SESSION['Username']; // Assuming you have the user's username stored in the session
    $datetime = date('Y-m-d H:i:s'); // Current datetime
    $price = $_POST['price']; // Assuming you have the package price available in the form

    // Perform the database insertion
    // Modify the following code to fit your database structure and insertion logic
    $insertSql = "INSERT INTO appointments (user, photographer, package, datetime, price) 
                  VALUES ('$user', '$photographer', '$package', '$datetime', '$price')";
    
    // Run the insertion query
    if ($conn->query($insertSql) === true) {
        // Insertion successful
        echo "<script>
            window.onload = function() {
                alert('Appointment created successfully.');
                window.location.href = 'viewPhotographer.php';
            };
        </script>";
    } else {
        // Insertion failed
        echo "Error creating appointment: " . $conn->error;
    }
}
?>

