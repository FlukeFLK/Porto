<?php
// Include server.php and start session
include('server.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["review_id"])) {
    $reviewId = $_GET["review_id"];
    $username = $_SESSION["Username"];

    // Fetch the review from the database
    $reviewSql = "SELECT * FROM reviews WHERE id = '$reviewId' AND user_username = '$username'";
    $reviewResult = $conn->query($reviewSql);

    if ($reviewResult && $reviewResult->num_rows > 0) {
        $reviewRow = $reviewResult->fetch_assoc();
        $reviewText = $reviewRow["review_text"];
        $rating = $reviewRow["rating"];
    } else {
        echo "Review not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Review</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
        <h2>Edit Review</h2>
        <form method="post" action="update_review.php">
            <input type="hidden" name="review_id" value="<?php echo $reviewId; ?>">

            <div class="mb-3">
                <label for="new_review" class="form-label">Review:</label>
                <textarea class="form-control" name="new_review"><?php echo $reviewText; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="new_rating" class="form-label">Rating:</label>
                <select class="form-select" name="new_rating">
                    <option value="1" <?php if ($rating == 1) echo "selected"; ?>>1</option>
                    <option value="2" <?php if ($rating == 2) echo "selected"; ?>>2</option>
                    <option value="3" <?php if ($rating == 3) echo "selected"; ?>>3</option>
                    <option value="4" <?php if ($rating == 4) echo "selected"; ?>>4</option>
                    <option value="5" <?php if ($rating == 5) echo "selected"; ?>>5</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="update_review">Update Review</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
