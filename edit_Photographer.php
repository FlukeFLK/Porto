<?php
include('server.php');

// Check if the user is logged in
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
} else {
    header("location: index.php");
    exit();
}

// Check if the photographer's username is provided in the URL
if (isset($_GET['username'])) {
    $editUsername = $_GET['username'];

    // Fetch the photographer's profile information
    $photographerSql = "SELECT * FROM photographer WHERE username='$editUsername'";
    $photographerResult = $conn->query($photographerSql);

    if ($photographerResult->num_rows > 0) {
        $row = $photographerResult->fetch_assoc();
        $Name = $row["Name"];
        $skills = $row["skills"];
        $contactNo = $row["contact_no"];
        $gender = $row["gender"];
        $birthdate = $row["birthdate"];
        $address = $row["address"];
        $profile_image = $row["profile_image"];
    } else {
        echo "Photographer not found.";
        exit();
    }
} else {
    echo "Photographer username not provided.";
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted data
    $newName = $_POST["Name"];
    $newSkills = $_POST["skills"];
    $newContactNo = $_POST["contactNo"];
    $newGender = $_POST["gender"];
    $newBirthdate = $_POST["birthdate"];
    $newAddress = $_POST["address"];
    
    // Update the photographer's profile information in the database
    $updateSql = "UPDATE photographer SET Name='$newName', skills='$newSkills', contact_no='$newContactNo', gender='$newGender', birthdate='$newBirthdate', address='$newAddress' WHERE username='$editUsername'";
    $updateResult = $conn->query($updateSql);

    if ($updateResult) {
        // Redirect to the photographer's profile page after successful update
        header("location: dashboard.php");
    } else {
        echo "Error updating photographer information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Photographer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/profilestyle.css">
</head>
<body>
    <div class="container">
        <h1>Edit Photographer Profile</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $Name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="skills" class="form-label">Skills</label>
                <input type="text" class="form-control" id="skills" name="skills" value="<?php echo $skills; ?>" required>
            </div>
            <div class="mb-3">
                <label for="contactNo" class="form-label">Contact No</label>
                <input type="text" class="form-control" id="contactNo" name="contactNo" value="<?php echo $contactNo; ?>" required>
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
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>
