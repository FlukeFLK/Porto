<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
}
else{
	$username="";
	//header("location: index.php");
}


$sql = "SELECT * FROM user WHERE username='$username'";
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
        }
} else {
    echo "0 results";
}


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>User profile</title>
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
            <li><a class="dropdown-item" href="allPhotographer2.php">หาช่างภาพมือใหม่ 🔥</a></li>
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

<div style="padding: 1% 3% 1% 3%;">
    <div class="row">

        <!--Column 1-->
        <div class="col-lg-3 mx-auto">

            <!--Main profile card-->
            <div class="card mx-auto" style="padding: 20px 20px 5px 20px; margin-top: 20px;">
                <p></p>
                <img src="image/img04.jpg">
                <h2><?php echo $name; ?></h2>
                <p><span class="glyphicon glyphicon-user"></span> <?php echo $username; ?></p>
                <ul class="list-group">
                    <a href="editUser.php" class="list-group-item list-group-item-warning">Edit Profile</a>
                    <a href="message.php" class="list-group-item list-group-item-warning">Messages</a>
                    <a href="logout.php" class="list-group-item list-group-item-danger">Logout</a>
                </ul>
            </div>
            <!--End Main profile card-->

            <!--Contact Information-->
            <div class="card mx-auto" style="padding: 20px 20px 5px 20px; margin-top: 20px;">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4>Contact Information</h4>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">Email</div>
                    <div class="panel-body"><?php echo $email; ?></div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">Mobile</div>
                    <div class="panel-body"><?php echo $contactNo; ?></div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">Address</div>
                    <div class="panel-body"><?php echo $address; ?></div>
                </div>
            </div>
        </div>
        <!--End Column 1-->
        <!--Column 2-->
<div class="col-lg-9 mx-auto">

<!--Column 2-->
<div class="col-lg-9 mx-auto">
    <!-- Appointments Card -->
    <div class="card" style="padding: 20px; margin-top: 20px;">
        <div class="card-body">
            <h5 class="card-title">Appointments</h5>
            <?php
            // Fetch the total number of appointments for the user
            $totalAppointmentsSql = "SELECT COUNT(*) AS total FROM appointments WHERE user = '$username'";
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

            // Fetch the appointments for the current page, ordered by datetime (newest to oldest)
            $appointmentsSql = "SELECT * FROM appointments WHERE user = '$username' ORDER BY datetime DESC LIMIT $offset, $appointmentsPerPage";
            $appointmentsResult = $conn->query($appointmentsSql);

            if ($appointmentsResult && $appointmentsResult->num_rows > 0) {
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Photographer</th>';
                echo '<th>Package</th>';
                echo '<th>Date/Time</th>';
                echo '<th>Price</th>';
                echo '<th>Status</th>';
                echo '<th>Action</th>'; // Add a new column for the chat and pay buttons
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($appointmentRow = $appointmentsResult->fetch_assoc()) {
                    $photographer = $appointmentRow["photographer"];
                    $package = $appointmentRow["package"];
                    $datetime = $appointmentRow["datetime"];
                    $price = $appointmentRow["price"];
                    $status = $appointmentRow["status"];
                
                    echo '<tr>';
                    echo '<td>' . $photographer . '</td>';
                    echo '<td>' . $package . '</td>';
                    echo '<td>' . $datetime . '</td>';
                    echo '<td>' . $price . '</td>';
                    echo '<td class="status">' . $status . '</td>';
                    echo '<td>';
                    echo '<form method="post" action="sendMessageUser.php?msgTo=' . $photographer . '">';
                    echo '<button type="submit" name="chat" class="btn btn-info">Chat</button>';
                    echo '</form>';
                
                    if ($status == 'Finished') {
                        echo '<div class="pay-wrapper">';
                        echo '<button type="button" name="pay" class="btn btn-success" onclick="showPromptPayQR(this, \'' . $price . '\', \'' . $appointmentRow['id'] . '\')">Pay</button>';
                        echo '<img src="" class="promptpay-qr">';
                        echo '</div>';
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
                    echo '"><a class="page-link" href="userProfile.php?page=' . $i . '">' . $i . '</a></li>';
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
</div>
<!--End Column 2-->
<script>
function showPromptPayQR(button, price, appointmentId) {
    var promptPayUrl = 'https://promptpay.io/0853721798/' + price + '.png';
    var qrCodeImg = button.parentNode.querySelector('.promptpay-qr');
    qrCodeImg.src = promptPayUrl;

    // Simulate the payment confirmation
    setTimeout(function() {
        // Send an AJAX request to update the status
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'updateStatus.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Update the status in the UI
                button.parentNode.querySelector('.status').textContent = 'Success!';
                // Reload the page after the status is updated
                location.reload();
            }
        };
        xhr.send('appointmentId=' + encodeURIComponent(appointmentId));
    }, 3000); // Simulating a delay of 3 seconds for payment confirmation
}
</script>





</div>
<!--End Column 2-->


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
</body>
</html>