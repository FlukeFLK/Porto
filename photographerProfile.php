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
	<title>Photographer profile</title>
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
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">หน้าหลัก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="photographerProfile.php">หน้าโปรไฟล์</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="photographerProfile.php">ดูนัดหมาย</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sendMessage.php">แชท</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="photographerProfile.php" style="color: black;">Good Morning ⛅ <?php echo $username; ?>!</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php" style="color: red;">Logout</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
<!--End Navbar menu-->


<!-- Main body -->
<div style="padding: 5% 3% 1% 3%;">
    <div class="row">
        <!-- Column 1 -->
        <div class="col-lg-3">
            <!-- Main profile card -->
            <div class="card" style="padding: 20px 20px 5px 20px; margin-top: 20px;">
                <p></p>
                <?php if (!empty($profile_image)) { ?>
                    <img src="<?php echo $profile_image; ?>" alt="Profile Image">
                <?php } else { ?>
                    <img src="image/img04.jpg" alt="Default Profile Image">
                <?php } ?>
                <h2><?php echo $name; ?></h2>
                <p><span class="glyphicon glyphicon-user"></span> <?php echo $username; ?></p>
                <ul class="list-group">
                    <a href="editPhotographer.php" class="btn btn-warning">Edit Profile</a>
                    <a href="message.php" class="btn btn-info">Messages</a>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </ul>
            </div>
            <!-- End Main profile card -->
            
			
		<!-- Display Reviews and Ratings -->
        <div class="card" style="padding: 20px 20px 5px 20px; margin-top: 20px;">
                <div class="panel-heading">Reviews & Ratings</div>
                <div class="panel-body">
                    <?php
                    // Retrieve reviews and ratings for the photographer
                    $reviewsSql = "SELECT * FROM reviews WHERE photographer_username = '$username'";
                    $reviewsResult = $conn->query($reviewsSql);

                    if ($reviewsResult && $reviewsResult->num_rows > 0) {
                        while ($reviewRow = $reviewsResult->fetch_assoc()) {
                            $userReview = $reviewRow["review_text"];
                            $userRating = $reviewRow["rating"];
                            $reviewId = $reviewRow["id"];
                            echo '<div class="review">';
                            echo '<p><strong>User:</strong> ' . $reviewRow["user_username"] . '</p>';
                            echo '<p><strong>Review:</strong> ' . $userReview . '</p>';
                            echo '<p><strong>Rating:</strong> ' . $userRating . '/5</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No reviews and ratings available.</p>";
                    }
                    ?>
                </div>
            </div>
            <!-- End Display Reviews and Ratings -->

        </div>
        <!-- End Column 1 -->

        <!-- Column 2 -->
        <div class="col-lg-7">
            <!-- Photographer Profile Details -->
            <div class="card" style="padding: 20px 20px 5px 20px; margin-top: 20px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Photographer Profile Details</h3>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Skills</div>
                    <div class="panel-body">
                        <h4><?php echo $skills; ?></h4>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Profile Summary</div>
                    <div class="panel-body">
                        <h4><?php echo $profile_sum; ?></h4>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Experience</div>
                    <div class="panel-body">
                        <h4><?php echo $experience; ?></h4>
                    </div>
                </div>
            </div>
            <!-- End Photographer Profile Details -->
			<!-- Appointments Card -->
<div class="card" style="padding: 20px; margin-top: 20px;">
    <div class="card-body">
        <h5 class="card-title">Appointments</h5>
        <?php
        
        // Fetch the total number of appointments for the photographer
        $totalAppointmentsSql = "SELECT COUNT(*) AS total FROM appointments WHERE photographer = '$username'";
        $totalAppointmentsResult = $conn->query($totalAppointmentsSql);
        $totalAppointmentsRow = $totalAppointmentsResult->fetch_assoc();
        $totalAppointments = $totalAppointmentsRow['total'];

        $appointmentsPerPage = 5; // Number of appointments to display per page
        $totalPages = ceil($totalAppointments / $appointmentsPerPage); // Calculate the total number of pages

        // Get the current page number
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }

        // Calculate the offset for the query
        $offset = ($currentPage - 1) * $appointmentsPerPage;

        // Fetch the appointments for the current page
        $appointmentsSql = "SELECT * FROM appointments WHERE photographer = '$username' LIMIT $offset, $appointmentsPerPage";
        $appointmentsResult = $conn->query($appointmentsSql);

        if ($appointmentsResult && $appointmentsResult->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>User</th>';
            echo '<th>Package</th>';
            echo '<th>Date/Time</th>';
            echo '<th>Price</th>';
            echo '<th>Status</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($appointmentRow = $appointmentsResult->fetch_assoc()) {
                $appointmentId = $appointmentRow["id"];
                $user = $appointmentRow["user"];
                $package = $appointmentRow["package"];
                $datetime = $appointmentRow["datetime"];
                $price = $appointmentRow["price"];
                $status = $appointmentRow["status"];

                echo '<tr>';
                echo '<td>' . $user . '</td>';
                echo '<td>' . $package . '</td>';
                echo '<td>';
                echo '<form method="post" action="editAppointment.php">';
                echo '<input type="hidden" name="appointmentId" value="' . $appointmentId . '">';
                echo '<input type="datetime-local" name="datetime" value="' . $datetime . '" required>';
                echo '<button type="submit" name="edit" class="btn btn-warning">Edit/Save Appointment</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>' . $price . '</td>';
                echo '<td>' . $status . '</td>';
                echo '<td>';

                if ($status == 'pending') {
                    echo '<form method="post" action="sendMessagePhotographer.php?msgTo=' . $user . '">';
                    echo '<button type="submit" name="chat" class="btn btn-info">Chat</button>';
                    echo '</form>';

                    echo '<form method="post" action="confirmFinish.php">';
                    echo '<input type="hidden" name="user" value="' . $user . '">';
                    echo '<button type="submit" name="finish" class="btn btn-success">Finish</button>';
                    echo '</form>';
                    
                } elseif ($status == 'Success!') {
                    echo '<form method="post" action="deleteAppointment.php">';
                    echo '<input type="hidden" name="user" value="' . $user . '">';
                    echo '<button type="submit" name="delete" class="btn btn-danger">Delete</button>';
                    echo '</form>';
                }elseif ($status == 'Finished') {
                    echo '<form method="post" action="sendMessagePhotographer.php?msgTo=' . $user . '">';
                    echo '<button type="submit" name="chat" class="btn btn-info">Chat</button>';
                    echo '</form>';
                }

                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Pagination links
            echo '<nav aria-label="Appointments Pagination">';
            echo '<ul class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li class="page-item';
                if ($i == $currentPage) {
                    echo ' active';
                }
                echo '"><a class="page-link" href="photographerProfile.php?page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul>';
            echo '</nav>';
        } else {
            echo "<p>No appointments available.</p>";
        }
        ?>
    </div>
