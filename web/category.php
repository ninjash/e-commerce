<?php
require 'db_connect.php';
require_once '../classes/Category.php';
require_once '../classes/Product.php';

// Check if category ID is provided
if (!isset($_GET['id'])) {
    echo "Category ID is missing.";
    exit;
}

$category_id = (int)$_GET['id']; // Ensure it's an integer

// Instantiate the Category class and fetch details
$categoryClass = new Category($conn);
$categoryDetails = $categoryClass->getCategoryDetails($category_id);

// Check if the category exists
if (empty($categoryDetails)) {
    echo "Category not found.";
    exit;
}

// Set category details
$category_name = $categoryDetails['category_name'];
$parent_name = $categoryDetails['parent_name'] ?? 'N/A';
$grandparent_name = $categoryDetails['grandparent_name'] ?? 'N/A';
$image_path = $categoryClass->getCategoryImage($category_id); // Get the image path

// Fetch subcategories under this category
$subcategories = $categoryClass->getChildCategories($category_id);
$has_subcategories = !empty($subcategories);

// Check if this is a third-level category (no subcategories)
$has_products = false;
$product_result = [];

if (!$has_subcategories) {
    // Fetch products for this category
    $productClass = new Product($conn);
    $product_result = $productClass->getProductsByCategory($category_id, $conn); // Pass $conn to the method
    $has_products = !empty($product_result);
}

// Determine category depth for labeling
$category_level = 'Main Category'; // Default level
if ($parent_name !== 'N/A') {
    $category_level = $grandparent_name !== 'N/A' ? 'Third Category' : 'Second Category';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details - <?php echo htmlspecialchars($category_name); ?></title>
</head>
<body>

<div class="container mt-4">
    <h1>Category Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2>Category: <?php echo htmlspecialchars($category_name); ?></h2>
            
            <!-- Display category image or "No Image" placeholder -->
            <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Category Image" width="200">

            <?php if ($has_subcategories): ?>
                <h3><?php echo $category_level === 'Main Category' ? 'Second Categories' : 'Third Categories'; ?></h3>
                <ul>
                    <?php foreach ($subcategories as $subcategory_id): ?>
                        <?php
                        $subcategoryDetails = $categoryClass->getCategoryDetails($subcategory_id);
                        $subcategory_name = $subcategoryDetails['category_name'];
                        ?>
                        <li>
                            <a href="category.php?id=<?php echo $subcategory_id; ?>">
                                <?php echo htmlspecialchars($subcategory_name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
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
                        <?php foreach ($product_result as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td>
                                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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