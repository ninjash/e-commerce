<?php
require 'db_connect.php';

// Check if category ID is provided
if (!isset($_GET['id'])) {
    echo "Category ID is missing.";
    exit;
}

$category_id = $_GET['id'];

// Fetch the category details
$category_query = "SELECT * FROM categories WHERE id = $category_id";
$category_result = mysqli_query($conn, $category_query);

if (!$category_result || mysqli_num_rows($category_result) == 0) {
    echo "Category not found.";
    exit;
}

$category = mysqli_fetch_assoc($category_result);

// Fetch products for this category using the product_categories junction table
$product_query = "
    SELECT p.*
    FROM products p
    INNER JOIN product_categories pc ON p.id = pc.product_id
    WHERE pc.category_id = $category_id
";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details</title>
</head>
<body>

<div class="container mt-4">
    <h1>Category Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2><?php echo htmlspecialchars($category['name']); ?></h2>

            <p><strong>Description:</strong> <?php echo htmlspecialchars($category['description']); ?></p>
            
            <h3>Products in this Category</h3>
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
                <p>No products found in this category.</p>
            <?php endif; ?>

            <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-warning">Edit Category</a>
            <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete Category</a>
            <a href="category_list.php" class="btn btn-secondary">Back to Category List</a>
        </div>
    </div>
</div>

</body>
</html>