</div>
<!-- End Appointments Card -->
<!-- Packages Card -->
<div class="card" style="padding: 20px; margin-top: 20px;">
    <div class="card-body">
        <h5 class="card-title text-center">Packages</h5>
        <?php
        // Fetch packages for the photographer
        $packagesSql = "SELECT * FROM packages WHERE username = '$username' LIMIT 3";
        $packagesResult = $conn->query($packagesSql);

        if ($packagesResult && $packagesResult->num_rows > 0) {
            while ($packageRow = $packagesResult->fetch_assoc()) {
                $packageTitle = $packageRow["title"];
                $packagePrice = $packageRow["price"];
                $packageDetail = $packageRow["detail"]; // Additional detail column from the database
                ?>
                <div class="package-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h6 class="card-title text-center"><?php echo $packageTitle; ?></h6>
                            <p class="card-text text-center">฿<?php echo $packagePrice; ?></p>
                            <p class="card-text text-center"><?php echo $packageDetail; ?></p> <!-- Display the additional detail -->
                            <div class="package-actions d-flex justify-content-center">
                                <a href="edit_package.php?id=<?php echo $packageRow['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete_package.php?id=<?php echo $packageRow['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No packages available.</p>";
        }
        ?>
    </div>
</div>
        </div>

        <!-- End Column 2 -->

        
    <!-- Column 3 -->
<div class="col-lg-2">
    

    <!-- Add Package Form -->
    <div class="card" style="padding: 20px; margin-top: 20px;">
        <div class="card-body">
            <h5 class="card-title">Add Package</h5>
            <form method="post" action="add_package.php">
                <div class="mb-3">
                    <label for="package_title">Title:</label>
                    <input type="text" class="form-control" id="package_title" name="package_title" required>
                </div>
                <div class="mb-3">
                    <label for="package_price">Price:</label>
                    <input type="number" class="form-control" id="package_price" name="package_price" required>
                </div>
                <div class="mb-3">
                    <label for="package_detail">Detail:</label>
                    <textarea class="form-control" id="package_detail" name="package_detail" required></textarea>
                </div>
                <button type="submit" name="addPackage" class="btn btn-primary">Add Package</button>
            </form>
        </div>
    </div>
    <!--My Wallet-->
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-info">
			  <div class="panel-heading"><h3>My Wallet</h3></div>
			</div>
			<ul class="list-group">
			  <li class="list-group-item"><?php echo $money; ?></li>
			</ul>
            <button type="submit" name="withdraw" class="btn btn-primary">Withdraw</button>
		</div>
<!--End My Wallet-->
</div>

<!-- End Column 3 -->


    </div>
</div>
<!-- End main body -->

<!--Multiple Image Upload-->
<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
    <form id="uploadForm" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="images">Upload Images</label>
            <input type="file" class="form-control" name="images[]" id="images" multiple>
        </div>
        <div class="form-group">
            <button type="submit" name="editPhotographer" class="btn btn-warning" id="uploadBtn" disabled>Upload Images</button>
        </div>
    </form>
</div>
<!--End Multiple Image Upload-->

<!-- Display Uploaded Images -->
<?php
$sql = "SELECT * FROM images WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo '<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">';
    echo '<h3>Uploaded Images</h3>';
    echo '<div class="row">';
    while ($row = $result->fetch_assoc()) {
        $imageId = $row["id"];
        $imagePath = $row["filename"];
        echo '<div class="col-lg-3">';
        echo '<img src="' . $imagePath . '" class="img-thumbnail" alt="Uploaded Image">';
        echo '<form action="deleteImage.php" method="post">';
        echo '<input type="hidden" name="image_id" value="' . $imageId . '">';
        echo '<button type="submit" class="btn btn-danger">Delete</button>';
        echo '</form>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}
?>
<!-- End Display Uploaded Images -->

<script>
    // Disable or enable the upload button based on file selection
    document.getElementById('images').addEventListener('change', function() {
        const uploadBtn = document.getElementById('uploadBtn');
        uploadBtn.disabled = this.files.length === 0;
    });
</script>




<!--Footer-->
<footer class="bg-dark p-2 text-center">
  <div class="container">
    <p class="text-white">All Right Reseved @Porto</p>
  </div>
</footer>
<!--End Footer-->


<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>