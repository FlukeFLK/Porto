<?php
include('server.php');

// Check if the user is logged in
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
} else {
    $username = "";
    // Redirect to the login page or handle accordingly
}

if (isset($_GET["id"])) {
    $packageId = $_GET["id"];

    // Fetch the package details
    $packageSql = "SELECT * FROM packages WHERE id = '$packageId' AND username = '$username'";
    $packageResult = $conn->query($packageSql);

    if ($packageResult && $packageResult->num_rows > 0) {
        $packageRow = $packageResult->fetch_assoc();
        $packageTitle = $packageRow["title"];
        $packagePrice = $packageRow["price"];
        $packageDetail = $packageRow["detail"];

        // Render the form for editing the package
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Package</title>
            <!-- Add your CSS and JS files here -->
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
                                <a class="nav-link" href="book_show.php">ดูนัดหมาย</a>
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
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Edit Package</h5>
                                <form method="post" action="update_package.php?id=<?php echo $packageId; ?>">
                                    <div class="mb-3">
                                        <label for="package_title" class="form-label">Title:</label>
                                        <input type="text" class="form-control" id="package_title" name="package_title" value="<?php echo $packageTitle; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="package_price" class="form-label">Price:</label>
                                        <input type="number" class="form-control" id="package_price" name="package_price" value="<?php echo $packagePrice; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="package_detail" class="form-label">Detail:</label>
                                        <input type="form-control" class="form-control" id="package_detail" name="package_detail" value="<?php echo $packageDetail; ?>" required>
                                    </div>
                                    <button type="submit" name="updatePackage" class="btn btn-primary">Update Package</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End main body-->

            <!-- Add your JS files here -->
        </body>
        </html>
        <?php
    } else {
        echo "Invalid package ID or unauthorized access.";
    }
}
?>
