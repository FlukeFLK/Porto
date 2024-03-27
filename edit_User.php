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

// Check if the username is provided in the URL parameter
if(isset($_GET['username'])){
    $editUsername = $_GET['username'];

    // Perform a database query to fetch the user profile
    $userSql = "SELECT * FROM user WHERE username='$editUsername'";
    $userResult = $conn->query($userSql);

    if($userResult->num_rows == 1){
        // Fetch the user's existing information
        $userData = $userResult->fetch_assoc();
        $Name = $userData["Name"];
        $email = $userData["email"];
        $contactNo = $userData["contact_no"];
        $gender = $userData["gender"];
        $birthdate = $userData["birthdate"];
        $address = $userData["address"];
    }
    else {
        echo "User not found.";
        // You can redirect or handle the case where the user doesn't exist
    }
}
else {
    echo "Invalid URL.";
    // You can redirect or handle the case where the URL parameter is missing
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profilestyle.css">
</head>
<body>
<!-- Your HTML form to edit user profile goes here -->
<div class="container">
    <h1>Edit User Profile</h1>
    <form method="post" action="update_User.php">
        <input type="hidden" name="username" value="<?php echo $editUsername; ?>">
        <div class="mb-3">
            <label for="Name" class="form-label">Name</label>
            <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $Name; ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="mb-3">
            <label for="contactNo" class="form-label">Contact No</label>
            <input type="text" class="form-control" id="contactNo" name="contactNo" value="<?php echo $contactNo; ?>">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender">
                <option value="Male" <?php if ($gender == "Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if ($gender == "Female") echo "selected"; ?>>Female</option>
                <option value="Other" <?php if ($gender == "Other") echo "selected"; ?>>Other</option>
            </select>
        </div>
        
        
        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address"><?php echo $address; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<!-- Include your HTML form to edit user profile here -->

<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
