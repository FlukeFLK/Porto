<?php
include('server.php');

// Check if the user is logged in
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
} else {
    $username = "";
    // Redirect to the login page or handle accordingly
}

if (isset($_POST["addPackage"])) {
    $packageTitle = $_POST["package_title"];
    $packagePrice = $_POST["package_price"];
    $packageDetail = $_POST["package_detail"];

    // Insert the package into the database
    $insertSql = "INSERT INTO packages (detail, title, price, username) VALUES ('$packageDetail','$packageTitle', '$packagePrice', '$username')";
    $insertResult = $conn->query($insertSql);

    if ($insertResult === true) {
        header("location: photographerProfile.php");
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}
?>
