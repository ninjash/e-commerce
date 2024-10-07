<?php
require 'db_connect.php';

// Check if manufacturer ID is provided
if (!isset($_GET['id'])) {
    echo "Manufacturer ID is missing.";
    exit;
}

$manufacturer_id = $_GET['id'];

// Fetch the manufacturer details
$manufacturer_query = "SELECT * FROM manufacturers WHERE id = $manufacturer_id";
$manufacturer_result = mysqli_query($conn, $manufacturer_query);

if (!$manufacturer_result || mysqli_num_rows($manufacturer_result) == 0) {
    echo "Manufacturer not found.";
    exit;
}

$manufacturer = mysqli_fetch_assoc($manufacturer_result);

// Fetch products for this manufacturer
$product_query = "
    SELECT p.*
    FROM products p
    WHERE p.manufacturer_id = $manufacturer_id
";
$product_result = mysqli_query($conn, $product_query);
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
            <?php if (mysqli_num_rows($product_result) > 0): ?>
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
                        <?php while ($product = mysqli_fetch_assoc($product_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></td>
                                <td>
                                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products found for this manufacturer.</p>
            <?php endif; ?>

            <a href="edit_manufacturer.php?id=<?php echo $manufacturer['id']; ?>" class="btn btn-warning">Edit Manufacturer</a>
            <a href="delete_manufacturer.php?id=<?php echo $manufacturer['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this manufacturer?');">Delete Manufacturer</a>
            <a href="manufacturer_list.php" class="btn btn-secondary">Back to Manufacturer List</a>
        </div>
    </div>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
