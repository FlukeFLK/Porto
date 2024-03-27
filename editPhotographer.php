<?php
include('server.php');

if(isset($_SESSION["Username"])){
	$username = $_SESSION["Username"];
}
else{
	$username = "";
}

$sql = "SELECT * FROM photographer WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$name = $row["Name"];
		$email = $row["email"];
		$contactNo = $row["contact_no"];
		$gender = $row["gender"];
		$birthdate = $row["birthdate"];
		$address = $row["address"];
		$skills = $row["skills"];
		$profile_sum = $row["profile_sum"];
		$experience = $row["experience"];
		$profile_image = $row["profile_image"];
	}
} else {
    echo "0 results";
}
$sql = "SELECT skills FROM photographer WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selectedSkills = explode(',', $row['skills']);
} else {
    $selectedSkills = array();
}

// Define an array of available skills
$availableSkills = array("Portrait", "Video", "Review", "Event Coverage");

if(isset($_POST["editPhotographer"])){
	// Handle other form fields
    $name = $_POST["name"];
    $email = $_POST["email"];
    $contactNo = $_POST["contactNo"];
    $gender = $_POST["gender"];
    $birthdate = $_POST["birthdate"];
    $address = $_POST["address"];
    $profile_sum =$_POST["profile_sum"];
    $experience =$_POST["experience"];
	// Upload profile image
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
		$profile_image = $target_file;
	}

	$sql = "UPDATE photographer SET Name = '$name', email = '$email', contact_no = '$contactNo', address = '$address', gender = '$gender', profile_sum = '$profile_sum', experience = '$experience', birthdate = '$birthdate', skills = '$skills', profile_image = '$profile_image' WHERE username = '$username'";

	$result = $conn->query($sql);

	if($result == true){
		header("location: photographerProfile.php");
	}    
}
if (isset($_POST["editPhotographer"])) {
    // Process other form fields

    $selectedSkills = $_POST["skills"]; // Get the selected skills from the form

    // Convert the selected skills into a comma-separated string
    $skillsString = implode(",", $selectedSkills);

    // Update the skills field in the database
    $sql = "UPDATE photographer SET skills='$skillsString' WHERE username='$username'";
    $result = $conn->query($sql);

    // Rest of the code for processing other form fields and redirecting

    if ($result === true) {
        header("location: photographerProfile.php");
    }
    
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Photographer Profile</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">
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
<!--main body-->
<div style="padding:5% 0% 0% 0%;">
<div class="row">
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h2>Edit Profile</h2>
                </div>
                <form id="registrationForm" method="post" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                            <label class="col-sm-4 control-label">Profile Image</label>
                            <div class="col-sm-5">
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Email address</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Contact no.</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="contactNo" value="<?php echo $contactNo; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Gender</label>
                    <div class="col-sm-5">
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender"
                                <?php if (isset($gender) && $gender=="male") echo "checked";?>
                                 value="male" /> Male
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender"
                                <?php if (isset($gender) && $gender=="female") echo "checked";?>
                                 value="female" /> Female
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender"
                                <?php if (isset($gender) && $gender=="other") echo "checked";?>
                                 value="other" /> Other
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Date of birth</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="birthdate" placeholder="YYYY/MM/DD" value="<?php echo $birthdate; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Address</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" />
                    </div>
                </div>


                <div class="form-group">
    <label class="col-sm-4 control-label">Skills</label>
    <div class="col-sm-5">
        <?php foreach ($availableSkills as $skill) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="skills[]" value="<?php echo $skill; ?>" <?php if (in_array($skill, $selectedSkills)) echo 'checked'; ?>>
                <label class="form-check-label"><?php echo $skill; ?></label>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .form-check {
        margin-bottom: 10px;
    }
</style>




                <div class="form-group">
                    <label class="col-sm-4 control-label">Profile Summery</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="profile_sum" value="<?php echo $profile_sum; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Experience</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="experience" value="<?php echo $experience; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <!-- Do NOT use name="submit" or id="submit" for the Submit button -->
                        <button type="submit" name="editPhotographer" class="btn btn-warning btn-lg">Save changes</button>
                    </div>
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
<!--End Footer-->


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
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required and cannot be empty'
                    }
                }
            },
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The username can only consist of alphabetical and number'
                    },
                    different: {
                        field: 'password',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The email address is not a valid'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The password must have at least 6 characters'
                    }
                }
            },
            repassword: {
                validators: {
                    notEmpty: {
                        message: 'The password confirmation is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password  is not matched'
                    }
                }
            },
            contactNo: {
                validators: {
                    notEmpty: {
                        message: 'The contact number is required'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The number is not valid'
                    }
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'The gender is required'
                    }
                }
            },
            birthdate: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date of birth is not valid'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'The address is required'
                    }
                }
            },
            usertype: {
                validators: {
                    notEmpty: {
                        message: 'The usertype is required'
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>