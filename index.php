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

if(isset($_POST["f_user"])){
	$_SESSION["f_user"]=$_POST["f_user"];
	header("location: viewPhotographer.php");
}

$sql = "SELECT * FROM photographer";
$result = $conn->query($sql);

if(isset($_POST["s_username"])){
	$t=$_POST["s_username"];
	$sql = "SELECT * FROM photographer WHERE username='$t'";
	$result = $conn->query($sql);
}

if(isset($_POST["s_name"])){
	$t=$_POST["s_name"];
	$sql = "SELECT * FROM photographer WHERE Name='$t'";
	$result = $conn->query($sql);
}

if(isset($_POST["s_email"])){
	$t=$_POST["s_email"];
	$sql = "SELECT * FROM photographer WHERE email='$t'";
	$result = $conn->query($sql);
}
// Check if a skill is selected
if (isset($_POST['s_skills'])) {
  $selectedSkill = $_POST['s_skills'];

  // Query to retrieve photographers with the selected skill
  $sql = "SELECT * FROM photographer WHERE skills = '$selectedSkill'";
} else {
  // Default query to retrieve all photographers
  $sql = "SELECT * FROM photographer";
}

// Execute the query
$result = $conn->query($sql);
// Get the selected skill from the form submission


// Construct the base SQL query to fetch photographers
$sql = "SELECT * FROM photographer";

// Check if a specific skill is selected
if (!empty($selectedSkill)) {
    // Add the skill condition to the SQL query
    $sql .= " WHERE skills = '$selectedSkill'";
}

// Execute the SQL query
$result = $conn->query($sql);

// Rest of the code to display photographer profiles...

// Rest of your code to display photographer profiles


 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Porto</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

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
            <a class="nav-link" href="loginReg.php">Login/Register</a>
        </li>
        

      </ul>
    </div>
  </div>
</nav>
<!--End Navbar menu-->



<!--Header and slider-->

<!--Header-->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images\jakob-owens-DQPP9rVLYGQ-unsplash.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption">
        <h5>หาช่างภาพใกล้ตัวคุณ</h5>
        <p></p>
        <p><a href="#" class="btn btn-warning mt-3">Learn More.</a></p>
        <p><a href="#" class="btn btn-outline-light mt-3">ติดต่อเรา</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images\miha-jan-strehovec-5XAtF-Syisk-unsplash.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption">
        <h5>สะดวก รวดเร็ว ง่าย</h5>
        <p></p>
        <p><a href="#" class="btn btn-warning mt-3">Learn More.</a></p>
        <p><a href="#" class="btn btn-outline-light mt-3">ติดต่อเรา</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images\william-bayreuther-hfk6xOjQlFk-unsplash (1).jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption">
        <h5>ได้งานที่คุณต้องการ</h5>
        <p></p>
        <p><a href="#" class="btn btn-warning bg-gradient mt-3">Learn More.</a></p>
        <p><a href="#" class="btn btn-outline-light mt-3">ติดต่อเรา</a></p>
        
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
  <script src="..\js\carousel.js"></script>
</div>

<!-- Column 1 - Photographer Profiles -->
<div class="col-lg-9">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $f_username = $row["username"];
                        $Name = $row["Name"];
                        $profile_image = $row["profile_image"];
                        $skills = $row["skills"];
                        ?>

                        <div class="col">
                            <div class="card h-100">
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

                                <img src="<?php echo $profileImageSrc; ?>" class="card-img-top rounded-circle" alt="Profile Image" style="width: 100px; height: 100px;">

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $f_username; ?></h5>
                                    <p class="card-text">
                                        <strong>Name:</strong> <?php echo $Name; ?><br>
                                        <strong>Skill:</strong> <?php echo $skills; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo "<p class='text-center'>No photographers found.</p>";
                }
                ?>
            </div>
        </div>
<!-- section -->

