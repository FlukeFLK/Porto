<?php
include('server.php');

// Check if the user is logged in
if(isset($_SESSION["Username"])){
    $username = $_SESSION["Username"];
}
else{
    header("location: index.php");
    exit();
}

if(isset($_GET['user']) && isset($_GET['photographer'])){
    // Retrieve the usernames from the URL parameters
    $user = $_GET['user'];
    $photographer = $_GET['photographer'];

    // Perform a database query to check if the appointment exists
    $checkSql = "SELECT * FROM appointments WHERE user='$user' AND photographer='$photographer'";
    $checkResult = $conn->query($checkSql);

    if($checkResult->num_rows > 0){
        // Appointment exists, perform the delete operation
        $deleteSql = "DELETE FROM appointments WHERE user='$user' AND photographer='$photographer'";
        if($conn->query($deleteSql) === TRUE){
            // Redirect to an appropriate page after successful deletion
            header("location: dashboard.php");
            exit();
        }
        else{
            echo "Error deleting appointment: " . $conn->error;
        }
    }
    else {
        echo "Appointment not found.";
        // You can redirect or handle the case where the appointment doesn't exist
    }
}
else {
    echo "Invalid URL.";
    // You can redirect or handle the case where the URL parameters are missing
}
?>
