<?php
require 'db_connect.php';
require '../classes/Manufacturer.php';
require '../classes/Product.php';

// Check if manufacturer ID is provided
if (!isset($_GET['id'])) {
    echo "Manufacturer ID is missing.";
    exit;
}

$manufacturer_id = (int)$_GET['id']; // Ensure it's an integer

// Instantiate the Manufacturer class and fetch the manufacturer details
$manufacturerClass = new Manufacturer($conn, $manufacturer_id);
$manufacturer = [
    'name' => $manufacturerClass->getName(),
    'specialty' => $manufacturerClass->getSpecialty(),
    'logo_path' => $manufacturerClass->getLogoPath()
];

if (empty($manufacturer['name'])) {
    echo "Manufacturer not found.";
    exit;
}

// Instantiate the Product class and fetch products for this manufacturer
$productClass = new Product($conn);
$products = $productClass->getProductsByManufacturerId($manufacturer_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer Details</title>
</head>
<body>

<div class="container mt-4">
    <h1>Manufacturer Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2><?php echo htmlspecialchars($manufacturer['name']); ?></h2>

            <p><strong>Specialty:</strong> <?php echo htmlspecialchars($manufacturer['specialty']); ?></p>
            <p><strong>Logo:</strong></p>
            <img src="<?php echo htmlspecialchars($manufacturer['logo_path']); ?>" alt="<?php echo htmlspecialchars($manufacturer['name']); ?> Logo" style="max-width: 150px;">

            <h3>Products by this Manufacturer</h3>
            <?php if (!empty($products)): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Feature Product</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></td>
                                <td>
                                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products found for this manufacturer.</p>
            <?php endif; ?>

            <a href="edit_manufacturer.php?id=<?php echo $manufacturer_id; ?>" class="btn btn-warning">Edit Manufacturer</a>
            <a href="delete_manufacturer.php?id=<?php echo $manufacturer_id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this manufacturer?');">Delete Manufacturer</a>
            <a href="manufacturer_list.php" class="btn btn-secondary">Back to Manufacturer List</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
