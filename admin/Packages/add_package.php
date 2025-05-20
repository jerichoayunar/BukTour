<?php
include '../../includes/db.php'; // Include your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $duration_days = $_POST['duration_days'];

    // Convert checkboxes to boolean (1 or 0)
    $includes_transport = isset($_POST['includes_transport']) ? 1 : 0;
    $includes_meals = isset($_POST['includes_meals']) ? 1 : 0;
    $includes_stay = isset($_POST['includes_stay']) ? 1 : 0;

    // Handle image upload
    $image = $_FILES['image']['name'];
    if (!empty($image)) {
        $target = "../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = null;
    }

    $stmt = $conn->prepare("INSERT INTO packages (title, details, price, image, includes_transport, includes_meals, includes_stay, duration_days) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssiii", $title, $details, $price, $image, $includes_transport, $includes_meals, $includes_stay, $duration_days);
    $stmt->execute();

    header("Location: packages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Package</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Add New Package</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="details" class="form-label">Details</label>
            <textarea name="details" id="details" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (₱)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="duration_days" class="form-label">Duration (in Days)</label>
            <input type="number" name="duration_days" id="duration_days" class="form-control" required>
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="includes_transport" id="includes_transport" class="form-check-input">
            <label class="form-check-label" for="includes_transport">Includes Transportation</label>
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="includes_meals" id="includes_meals" class="form-check-input">
            <label class="form-check-label" for="includes_meals">Includes Meals</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="includes_stay" id="includes_stay" class="form-check-input">
            <label class="form-check-label" for="includes_stay">Includes Accommodation</label>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Package Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Package</button>
        <a href="packages.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
