<?php
include '../../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $duration_days = $_POST['duration_days'];

    $includes_transport = isset($_POST['includes_transport']) ? 1 : 0;
    $includes_meals = isset($_POST['includes_meals']) ? 1 : 0;
    $includes_stay = isset($_POST['includes_stay']) ? 1 : 0;

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $package['image'];
    }

    $stmt = $conn->prepare("UPDATE packages SET title = ?, details = ?, price = ?, image = ?, includes_transport = ?, includes_meals = ?, includes_stay = ?, duration_days = ? WHERE id = ?");
    $stmt->bind_param("ssdssiiii", $title, $details, $price, $image, $includes_transport, $includes_meals, $includes_stay, $duration_days, $id);
    $stmt->execute();

    header("Location: packages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Package</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Edit Package</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($package['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Details</label>
            <textarea name="details" class="form-control" required><?= htmlspecialchars($package['details']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Price (₱)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($package['price']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Duration (in Days)</label>
            <input type="number" name="duration_days" class="form-control" value="<?= htmlspecialchars($package['duration_days']) ?>" required>
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="includes_transport" id="includes_transport" class="form-check-input" <?= $package['includes_transport'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="includes_transport">Includes Transportation</label>
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="includes_meals" id="includes_meals" class="form-check-input" <?= $package['includes_meals'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="includes_meals">Includes Meals</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="includes_stay" id="includes_stay" class="form-check-input" <?= $package['includes_stay'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="includes_stay">Includes Accommodation</label>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            <?php if (!empty($package['image'])): ?>
                <img src="../uploads/<?= htmlspecialchars($package['image']) ?>" alt="Image" width="150" class="img-thumbnail">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>New Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="packages.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
