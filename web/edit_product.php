<?php
require 'db_connect.php';
require '../classes/Product.php';
require '../classes/Category.php';
require '../classes/Manufacturer.php';

// Check if product ID is provided
if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$product_id = (int)$_GET['id']; // Ensure the product ID is an integer

// Instantiate the Product class and fetch product details
$productClass = new Product($conn);
$product = $productClass->getProductDetailsById($product_id);

if (!$product) {
    echo "Product not found.";
    exit;
}

// Instantiate the Manufacturer class and fetch all manufacturers
$manufacturerClass = new Manufacturer($conn);
$manufacturers = $manufacturerClass->getAllManufacturersWithProductCount();

// Instantiate the Category class and fetch categories
$categoryClass = new Category($conn);
$allCategories = $categoryClass->getAllCategories();
$productCategories = $productClass->getProductCategoriesById($product_id);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $short_description = $_POST['short_description'];
    $price = (float)$_POST['price'];
    $old_price = (float)$_POST['old_price'];
    $description = $_POST['description'];
    $feature_product = isset($_POST['feature_product']) ? 1 : 0;
    $manufacturer_id = (int)$_POST['manufacturer_id'];
    $selected_categories = $_POST['categories'] ?? [];

    // Update product details
    $productClass->updateProduct($product_id, $name, $sku, $short_description, $price, $old_price, $description, $feature_product, $manufacturer_id);

    // Update product categories
    $productClass->updateProductCategories($product_id, $selected_categories);

    // Handle image upload
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $main_image = $_FILES['main_image'];
        $target_dir = "/e-commerce/assets/products/";
        $target_file = $target_dir . basename($main_image["name"]);

        if (move_uploaded_file($main_image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            $productClass->updateProductImage($product_id, $target_file);
        }
    }

    header("Location: product.php?id=$product_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <h1>Edit Product</h1>

    <form method="POST" action="edit_product.php?id=<?php echo $product_id; ?>" enctype="multipart/form-data">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>

        <label>SKU</label>
        <input type="text" name="sku" value="<?php echo htmlspecialchars($product['sku']); ?>" required><br>

        <label>Short Description</label>
        <textarea name="short_description" required><?php echo htmlspecialchars($product['short_description']); ?></textarea><br>

        <label>Price</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required><br>

        <label>Old Price</label>
        <input type="number" name="old_price" step="0.01" value="<?php echo $product['old_price']; ?>"><br>

        <label>Description</label>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br>

        <label>Feature Product</label>
        <input type="checkbox" name="feature_product" <?php echo $product['feature_product'] ? 'checked' : ''; ?>><br>

        <!-- Manufacturer dropdown -->
        <label>Manufacturer</label><br>
        <select name="manufacturer_id" required>
            <?php foreach ($manufacturers as $manufacturer): ?>
                <option value="<?php echo $manufacturer['id']; ?>" <?php echo $manufacturer['id'] == $product['manufacturer_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($manufacturer['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <!-- Categories Block (pre-selected) -->
        <div id="categories-container">
            <div class="category-assignment">
                <label>Assign Category</label><br>
                <select class="main_category" name="categories[]">
                    <option value="">Select Category</option>
                    <?php foreach ($allCategories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo in_array($category['id'], $productCategories) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            </div>
        </div>

        <button type="button" id="add-category-assignment">Add Another Category</button><br><br>

        <label>Main Image</label><br>
        <input type="file" name="main_image"><br>

        <button type="submit">Update Product</button>
    </form>
    <form method="GET" action="product.php" style="margin-top: 20px;">
        <input type="hidden" name="id" value="<?php echo $product_id; ?>">
        <button type="submit" class="btn btn-secondary">Back to Product</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#add-category-assignment').click(function() {
            var newCategoryBlock = $('.category-assignment').first().clone();
            newCategoryBlock.find('select').val('');
            $('#categories-container').append(newCategoryBlock);
        });
    });
</script>

</body>
</html>
