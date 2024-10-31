<?php
require 'db_connect.php';
require '../classes/Product.php';
require '../classes/Category.php';

// Instantiate the Product class
$productClass = new Product($conn);

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($productClass->deleteProduct($delete_id)) {
        header("Location: product_list.php"); // Redirect after deletion
        exit;
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}

// Fetch all products with associated categories and manufacturers
$products = $productClass->getAllProductsWithDetails();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
</head>
<body>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Categories</th>
            <th>Manufacturer</th>
            <th>Feature Product</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['sku']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['category_names']) ?: 'No categories'; ?></td>
                <td><?php echo htmlspecialchars($product['manufacturer_name']) ?: 'Unknown'; ?></td>
                <td><?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <a href="product.php?id=<?php echo $product['id']; ?>">View</a>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                    <a href="product_list.php?delete_id=<?php echo $product['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Register Product Button -->
<a href="product_form.php">
    <button>Register Product</button>
</a>

</body>
</html>