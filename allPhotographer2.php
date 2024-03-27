<?php
include('server.php');

if(isset($_SESSION["Username"])){
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

if(isset($_POST["f_user"])){
    $_SESSION["f_user"] = $_POST["f_user"];
    header("location: viewPhotographer.php");
}

$sql = "SELECT * FROM photographer";
$result = $conn->query($sql);

if(isset($_POST["s_username"])){
    $t = $_POST["s_username"];
    $sql = "SELECT * FROM photographer WHERE username='$t'";
    $result = $conn->query($sql);
}

if(isset($_POST["s_name"])){
    $t = $_POST["s_name"];
    $sql = "SELECT * FROM photographer WHERE Name='$t'";
    $result = $conn->query($sql);
}

if(isset($_POST["s_email"])){
    $t = $_POST["s_email"];
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

// Fetch photographers with price package less than ฿100
$sql = "SELECT * FROM photographer WHERE username IN (
    SELECT username FROM packages WHERE price < 100
)";
$result = $conn->query($sql);
?>




<!DOCTYPE html>
<html>
<head>
	<title>All Photographer</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
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
          <a class="nav-link" href="userProfile.php">หน้าโปรไฟล์</a>
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


<!-- Main body -->
<div class="container py-3" style="margin-top: 80px;">
    <div class="row">

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
                                <div class="card-footer">
                                    <!-- Display uploaded images -->
                                    <?php
                                    $imageSql = "SELECT * FROM images WHERE username='$f_username' ORDER BY RAND() LIMIT 6";
                                    $imageResult = $conn->query($imageSql);
                                    if ($imageResult->num_rows > 0) {
                                        echo '<h6 class="mb-3">Example Images:</h6>';
                                        echo '<div class="row row-cols-2 row-cols-md-3 g-2">';
                                        while ($imageRow = $imageResult->fetch_assoc()) {
                                            $imagePath = $imageRow["filename"];
                                            echo '<div class="col">';
                                            echo '<img src="' . $imagePath . '" class="img-thumbnail" alt="Uploaded Image">';
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                    <!-- End Display uploaded images -->
                                    <form action="allPhotographer.php" method="post" class="text-center mt-3">
                                        <input type="hidden" name="f_user" value="<?php echo $f_username; ?>">
                                        <button type="submit" class="btn btn-warning">View Profile</button>
                                    </form>
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
        <!-- End Column 1 -->

        <!-- Column 2 - Search Skills -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Search Profiles</h5>
                    <form action="allPhotographer2.php" method="post">
                        <div class="mb-3">
                            <label for="searchSkills" class="form-label">Search by Skills</label>
                            <div class="d-grid gap-2">
                                <?php
                                $selectedSkill = isset($_POST['s_skills']) ? $_POST['s_skills'] : '';

                                // Fetch skills from the database
                                $skillsSql = "SELECT DISTINCT skills FROM photographer";
                                $skillsResult = $conn->query($skillsSql);

                                echo '
                                <button type="submit" class="btn btn-warning' . ($selectedSkill === '' ? ' active' : '') . '" name="s_skills" value="">All</button>
                                ';

                                if ($skillsResult && $skillsResult->num_rows > 0) {
                                    while ($skillsRow = $skillsResult->fetch_assoc()) {
                                        $skill = $skillsRow["skills"];
                                        $isActive = $selectedSkill === $skill ? ' active' : '';
                                        echo '
                                        <button type="submit" class="btn btn-warning' . $isActive . '" name="s_skills" value="' . $skill . '">' . $skill . '</button>
                                        ';
                                    }
                                } else {
                                    echo '
                                    <button type="submit" class="btn btn-info" disabled>No skills available</button>
                                    ';
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Column 2 -->

    </div>
</div>
<!-- End main body -->








    </div>
</div>
<!-- End main body -->






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