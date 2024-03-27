<?php
// Include server.php and start session
include('server.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["review_id"])) {
    $reviewId = $_GET["review_id"];
    $username = $_SESSION["Username"];

    // Delete the review from the database
    $deleteSql = "DELETE FROM reviews WHERE id = '$reviewId' AND user_username = '$username'";
    $conn->query($deleteSql);

    // Redirect back to the photographer's profile page
    header("Location: viewPhotographer.php?f_user=$f_user");
} else {
    // Handle other HTTP methods (e.g., redirect to an error page)
    header("Location: error_page.php");
}

$conn->close();
?>
