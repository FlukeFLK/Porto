<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
}
else{
	$username="";
	//header("location: index.php");
}


$sql = "SELECT * FROM photographer WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$name=$row["Name"];
		$email=$row["email"];
		$contactNo=$row["contact_no"];
		$gender=$row["gender"];
		$birthdate=$row["birthdate"];
		$address=$row["address"];
		$skills=$row["skills"];
		$profile_sum=$row["profile_sum"];
		$experience=$row["experience"];
		$profile_image = $row["profile_image"];
	    }
} else {
    echo "0 results";
}
if (isset($_POST["editPhotographer"])) {
    // Process other form fields

    // Check if files were uploaded
    if (isset($_FILES['images']['name'])) {
        $fileCount = count($_FILES['images']['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES['images']['name'][$i];
            $fileTmpName = $_FILES['images']['tmp_name'][$i];

            // Upload the file to a directory (you can modify the path as per your requirement)
            $uploadPath = 'uploads/' . $fileName;
            move_uploaded_file($fileTmpName, $uploadPath);

            // Store the file information in the database
            $sql = "INSERT INTO images (username, filename) VALUES ('$username', '$uploadPath')";
            $result = $conn->query($sql);
        }
    }
	// Insert packages into the database
if (isset($_POST["addPackages"])) {
    $package1Title = $_POST["package1_title"];
    $package1Price = $_POST["package1_price"];
    $package1Detail = $_POST["package1_detail"];
    $package2Title = $_POST["package2_title"];
    $package2Price = $_POST["package2_price"];
    $package2Detail = $_POST["package2_detail"];
    $package3Title = $_POST["package3_title"];
    $package3Price = $_POST["package3_price"];
    $package3Detail = $_POST["package3_detail"];

    // Insert the packages into the database
    $insertSql = "INSERT INTO packages (username, title, price, detail) VALUES
                  ('$username', '$package1Title', '$package1Price', '$package1Detail'),
                  ('$username', '$package2Title', '$package2Price', '$package2Detail'),
                  ('$username', '$package3Title', '$package3Price', '$package3Detail')";
    $insertResult = $conn->query($insertSql);

    if ($insertResult === true) {
        header("location: photographerProfile.php");
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

// Fetch the packages for display
$packagesSql = "SELECT * FROM packages WHERE username = '$username' LIMIT 3";
$packagesResult = $conn->query($packagesSql);
$packages = array();

if ($packagesResult && $packagesResult->num_rows > 0) {
    while ($packageRow = $packagesResult->fetch_assoc()) {
        $packageTitle = $packageRow["title"];
        $packagePrice = $packageRow["price"];
        $packageDetail = $packageRow["detail"];
        $packages[] = array("title" => $packageTitle, "price" => $packagePrice, "detail" => $packageDetail);
    }
}
// Fetch the appointments for the photographer
$appointmentsSql = "SELECT * FROM appointments WHERE photographer = '$username'";
$appointmentsResult = $conn->query($appointmentsSql);

if ($appointmentsResult && $appointmentsResult->num_rows > 0) {
    while ($appointmentRow = $appointmentsResult->fetch_assoc()) {
        $user = $appointmentRow["user"];
        $package = $appointmentRow["package"];
        $datetime = $appointmentRow["datetime"];
        $price = $appointmentRow["price"];

        // Display the appointment details
        echo "User: $user<br>";
        echo "Package: $package<br>";
        echo "Datetime: $datetime<br>";
        echo "Price: $price<br><br>";
    }
} else {
    echo "No appointments available.";
}

}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>For Admin</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profilestyle.css">

</head>
<body>

<!--Navbar menu-->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
        <a class="navbar-brand" href="#"><span class="text-warning">Por</span>to</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
  </div>
</nav>
<!--End Navbar menu-->
<!--main body-->
<div style="padding:3%;">
<div class="row">

<!-- Admin Dashboard Navigation Bar -->
<!-- Include your navigation bar or sidebar for the admin dashboard here -->

<!-- Main Content Area -->
<div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Photographer Profiles Table -->
    <h2>Photographer Profiles</h2>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Skills</th>
            <th>Contact No</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Address</th>
            <th>Profile Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Pagination configuration
        $itemsPerPage = 4;
        $photographerPage = isset($_GET['photographerPage']) ? $_GET['photographerPage'] : 1;
        $photographerOffset = ($photographerPage - 1) * $itemsPerPage;

        // Fetch photographer profiles from the database with pagination
        $photographerSql = "SELECT * FROM photographer LIMIT $photographerOffset, $itemsPerPage";
        $photographerResult = $conn->query($photographerSql);

        while ($row = $photographerResult->fetch_assoc()) {
            $f_username = $row["username"];
            $Name = $row["Name"];
            $profile_image = $row["profile_image"];
            $skills = $row["skills"];
            $contactNo = $row["contact_no"]; // Retrieve additional fields
            $gender = $row["gender"];
            $birthdate = $row["birthdate"];
            $address = $row["address"];

            ?>

            <tr>
                <td><?php echo $f_username; ?></td>
                <td><?php echo $Name; ?></td>
                <td><?php echo $skills; ?></td>
                <td><?php echo $contactNo; ?></td>
                <td><?php echo $gender; ?></td>
                <td><?php echo $birthdate; ?></td>
                <td><?php echo $address; ?></td>
                <td>
                    <?php
                    // Define the default profile image path
                    $defaultProfileImage = 'image/img04.jpg';

                    // Check if profile_image is empty
                    if (!empty($profile_image)) {
                        $profileImageSrc = $profile_image; // Use the profile_image
                    } else {
                        $profileImageSrc = $defaultProfileImage; // Use the default profile image
                    }
                    ?>

                    <img src="<?php echo $profileImageSrc; ?>" class="rounded-circle" alt="Profile Image" style="width: 50px; height: 50px;">
                </td>
                <td>
                    <a href="edit_Photographer.php?username=<?php echo $f_username; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="deletePhotographer.php?username=<?php echo $f_username; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>

        <?php
        }
        ?>
    </tbody>
</table>


    <!-- Pagination for Photographer Profiles -->
    <?php
    $photographerCountSql = "SELECT COUNT(*) AS count FROM photographer";
    $photographerCountResult = $conn->query($photographerCountSql);
    $photographerCountRow = $photographerCountResult->fetch_assoc();
    $totalPhotographerPages = ceil($photographerCountRow['count'] / $itemsPerPage);

    if ($totalPhotographerPages > 1) {
        echo '<ul class="pagination">';
        for ($i = 1; $i <= $totalPhotographerPages; $i++) {
            echo '<li class="page-item ' . ($photographerPage == $i ? 'active' : '') . '"><a class="page-link" href="?photographerPage=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul>';
    }
    ?>

    <!-- User Profiles Table -->
    <h2>User Profiles</h2>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact No</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Pagination configuration
        $userPage = isset($_GET['userPage']) ? $_GET['userPage'] : 1;
        $userOffset = ($userPage - 1) * $itemsPerPage;

        // Fetch user profiles from the database with pagination
        $userSql = "SELECT * FROM user LIMIT $userOffset, $itemsPerPage";
        $userResult = $conn->query($userSql);

        while ($row = $userResult->fetch_assoc()) {
            $f_username = $row["username"];
            $Name = $row["Name"];
            $email = $row["email"];
            $contactNo = $row["contact_no"];
            $gender = $row["gender"];
            $birthdate = $row["birthdate"];
            $address = $row["address"];
            ?>

            <tr>
                <td><?php echo $f_username; ?></td>
                <td><?php echo $Name; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $contactNo; ?></td>
                <td><?php echo $gender; ?></td>
                <td><?php echo $birthdate; ?></td>
                <td><?php echo $address; ?></td>
                <td>
                    <a href="edit_User.php?username=<?php echo $f_username; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="deleteUser.php?username=<?php echo $f_username; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>

        <?php
        }
        ?>
    </tbody>
</table>


    <!-- Pagination for User Profiles -->
    <?php
    $userCountSql = "SELECT COUNT(*) AS count FROM user";
    $userCountResult = $conn->query($userCountSql);
    $userCountRow = $userCountResult->fetch_assoc();
    $totalUserPages = ceil($userCountRow['count'] / $itemsPerPage);

    if ($totalUserPages > 1) {
        echo '<ul class="pagination">';
        for ($i = 1; $i <= $totalUserPages; $i++) {
            echo '<li class="page-item ' . ($userPage == $i ? 'active' : '') . '"><a class="page-link" href="?userPage=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul>';
    }
    ?>
</div>

<!-- Appointments Table -->
<h2>Appointments Data</h2>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>User</th>
            <th>Photographer</th>
            <th>Package</th>
            <th>DateTime</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Pagination configuration
    $appointmentsPage = isset($_GET['appointmentsPage']) ? $_GET['appointmentsPage'] : 1;
    $appointmentsOffset = ($appointmentsPage - 1) * $itemsPerPage;

    // Fetch appointments from the database with pagination
    $appointmentsSql = "SELECT * FROM appointments LIMIT $appointmentsOffset, $itemsPerPage";
    $appointmentsResult = $conn->query($appointmentsSql);

    while ($row = $appointmentsResult->fetch_assoc()) {
        $f_username = $row["user"];
        $photographer = $row["photographer"];
        $package = $row["package"];
        $datetime = $row["datetime"];
        $price = $row["price"];
        $status = $row["status"];
        ?>

        <tr>
            <td><?php echo $f_username; ?></td>
            <td><?php echo $photographer; ?></td>
            <td><?php echo $package; ?></td>
            <td><?php echo $datetime; ?></td>
            <td><?php echo $price; ?></td>
            <td><?php echo $status; ?></td>
            <td>
                <a href="edit_Appointment.php?user=<?php echo $f_username; ?>&photographer=<?php echo $photographer; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="delete_Appointment.php?user=<?php echo $f_username; ?>&photographer=<?php echo $photographer; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>

    <?php
    }
    ?>
</tbody>
</table>


<!-- Pagination for Appointments -->
<?php
$appointmentsCountSql = "SELECT COUNT(*) AS count FROM appointments";
$appointmentsCountResult = $conn->query($appointmentsCountSql);
$appointmentsCountRow = $appointmentsCountResult->fetch_assoc();
$totalAppointmentsPages = ceil($appointmentsCountRow['count'] / $itemsPerPage);

if ($totalAppointmentsPages > 1) {
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $totalAppointmentsPages; $i++) {
        echo '<li class="page-item ' . ($appointmentsPage == $i ? 'active' : '') . '"><a class="page-link" href="?appointmentsPage=' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul>';
}
?>
</div>


</div>
</div>



<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>