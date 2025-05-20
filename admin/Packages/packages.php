<?php
include '../../includes/db.php'; 

$search = $_GET['search'] ?? '';

// Search only by title
$sql = "SELECT * FROM packages";
if (!empty($search)) {
    $searchSafe = $conn->real_escape_string($search);
    $sql .= " WHERE title LIKE '%$searchSafe%'";
}
$sql .= " ORDER BY title ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Manage Packages</title>
<link rel="stylesheet" href="styles.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
.dashboard {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex-grow: 1;
    background-color: #f9f9f9;
     margin-left: 250px;      /* Same as sidebar width */
    padding: 20px;
}

.table img {
    width: 100px;
    border-radius: 5px;
    object-fit: cover;
}

.btn {
    margin-right: 5px;
    font-size: 0.9rem;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.85rem;
}

.check-icon {
    color: green;
    font-size: 1.2rem;
}

.cross-icon {
    color: red;
    font-size: 1.2rem;
}

td.details-cell {
    max-width: 300px;
    vertical-align: top;
    padding: 8px;
}

.desc-wrapper {
    display: block;
    max-height: 4.8em;
    overflow: hidden;
    word-break: break-word;
    white-space: normal;
    font-size: 0.9rem;
    color: #444;
}

td.details-cell.expanded .desc-wrapper {
    max-height: none;
    overflow: visible;
}

.toggle-details {
    color: #007bff;
    cursor: pointer;
    font-size: 0.9rem;
    user-select: none;
    margin-top: 4px;
    display: inline-block;
}

/* Filter form styling to match bookings */
.form-label {
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.filter-form .col-md-3,
.filter-form .col-md-6 {
    padding-right: 1rem;
}

.btn, .form-select, .form-control {
    font-size: 0.9rem;
}

</style>
</head>

<body>
<div class="dashboard">
    <!-- Sidebar -->
    <?php include '../sidebar.php'; ?>

    <div class="main-content">

    <!-- top bar -->
        <?php include '../topbar.php'; ?>

        <div class="container mt-4">
            <h2 class="mb-3">Manage Packages</h2>
            <a href="add_package.php" class="btn btn-primary mb-3">➕ Add New Package</a>

            <!-- Search by Package Title -->
            <form method="GET" class="row g-3 align-items-end mb-3 filter-form">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search by Package Title</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Enter title..." value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="col-md-6 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Search</button>
                    <a href="packages.php" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 10%;">Title</th>
                            <th style="width: 25%;">Details</th>
                            <th style="width: 10%;">Image</th>
                            <th style="width: 7%;">Price</th>
                            <th style="width: 8%;">Duration</th>
                            <th style="width: 5%;">Transport</th>
                            <th style="width: 5%;">Meals</th>
                            <th style="width: 5%;">Stay</th>
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()):
                            $details = htmlspecialchars($row['details']);
                            $needsToggle = strlen($details) > 150;
                        ?>
                        <tr>
                            <td><?= (int)$row['id'] ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td class="details-cell">
                                <div class="desc-wrapper" title="<?= $details ?>">
                                    <?= nl2br($details) ?>
                                </div>
                                <?php if ($needsToggle): ?>
                                    <span class="toggle-details">Show more</span>
                                <?php endif; ?>
                            </td>
                            <td><img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="Package Image" /></td>
                            <td>₱<?= number_format($row['price'], 2) ?></td>
                            <td><?= (int)$row['duration_days'] ?> days</td>
                            <td class="text-center">
                                <?= $row['includes_transport'] ? '<span class="check-icon">✔️</span>' : '<span class="cross-icon">❌</span>' ?>
                            </td>
                            <td class="text-center">
                                <?= $row['includes_meals'] ? '<span class="check-icon">✔️</span>' : '<span class="cross-icon">❌</span>' ?>
                            </td>
                            <td class="text-center">
                                <?= $row['includes_stay'] ? '<span class="check-icon">✔️</span>' : '<span class="cross-icon">❌</span>' ?>
                            </td>
                            <td>
                                <a href="edit_package.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-warning w-100 mb-1">✏️ Edit</a>
                                <a href="delete_package.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-danger w-100" onclick="return confirm('Delete this destination?');">🗑️ Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.toggle-details').click(function(){
        const $toggle = $(this);
        const $cell = $toggle.closest('td.details-cell');
        const $descWrapper = $cell.find('.desc-wrapper');

        if ($cell.hasClass('expanded')) {
            $cell.removeClass('expanded');
            $toggle.text('Show more');
        } else {
            $cell.addClass('expanded');
            $toggle.text('Show less');
        }
    });
});
</script>

</body>
</html>
