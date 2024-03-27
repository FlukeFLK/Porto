<?php
include('server.php');
// Check if the user is logged in
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
} else {
    $username = "";
    // Redirect to the login page or handle accordingly
}

if (isset($_POST["updatePackage"]) && isset($_GET["id"])) {
    $packageId = $_GET["id"];
    $packageTitle = $_POST["package_title"];
    $packagePrice = $_POST["package_price"];
    $packageDetail = $_POST["package_detail"];

    $updateSql = "UPDATE packages SET detail = '$packageDetail', title = '$packageTitle', price = '$packagePrice' WHERE id = '$packageId' AND username = '$username'";
    $updateResult = $conn->query($updateSql);

    if ($updateResult === true) {
        header("location: photographerProfile.php");
    } else {
        echo "Error: " . $updateSql . "<br>" . $conn->error;
    }
}
?>
