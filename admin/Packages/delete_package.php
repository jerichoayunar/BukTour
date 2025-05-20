<?php
include '../../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, get the image file path to delete it from the server
    $stmt = $conn->prepare("SELECT image FROM packages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();

    // Delete the package
    $stmt = $conn->prepare("DELETE FROM packages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete the image file from the server
    unlink("../uploads/" . $package['image']);

    header("Location: packages.php");
    exit();
}
