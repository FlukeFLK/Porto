<?php
session_start();


// Create connection
$conn = new mysqli("localhost","root","","porto_db");
// For University Database
// $conn = new mysqli("localhost","sudigite_3126","085031026","sudigite_3126");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/*$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo " " . $row["username"]. " " . $row["password"]. " " . $row["Name"]. "<br>";
    }
} else {
    echo "0 results";
}*/

$username=$name=$email=$password=$contactNo=$birthdate=$address="";

if(isset($_POST["register"])){
	$username=test_input($_POST["username"]);
	$name=test_input($_POST["name"]);
	$email=test_input($_POST["email"]);
	$password=test_input($_POST["password"]);
	$repassword=test_input($_POST["repassword"]);
	$contactNo=test_input($_POST["contactNo"]);
	$gender=test_input($_POST["gender"]);
	$birthdate=test_input($_POST["birthdate"]);
	$address=test_input($_POST["address"]);
	$usertype=test_input($_POST["usertype"]);

	if ($usertype=="photographer") {
		$sql = "SELECT * FROM photographer,user WHERE photographer.username = '$username' OR user.username = '$username'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$_SESSION["errorMsg2"]="The username is already taken";
		}
		else{
			unset($_SESSION["errorMsg2"]);
			$sql = "INSERT INTO photographer (username, password, Name, email, contact_no, address, gender, birthdate) VALUES ('$username', '$password', '$name','$email','$contactNo','$address','$gender','$birthdate')";
			$result = $conn->query($sql);
			if($result==true){
				$_SESSION["Username"]=$username;
				$_SESSION["Usertype"]=1;
				header("location: photographerProfile.php");
			}

		}
	}
	else{
		$sql = "SELECT * FROM photographer,user WHERE photographer.username = '$username' OR user.username = '$username'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$_SESSION["errorMsg2"]="The username is already taken";
		}
		else{
			unset($_SESSION["errorMsg2"]);
			$sql = "INSERT INTO user (username, password, Name, email, contact_no, address, gender, birthdate) VALUES ('$username', '$password', '$name','$email','$contactNo','$address','$gender','$birthdate')";
			$result = $conn->query($sql);
			if($result==true){
				$_SESSION["Username"]=$username;
				$_SESSION["Usertype"]=2;
				header("location: userProfile.php");
			}

		}
	}
}

if(isset($_POST["login"])){
	session_unset();
	$username=test_input($_POST["username"]);
	$password=test_input($_POST["password"]);
	$usertype=test_input($_POST["usertype"]);

	if ($usertype=="photographer") {
		$sql = "SELECT * FROM photographer WHERE username = '$username' AND password = '$password'";
		$result = $conn->query($sql);
		if($result->num_rows == 1){
			$_SESSION["Username"]=$username;
			$_SESSION["Usertype"]=1;
			unset($_SESSION["errorMsg"]);
			header("location: photographerProfile.php");
		}
		else{
			$_SESSION["errorMsg"]="username/password is incorrect";
		}
	}
	else{
		$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
		$result = $conn->query($sql);
		if($result->num_rows == 1){
			$_SESSION["Username"]=$username;
			$_SESSION["Usertype"]=2;
			unset($_SESSION["errorMsg"]);
			header("location: userProfile.php");
		}
		else{
			$_SESSION["errorMsg"]="username/password is incorrect";
		}
	}
	
}


if(isset($_SESSION["errorMsg"])){
	$errorMsg=$_SESSION["errorMsg"];
	unset($_SESSION["errorMsg"]);
}
else{
	$errorMsg="";
}

if(isset($_SESSION["errorMsg2"])){
	$errorMsg2=$_SESSION["errorMsg2"];
	unset($_SESSION["errorMsg2"]);
}
else{
	$errorMsg2="";
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//$conn->close();
?>