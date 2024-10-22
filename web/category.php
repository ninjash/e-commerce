<?php 
require 'db_connect.php';

// Check if category ID is provided
if (!isset($_GET['id'])) {
    echo "Category ID is missing.";
    exit;
}

$category_id = (int)$_GET['id']; // Ensure it's an integer

// Fetch the current category details including parent categories and image
$category_query = "
    SELECT c.id, c.name, c.parent_id, ci.image_path
    FROM categories c
    LEFT JOIN category_images ci ON c.id = ci.category_id
    WHERE c.id = $category_id
";
$category_result = mysqli_query($conn, $category_query);

if (!$category_result || mysqli_num_rows($category_result) == 0) {
    echo "Category not found.";
    exit;
}

$category = mysqli_fetch_assoc($category_result);

// Fetch subcategories under this category
$subcategories_query = "SELECT id, name FROM categories WHERE parent_id = $category_id";
$subcategories_result = mysqli_query($conn, $subcategories_query);
$has_subcategories = mysqli_num_rows($subcategories_result) > 0;

// Check if this is a third-level category (no subcategories)
if (!$has_subcategories) {
    // Fetch products for this category
    $product_query = "
        SELECT p.* FROM products p
        INNER JOIN product_categories pc ON p.id = pc.product_id
        WHERE pc.category_id = $category_id
    ";
    $product_result = mysqli_query($conn, $product_query);
    $has_products = mysqli_num_rows($product_result) > 0;
}

// Determine category depth for labeling
$category_level = 'Main Category'; // Default level
if ($category['parent_id']) {
    // If the category has a parent, it is either second or third level
    $parent_query = "SELECT parent_id FROM categories WHERE id = {$category['parent_id']}";
    $parent_result = mysqli_query($conn, $parent_query);
    $parent = mysqli_fetch_assoc($parent_result);
    
    if ($parent['parent_id']) {
        $category_level = 'Third Category'; // If the parent also has a parent, this is a third-level category
    } else {
        $category_level = 'Second Category'; // Otherwise, it's a second-level category
    }
}
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
            <h2>Category: <?php echo htmlspecialchars($category['name']); ?></h2>
            
            <!-- Display category image if available -->
            <?php if (!empty($category['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($category['image_path']); ?>" alt="Category Image" width="200">
            <?php endif; ?>

            <?php if ($has_subcategories): ?>
                <!-- Dynamically adjust heading based on category level -->
                <h3><?php echo $category_level === 'Main Category' ? 'Second Categories' : 'Third Categories'; ?></h3>
                <ul>
                    <?php while ($subcategory = mysqli_fetch_assoc($subcategories_result)): ?>
                        <li><a href="category.php?id=<?php echo $subcategory['id']; ?>"><?php echo htmlspecialchars($subcategory['name']); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            <?php elseif ($has_products): ?>
                <h3>Products in this Category</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = mysqli_fetch_assoc($product_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
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

            <a href="edit_category.php?id=<?php echo $category_id; ?>" class="btn btn-warning">Edit Category</a>
            <a href="delete_category.php?id=<?php echo $category_id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete Category</a>
            <a href="category_list.php" class="btn btn-secondary">Back to Category List</a>
        </div>
    </div>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>