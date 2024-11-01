<?php
require 'db_connect.php';
require '../classes/Product.php';
require '../classes/Category.php';
require '../classes/Manufacturer.php';
require_once '../classes/ProductAttribute.php';

// Check if product ID is provided
if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$product_id = (int)$_GET['id']; // Ensure it's an integer

// Instantiate the Product class and fetch the product details
$productClass = new Product($conn);
$product = $productClass->getProductDetailsById($product_id);

// Check if product details are correctly fetched as an associative array
if (!is_array($product) || $product === null) {
    echo "Product not found.";
    exit;
}

// Fetch categories for this product
$categories = $productClass->getProductCategoriesById($product_id);

// Ensure $categories is an array
if (!is_array($categories)) {
    $categories = []; // Fallback to an empty array if the data structure is incorrect
}

// Fetch manufacturer details
$manufacturerClass = new Manufacturer($conn, $product['manufacturer_id']);
$manufacturerName = $manufacturerClass->getName();
$manufacturerLogoPath = $manufacturerClass->getLogoPath();

// Instantiate ProductAttribute and fetch attributes
$productAttribute = new ProductAttribute($conn);
$attributes = $productAttribute->getProductAttributesById($product_id);

// Fetch product images
$images = $productClass->getProductImages($product_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
</head>
<body>

<div class="container mt-4">
    <h1>Product Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2><?php echo htmlspecialchars($product['name'] ?? ''); ?></h2>
            <p><strong>SKU:</strong> <?php echo htmlspecialchars($product['sku'] ?? ''); ?></p>

            <p><strong>Categories:</strong>
                <?php if (!empty($categories) && is_array($categories)): ?>
                    <ul>
                        <?php foreach ($categories as $category): ?>
                            <?php if (!empty($category['main_category'])): ?>
                                <li><strong>Main Category:</strong> <?php echo htmlspecialchars($category['main_category']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($category['second_category'])): ?>
                                <li><strong>Second Category:</strong> <?php echo htmlspecialchars($category['second_category']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($category['third_category'])): ?>
                                <li><strong>Third Category:</strong> <?php echo htmlspecialchars($category['third_category']); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No categories assigned.</p>
                <?php endif; ?>
            </p>

            <p><strong>Manufacturer:</strong> 
                <?php if (!empty($manufacturerName)): ?>
                    <span><?php echo htmlspecialchars($manufacturerName); ?></span><br>
                    <?php if (!empty($manufacturerLogoPath)): ?>
                        <img src="<?php echo htmlspecialchars($manufacturerLogoPath); ?>" alt="<?php echo htmlspecialchars($manufacturerName); ?>" style="max-width: 150px;">
                    <?php endif; ?>
                <?php else: ?>
                    <span>No manufacturer assigned.</span>
                <?php endif; ?>
            </p>

            <p><strong>Short Description:</strong> <?php echo htmlspecialchars($product['short_description'] ?? ''); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description'] ?? ''); ?></p>
            <p><strong>Featured Product:</strong> <?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product['price'] ?? 0, 2); ?></p>
            
            <?php if (!empty($product['old_price'])): ?>
                <p><strong>Old Price:</strong> <span style="text-decoration: line-through;">$<?php echo number_format($product['old_price'], 2); ?></span></p>
            <?php endif; ?>

            <h3>Product Attributes</h3>
            <?php if (!empty($attributes) && is_array($attributes)): ?>
                <ul>
                    <?php foreach ($attributes as $attribute): ?>
                        <li><strong><?php echo htmlspecialchars($attribute['name']); ?>:</strong> <?php echo htmlspecialchars($attribute['value']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No attributes available for this product.</p>
            <?php endif; ?>

            <h3>Product Images</h3>
            <?php if (!empty($images) && is_array($images)): ?>
                <div class="row">
                    <?php foreach ($images as $image): ?>
                        <div class="col-md-3 mb-3">
                            <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No images available for this product.</p>
            <?php endif; ?>

            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-warning">Edit Product</a>
            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete Product</a>
            <a href="product_list.php" class="btn btn-secondary">Back to Product List</a>
        </div>
    </div>
</div>

</body>
</html>