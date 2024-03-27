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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted data
    $editUsername = $_POST["username"];
    $Name = $_POST["Name"];
    $email = $_POST["email"];
    $contactNo = $_POST["contactNo"];
    $gender = $_POST["gender"];
    $birthdate = $_POST["birthdate"];
    $address = $_POST["address"];

    // Update the user's information in the database
    $updateSql = "UPDATE user SET Name='$Name', email='$email', contact_no='$contactNo', gender='$gender', birthdate='$birthdate', address='$address' WHERE username='$editUsername'";
    $updateResult = $conn->query($updateSql);

    if ($updateResult) {
        // Redirect to the user's profile page after successful update
        header("location: dashboard.php");
    } else {
        echo "Error updating user information: " . $conn->error;
    }
}
?>
