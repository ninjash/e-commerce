<?php
require 'db_connect.php';

// Check if product ID is provided
if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$product_id = (int)$_GET['id']; // Ensure it's an integer

// Fetch product details, including the associated manufacturer
$query = "
    SELECT p.id, p.name, p.sku, p.short_description, p.price, p.old_price, p.description, p.feature_product, 
           m.name as manufacturer_name, m.logo_path
    FROM products p
    LEFT JOIN manufacturers m ON p.manufacturer_id = m.id
    WHERE p.id = $product_id
";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Product not found.";
    exit;
}

$product = mysqli_fetch_assoc($result);

// Fetch categories for this product using the updated category structure
$category_query = "
    SELECT c.name, c.id, c.parent_id
    FROM product_categories pc
    INNER JOIN categories c ON pc.category_id = c.id
    WHERE pc.product_id = $product_id
";
$category_result = mysqli_query($conn, $category_query);

// Recursively fetch category hierarchy (main, second, third)
$categories = [];
while ($category = mysqli_fetch_assoc($category_result)) {
    $categories[] = $category;
}

// Fetch product images
$image_query = "SELECT image_path FROM product_images WHERE product_id = $product_id";
$image_result = mysqli_query($conn, $image_query);

// Fetch product attributes
$attribute_query = "
    SELECT a.name, pa.value 
    FROM product_attributes pa
    JOIN attributes a ON pa.attribute_id = a.id
    WHERE pa.product_id = $product_id
";
$attribute_result = mysqli_query($conn, $attribute_query);
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
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><strong>SKU:</strong> <?php echo htmlspecialchars($product['sku']); ?></p>

            <p><strong>Categories:</strong>
                <?php if (!empty($categories)): ?>
                    <ul>
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <strong>Category Name:</strong> <?php echo htmlspecialchars($category['name']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No categories assigned.</p>
                <?php endif; ?>
            </p>

            <p><strong>Manufacturer:</strong> 
                <?php if (!empty($product['manufacturer_name'])): ?>
                    <span><?php echo htmlspecialchars($product['manufacturer_name']); ?></span><br>
                    <?php if (!empty($product['logo_path'])): ?>
                        <img src="<?php echo htmlspecialchars($product['logo_path']); ?>" alt="<?php echo htmlspecialchars($product['manufacturer_name']); ?>" style="max-width: 150px;">
                    <?php endif; ?>
                <?php else: ?>
                    <span>No manufacturer assigned.</span>
                <?php endif; ?>
            </p>

            <p><strong>Short Description:</strong> <?php echo htmlspecialchars($product['short_description']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>Featured Product:</strong> <?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
            
            <?php if (!empty($product['old_price'])): ?>
                <p><strong>Old Price:</strong> <span style="text-decoration: line-through;">$<?php echo number_format($product['old_price'], 2); ?></span></p>
            <?php endif; ?>

            <h3>Product Attributes</h3>
            <?php if (mysqli_num_rows($attribute_result) > 0): ?>
                <ul>
                    <?php while ($attribute = mysqli_fetch_assoc($attribute_result)): ?>
                        <li><strong><?php echo htmlspecialchars($attribute['name']); ?>:</strong> <?php echo htmlspecialchars($attribute['value']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No attributes available for this product.</p>
            <?php endif; ?>

            <h3>Product Images</h3>
            <?php if (mysqli_num_rows($image_result) > 0): ?>
                <div class="row">
                    <?php while ($image = mysqli_fetch_assoc($image_result)): ?>
                        <div class="col-md-3 mb-3">
                            <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                        </div>
                    <?php endwhile; ?>
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