<section id="about" class="about section-padding">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-12 col-12">
        <div class="about-img">
          <img src="images\jakob-owens-DQPP9rVLYGQ-unsplash.jpg" alt="" class="img-fluid">
        </div>
      </div>
      <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
        <div class="about-text">
          <h2>พวกเรามีช่างภาพให้เลือกหลากหลาย</h2>
          <p></p>
          <a href="#" class="btn btn-warning">Learn More.</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- services section -->
<section id="services" class="services section-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-header text-center">
          <h2>ทำไมต้อง Porto</h2>
          <p>เริ่มจ้างงานช่างภาพง่ายๆ กับ Porto 📸</p>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-12 col-lg-4">
          <div class="card text-white text-center bg-dark pb-2">
            <div class="card-body">
              <i class="bi bi-person-check-fill"></i>
              <h3 class="card-title">ช่างภาพคุณภาพ</h3>
              <p class="lead">ช่างภาพผ่านการคัดเลือก และยืนยันตัวตน กับ Porto สามารถตรวจสอบได้</p>
              <button class="btn btn-warning bg-gradient text-dark">Read More</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
          <div class="card text-white text-center bg-dark pb-2">
            <div class="card-body">
              <i class="bi bi-shield-fill-check"></i>
              <h3 class="card-title">รับประกันการจ้างงาน</h3>
              <p class="lead">เงินของคุณจะได้รับความคุ้มครองตั้งแต่เริ่มทํางานไปจนถึงได้รับงาน</p>
              <button class="btn btn-warning bg-gradient text-dark">Read More</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
          <div class="card text-white text-center bg-dark pb-2">
            <div class="card-body">
              <i class="bi bi-file-text-fill"></i>
              <h3 class="card-title">มีบริการหลากหลาย</h3>
              <p class="lead">มีช่างภาพหลากหลายที่พร้อมให้บริการและหมวดหมู่ที่หลากหลาย</p>
              <button class="btn btn-warning bg-gradient text-dark">Read More</button>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>
<!-- team section -->

<section id="team" class="team section-padding">
  <div class="container">
   <div class="row">
      <div class="col-md-12">
        <div class="section-header text-center">
          <h2>ทีมงาน</h2>
          <p>ผู้ดูแลและพัฒนาแพลตฟอร์มหาช่างภาพ Porto </p>
        </div>
      </div>
    </div>

    <div class="row d-flex justify-content-center">
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card text-center">
          <div class="card-body">
            <img src="images\Pai.jpg" alt="" class="img-fluid rounded-circle">
            <h3 class="card-title py-2">Pai N.</h3>
            <p class="card-text">Co-founder, Marketing</p>

            <p class="socials">
              <i class="bi bi-facebook text-dark mx-1"></i>
              <i class="bi bi-instagram text-dark mx-1"></i>
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card text-center">
          <div class="card-body">
            <img src="images\Fluke.jpg" alt="" class="img-fluid rounded-circle">
            <h3 class="card-title py-2">Fluke P.</h3>
            <p class="card-text">Co-founder, Developer</p>

            <p class="socials">
              <i class="bi bi-facebook text-dark mx-1"></i>
              <i class="bi bi-instagram text-dark mx-1"></i>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- contact section -->

<section id="contact" class="contact section-padding">
  <div class="container">
   <div class="row">
      <div class="col-md-12">
        <div class="section-header text-center">
          <h2>ติดต่อเรา</h2>
          <p>ติดต่อเราได้ทันที </p>
        </div>
      </div>
    </div>

    <div class="row m-0">
      <div class="col-md-12 p-0 pt-4 pb-4">
        <form action="#" class="bg-light p-4.m-auto">
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <input type="text" class="form-control" required placeholder="Your Full name">
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <input type="email" class="form-control" required placeholder="Your Email">
              </div>
            </div>
            <div class="col md-12">
              <div class="mb-3">
                <textarea name="" rows="3" required class="form-control" placeholder="Your Text Here"></textarea>
              </div>
            </div>

            <button class="btn btn-warning btn-lg btn-block mt-3">Send.</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- footer -->

<footer class="bg-dark p-2 text-center">
  <div class="container">
    <p class="text-white">All Right Reseved @Porto</p>
  </div>
</footer>







  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>