<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
	if ($_SESSION["Usertype"]==1) {
		$linkPro="photographerProfile.php";
		$linkEditPro="editPhotographer.php";
		
	}
	else{
		$linkPro="userProfile.php";
		$linkEditPro="editUser.php";
		
	}
}
else{
    $username="";
	//header("location: index.php");
}

if(isset($_SESSION["f_user"])){
	$f_user=$_SESSION["f_user"];
	$_SESSION["msgRcv"]=$f_user;
}

$sql = "SELECT * FROM photographer WHERE username='$f_user'";
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
		$profile_image = $row["profile_image"];
	    }
} else {
    echo "0 results";
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
	
	
<style>
	body{padding-top: 3%;margin: 0;}
	.card{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background:#fff}
</style>

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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            หาช่างภาพ
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="allPhotographer.php">หาช่างภาพมืออาชีพ 📸</a></li>
            <li><a class="dropdown-item" href="allPhotographer.php">หาช่างภาพมือใหม่ 🔥</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="userProfile.php">ดูนัดหมาย</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="message.php">แชท</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="userProfile.php" style="color: black;">Good Morning ⛅ <?php echo $username; ?>!</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php" style="color: red;">Logout</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
<!--End Navbar menu-->


<!--main body-->
<div style="padding:1% 3% 1% 3%;">
<div class="row">

<!--Column 1-->
	<div class="col-lg-3">

<!--Main profile card-->
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<p></p>
			<?php 
				if (!empty($profile_image)) { ?>
        	<img src="<?php echo $profile_image; ?>" alt="Profile Image">
    		<?php } 
				else { ?>
        	<img src="image/img04.jpg" alt="Default Profile Image">
    		<?php } ?>
			<h2><?php echo $name; ?></h2>
			<p><span class="glyphicon glyphicon-user"></span> <?php echo $f_user; ?></p>
	        <center><a href="sendMessage.php" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span>  Send Message</a></center>
	        <p></p>
	    </div>
<!--End Main profile card-->


<!-- Display Reviews and Ratings -->
<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
    <div class="panel-heading">Reviews & Ratings</div>
    <div class="panel-body">
        <?php
        // Retrieve reviews and ratings for the photographer
        $reviewsSql = "SELECT * FROM reviews WHERE photographer_username = '$f_user' ORDER BY user_username = '$username' DESC";
        $reviewsResult = $conn->query($reviewsSql);

        if ($reviewsResult && $reviewsResult->num_rows > 0) {
            while ($reviewRow = $reviewsResult->fetch_assoc()) {
                $userReview = $reviewRow["review_text"];
                $userRating = $reviewRow["rating"];
                $reviewId = $reviewRow["id"]; // Added for editing and deleting

                echo '<div class="review">';
                echo '<p><strong>User:</strong> ' . $reviewRow["user_username"] . '</p>';
                echo '<p><strong>Review:</strong> ' . $userReview . '</p>';
                echo '<p><strong>Rating:</strong> ' . $userRating . '/5</p>';

                // Check if the currently logged-in user is the same as the user who wrote the review
                if ($_SESSION["Username"] === $reviewRow["user_username"]) {
                    echo '<div class="review-actions">';
                    echo '<a href="edit_review.php?review_id=' . $reviewId . '" class="btn btn-sm btn-primary">Edit</a>';
                    echo '<a href="delete_review.php?review_id=' . $reviewId . '" class="btn btn-sm btn-danger">Delete</a>';
                    echo '</div>';
                }

                echo '</div>';
            }
        } else {
            echo "<p>No reviews available.</p>";
        }

        // Check if the user has already submitted a review
        $userHasReviewedSql = "SELECT * FROM reviews WHERE user_username = '$username' AND photographer_username = '$f_user'";
        $userHasReviewedResult = $conn->query($userHasReviewedSql);

        if ($userHasReviewedResult && $userHasReviewedResult->num_rows > 0) {
            echo '<p>You have already submitted a review and rating for this photographer.</p>';
        } else {
            // Display the Review & Rate Form
            echo '
            <div class="panel panel-primary">
                <div class="panel-heading">Submit a Review & Rating</div>
                <div class="panel-body">
                    <form method="post" action="submit_review.php">
                        <input type="hidden" name="photographer" value="' . $f_user . '">
                        <div class="form-group">
                            <label for="review">Review:</label>
                            <textarea class="form-control" name="review" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <select class="form-control" name="rating">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>';
        }
        ?>
    </div>
</div>
<!--End Display Review&Rate-->



	</div>
<!--End Column 1-->

<!--Column 2-->
	<div class="col-lg-7">

<!--Photographer Profile Details-->	
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-primary">
			  <div class="panel-heading"><h3>Photographer Profile Details</h3></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Skills</div>
			  <div class="panel-body"><h4><?php echo $skills; ?></h4></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Profile Summary</div>
			  <div class="panel-body"><h4><?php echo $profile_sum; ?></h4></div>
			</div>
			
		</div>
        
<!--End Photographer Profile Details-->


			<!-- Appointments Card -->
<div class="card" style="padding: 5px; margin-top: 20px;">
    <div class="card-body">
        <h5 class="card-title">Appointments</h5>
        <?php
        // Fetch pending appointments for the photographer
        $appointmentsSql = "SELECT * FROM appointments WHERE photographer = '$f_user' AND status = 'Pending' LIMIT 3";
        $appointmentsResult = $conn->query($appointmentsSql);

        if ($appointmentsResult && $appointmentsResult->num_rows > 0) {
            echo '<div class="appointment-table">';
            while ($appointmentRow = $appointmentsResult->fetch_assoc()) {
                $user = $appointmentRow["user"];
                $package = $appointmentRow["package"];
                $datetime = $appointmentRow["datetime"];
                $price = $appointmentRow["price"];
                $status = $appointmentRow["status"];
                ?>
                <div class="appointment-row">
                    <div class="appointment-cell">
                        <span class="cell-label">User:</span>
                        <?php echo $user; ?>
                    </div>
                    <div class="appointment-cell">
                        <span class="cell-label">Package:</span>
                        <?php echo $package; ?>
                    </div>
                    <div class="appointment-cell">
                        <span class="cell-label">Date/Time:</span>
                        <?php echo $datetime; ?>
                    </div>
                    <div class="appointment-cell">
                        <span class="cell-label">Price:</span>
                        <?php echo $price; ?>
                    </div>
                    <div class="appointment-cell">
                        <span class="cell-label">Status:</span>
                        <?php echo $status; ?>
                    </div>
                </div>
                <?php
            }
            echo '</div>'; // Close the appointment-table
        } else {
            echo "<p>No pending appointments.</p>";
        }
        ?>
    </div>
</div>
<!-- End Appointments Card -->
<!-- Packages Card -->
<div class="card" style="padding: 5px; margin-top: 20px;">
    <div class="card-body">
        <h5 class="card-title">Packages</h5>
        <?php
        // Fetch packages for the photographer
        $packagesSql = "SELECT * FROM packages WHERE username = '$f_user' LIMIT 3";
        $packagesResult = $conn->query($packagesSql);

        if ($packagesResult && $packagesResult->num_rows > 0) {
            $counter = 1;
            while ($packageRow = $packagesResult->fetch_assoc()) {
                $packageTitle = $packageRow["title"];
                $packagePrice = $packageRow["price"];
                $packageDetail = $packageRow["detail"];
                $hireButtonId = "hireButton" . $counter;
                ?>
                <div class="card package-card">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h6 class="card-title"><?php echo $packageTitle; ?></h6>
                        <p class="card-text">฿<?php echo $packagePrice; ?></p>
                        <p class="card-text"><?php echo $packageDetail; ?></p>
                        <form method="post" action="hire.php" onsubmit="return confirmPackage(this, '<?php echo $hireButtonId; ?>')">
                            <input type="hidden" name="photographer" value="<?php echo $f_user; ?>">
                            <input type="hidden" name="package" value="<?php echo $packageTitle; ?>">
                            <input type="hidden" name="price" value="<?php echo $packagePrice; ?>">
                            <input type="hidden" name="detail" value="<?php echo $packageDetail; ?>">
                            <button type="submit" name="hire" class="btn btn-warning btn-lg" id="<?php echo $hireButtonId; ?>" disabled>Hire</button>
                        </form>
                        <form method="post" action="sendMessage.php" target="_blank">
                            <input type="hidden" name="photographer" value="<?php echo $f_user; ?>">
                            <button type="submit" name="sendMessage" class="btn btn-success btn-sm" onclick="enableHireButton('<?php echo $hireButtonId; ?>')">You need to Send Message First</button>
                        </form>
                    </div>
                </div>
                <?php
                $counter++;
            }
        } else {
            echo "<p>No packages available.</p>";
        }
        ?>
    </div>
</div>
<!-- End Packages Card -->

<script>
    function enableHireButton(buttonId) {
        document.getElementById(buttonId).disabled = false;
    }

    function confirmPackage(form, buttonId) {
        return confirm('Confirm this package?');
    }
</script>

<!--Display Uploaded Images-->
<?php
            $sql = "SELECT * FROM images WHERE username='$f_user'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">';
                echo '<h3>Uploaded Images</h3>';
                echo '<div class="row">';
                while ($row = $result->fetch_assoc()) {
                    $imagePath = $row["filename"];
                    echo '<div class="col-lg-3">';
                    echo '<img src="' . $imagePath . '" class="img-thumbnail" alt="Uploaded Image">';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
            }
            ?>
            <!--End Display Uploaded Images-->
	</div>
	
<!--End Column 2-->
<!-- Column 3 -->
<div class="col-lg-2">
    


	<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Appointment Created</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Your appointment has been created successfully.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<!-- End Column 3 -->
</div>
</div>
<!--End main body-->



<!--Footer-->
<footer class="bg-dark p-2 text-center">
  <div class="container">
    <p class="text-white">All Right Reseved @Porto</p>
  </div>
</footer>
<!--End Footer-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>