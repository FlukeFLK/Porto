<?php
// Include server.php and start session
include('server.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_review"])) {
    $reviewId = $_POST["review_id"];
    $newReview = $_POST["new_review"];
    $newRating = intval($_POST["new_rating"]);
    $username = $_SESSION["Username"];

    // Update the review in the database
    $updateSql = "UPDATE reviews SET review_text = '$newReview', rating = '$newRating'
                  WHERE id = '$reviewId' AND user_username = '$username'";
    $conn->query($updateSql);

    // Redirect back to the photographer's profile page
    header("Location: viewPhotographer.php?f_user=$f_user");
} else {
    // Handle other HTTP methods (e.g., redirect to an error page)
    header("Location: error_page.php");
}

$conn->close();
?>
