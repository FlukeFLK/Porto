<?php
include('server.php');

if (isset($_POST['image_id'])) {
    $imageId = $_POST['image_id'];

    // Retrieve image information from the database
    $sql = "SELECT * FROM images WHERE id='$imageId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row["filename"];

        // Delete the file from the server
        if (unlink($imagePath)) {
            // Delete the image record from the database
            $deleteSql = "DELETE FROM images WHERE id='$imageId'";
            $deleteResult = $conn->query($deleteSql);

            if ($deleteResult === true) {
                // Redirect back to the photographer profile page
                header("location: photographerProfile.php");
                exit();
            } else {
                echo "Error deleting image from the database: " . $conn->error;
            }
        } else {
            echo "Error deleting image file from the server.";
        }
    } else {
        echo "Image not found.";
    }
} else {
    echo "Invalid request.";
}
?>
