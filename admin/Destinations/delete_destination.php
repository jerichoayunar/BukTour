<?php
include '../../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional: delete image file
    $result = $conn->query("SELECT image_url FROM destinations WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $image_path = "../uploads/" . $row['image_url'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $conn->query("DELETE FROM destinations WHERE id = $id");
}

header("Location: destinations.php");
exit();
