<?php
include('server.php');
// Check if the user is logged in
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
} else {
    $username = "";
    // Redirect to the login page or handle accordingly
}

if (isset($_GET["id"])) {
    $packageId = $_GET["id"];

    $deleteSql = "DELETE FROM packages WHERE id = '$packageId' AND username = '$username'";
    $deleteResult = $conn->query($deleteSql);

    if ($deleteResult === true) {
        header("location: photographerProfile.php");
    } else {
        echo "Error: " . $deleteSql . "<br>" . $conn->error;
    }
}
?>
