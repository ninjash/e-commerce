<?php
require 'db_connect.php';
require '../classes/Manufacturer.php';

// Instantiate the Manufacturer class and fetch all manufacturers
$manufacturerClass = new Manufacturer($conn);
$manufacturers = $manufacturerClass->getAllManufacturersWithProductCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturers List</title>
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Manufacturers List</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Manufacturer Name</th>
                <th>Specialty</th>
                <th>Logo</th>
                <th>Product Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($manufacturers as $manufacturer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($manufacturer['id']); ?></td>
                    <td><?php echo htmlspecialchars($manufacturer['name']); ?></td>
                    <td><?php echo htmlspecialchars($manufacturer['specialty']); ?></td>
                    <td>
                        <?php if (!empty($manufacturer['logo_path'])): ?>
                            <img src="<?php echo htmlspecialchars($manufacturer['logo_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($manufacturer['name']); ?> Logo" 
                                 style="max-width: 100px;">
                        <?php else: ?>
                            <span>No Logo</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($manufacturer['product_count']); ?></td>
                    <td>
                        <a href="manufacturer.php?id=<?php echo htmlspecialchars($manufacturer['id']); ?>" 
                           class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="manufacturer_form.php" class="btn btn-success">Add New Manufacturer</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
