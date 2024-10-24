<?php
require 'db_connect.php';

// Update the query to join the manufacturers and category tables
$query = "
    SELECT p.id, p.name, p.sku, p.price, p.feature_product, m.name AS manufacturer_name, 
           GROUP_CONCAT(c.name SEPARATOR ', ') AS category_names
    FROM products p
    LEFT JOIN manufacturers m ON p.manufacturer_id = m.id
    LEFT JOIN product_categories pc ON p.id = pc.product_id
    LEFT JOIN categories c ON pc.category_id = c.id
    GROUP BY p.id
";
$result = mysqli_query($conn, $query);

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM products WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        // Optionally, you can delete related entries from other tables, like product_categories, etc.
        header("Location: products_list.php"); // Redirect after deletion
        exit;
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
}
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
        <?php while ($product = mysqli_fetch_assoc($result)) { ?>
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
                    <a href="products_list.php?delete_id=<?php echo $product['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Register Product Button -->
<a href="product_form.php">
    <button>Register Product</button>
</a>

</body>
</html>