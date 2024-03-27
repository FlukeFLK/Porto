<?php
include('server.php');

// Check if the user is logged in
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
    if ($_SESSION["Usertype"] == 1) {
        $linkPro = "photographerProfile.php";
        $linkEditPro = "editPhotographer.php";
    } else {
        $linkPro = "userProfile.php";
        $linkEditPro = "editUser.php";
    }
} else {
    $username = "";
    //header("location: index.php");
}

if (isset($_SESSION["msgRcv"])) {
    $msgRcv = $_SESSION["msgRcv"];
}

// Get the value of $msgTo from the query parameter
if (isset($_GET['msgTo'])) {
    $msgTo = $_GET['msgTo'];
} else {
    $msgTo = "";
}

if (isset($_POST["send"])) {
    $msgTo = $_POST["msgTo"];
    $msgBody = $_POST["msgBody"];
    $sql = "INSERT INTO message (sender, receiver, msg) VALUES ('$username', '$msgTo', '$msgBody')";
    $result = $conn->query($sql);
    if ($result == true) {
        header("location: message.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profilestyle.css">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">

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

<div style="padding: 1% 3% 1% 3%;">

<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h2>Write Message</h2>
                </div>

                <form id="registrationForm" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label">To</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="msgTo" value="<?php echo $msgTo; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Message Body</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="12" name="msgBody"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <!-- Do NOT use name="submit" or id="submit" for the Submit button -->
                        <button type="submit" name="send" class="btn btn-info btn-lg">Send Message</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>


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
<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>

<script>
$(document).ready(function() {
    $('#registrationForm').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            msgTo: {
                validators: {
                    notEmpty: {
                        message: 'This is required and cannot be empty'
                    }
                }
            },
            msgBody: {
                validators: {
                    notEmpty: {
                        message: 'This is required and cannot be empty'
                    }
                }
            }
            
        }
    });
});
</script>

</body>
</html>