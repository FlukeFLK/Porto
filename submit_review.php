<?php
session_start();
include('server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $photographer = $_POST["photographer"];
    $user = $_SESSION["Username"];
    $review = $_POST["review"];
    $rating = intval($_POST["rating"]);

    // Perform validation
    if (empty($photographer) || empty($user) || empty($review) || $rating < 1 || $rating > 5) {
        // Handle validation error (e.g., redirect to an error page)
        header("Location: error_page.php");
        exit();
    }

    // Insert review and rating into the database
    $insertSql = "INSERT INTO reviews (photographer_username, user_username, review_text, rating)
                  VALUES ('$photographer', '$user', '$review', $rating)";

    if ($conn->query($insertSql) === TRUE) {
        // Review and rating submitted successfully
        $_SESSION["review_success"] = true;
        header("Location: viewPhotographer.php?f_user=$photographer");
    } else {
        // Handle database error (e.g., redirect to an error page)
        header("Location: error_page.php");
    }
} else {
    // Handle other HTTP methods (e.g., redirect to an error page)
    header("Location: error_page.php");
}

$conn->close();
?>
