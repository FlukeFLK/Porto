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

$sql = "SELECT * FROM message WHERE receiver='$username' ORDER BY timestamp DESC";
$result = $conn->query($sql);
$f=0;

if(isset($_POST["sr"])){
	$t=$_POST["sr"];
	$sql = "SELECT * FROM photographer WHERE username='$t'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$_SESSION["f_user"]=$t;
		header("location: viewPhotographer.php");
	} else {
	    $sql = "SELECT * FROM user WHERE username='$t'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$_SESSION["e_user"]=$t;
			header("location: viewUser.php");
		}
	}
}

if(isset($_POST["s_inbox"])){
	$t=$_POST["s_inbox"];
	$sql = "SELECT * FROM message WHERE receiver='$username' and sender='$t' ORDER BY timestamp DESC";
	$result = $conn->query($sql);
	$f=0;
}

if(isset($_POST["s_sm"])){
	$t=$_POST["s_sm"];
	$sql = "SELECT * FROM message WHERE sender='$username' and receiver='$t' ORDER BY timestamp DESC";
	$result = $conn->query($sql);
	$f=1;
}

if(isset($_POST["inbox"])){
	$sql = "SELECT * FROM message WHERE receiver='$username' ORDER BY timestamp DESC";
	$result = $conn->query($sql);
	$f=0;
}

if(isset($_POST["sm"])){
	$sql = "SELECT * FROM message WHERE sender='$username' ORDER BY timestamp DESC";
	$result = $conn->query($sql);
	$f=1;
}

if(isset($_POST["rep"])){
	$_SESSION["msgRcv"]=$_POST["rep"];
	header("location: sendMessage.php");
}




 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Message</title>
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
        <li class="nav-item">
          <a class="nav-link" href="book_show.php">ดูนัดหมาย</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="chat.php">แชท</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="404.php" style="color: black;">Good Morning ⛅ <?php echo $username; ?>!</a>
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
	<div class="col-lg-9">

<!-- Chat Messages -->
<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-success">
			  <div class="panel-heading"><h3>All Messages</h3></div>
			  <div class="panel-body"><h4>
                  <table style="width:100%">
                      <tr>
                          <td>Message</td>
                          <td>Username</td>
                      </tr>
                      <?php
                      	if ($result->num_rows > 0) {
						    // output data of each row
						    while($row = $result->fetch_assoc()) {
						        $sender=$row["sender"];
						        $receiver=$row["receiver"];
						        $msg=$row["msg"];
						        $timestamp=$row["timestamp"];

						        if ($f==0) {
						        	$sr=$sender;
						        }else{
						        	$sr=$receiver;
						        }


                                echo '
                                <form action="message.php" method="post">
                                <input type="hidden" name="sr" value="'.$sr.'">
                                    <tr>
                                    <td>'.$msg.'</td>
                                    <td><input type="submit" class="btn btn-link btn-lg" value="'.$sr.'"></td>
                                    </form>
                                    <form action="message.php" method="post">
                                    <input type="hidden" name="rep" value="'.$sr.'">
                                    <td><input type="submit" class="btn btn-link btn-lg" value="Reply"></td>
                                    <td>'.$timestamp.'</td>
                                    </tr>
                                </form>
                                ';

                                }
                        } else {
                            echo "<tr></tr><tr><td></td><td>Nothing to show</td></tr>";
                        }

                       ?>
                     </table>
              </h4></div>
			</div>
			<p></p>
		</div>
<!-- End Chat Messages -->


	</div>
<!--End Column 1-->


<!--Column 2-->
	<div class="col-lg-3">

<!--Main profile card-->
		<div class="card" style="padding: 20px; margin-top: 20px;">
			<p></p>
			<form action="message.php" method="post">
				<div class="form-group">
				  <input type="text" class="form-control" name="s_inbox">
				  <center><button type="submit" class="btn btn-info">Search Inbox</button></center>
				</div>
	        </form>

	        <form action="message.php" method="post" style="margin-bottom: 10px;">
				<div class="form-group">
				  <input type="text" class="form-control" name="s_sm">
				  <center><button type="submit" class="btn btn-info">Search Sent Messages</button></center>
				</div>
	        </form>

	        <form action="message.php" method="post" style="margin-bottom: 10px;">
				<div class="form-group">
				  <center><button type="submit" name="inbox" class="btn btn-warning">Inbox Messages</button></center>
				</div>
	        </form>

	        <form action="message.php" method="post">
				<div class="form-group">
				  <center><button type="submit" name="sm" class="btn btn-warning">Sent Messages</button></center>
				</div>
	        </form>

	        <p></p>
	    </div>
<!--End Main profile card-->

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