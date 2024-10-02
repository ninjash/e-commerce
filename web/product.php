<?php
require 'db_connect.php';

if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$product_id = $_GET['id'];

$query = "SELECT p.id, p.name, p.sku, p.short_description, p.price, p.old_price, p.description, p.feature_product, c.name as category_name 
          FROM products p
          JOIN categories c ON p.category_id = c.id
          WHERE p.id = $product_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Product not found.";
    exit;
}

$product = mysqli_fetch_assoc($result);

$image_query = "SELECT image_path FROM product_images WHERE product_id = $product_id";
$image_result = mysqli_query($conn, $image_query);

$attribute_query = "SELECT a.name, pa.value 
                    FROM product_attributes pa
                    JOIN attributes a ON pa.attribute_id = a.id
                    WHERE pa.product_id = $product_id";
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
            <h2><?php echo $product['name']; ?></h2>
            <p><strong>SKU:</strong> <?php echo $product['sku']; ?></p>
            <p><strong>Category:</strong> <?php echo $product['category_name']; ?></p>
            <p><strong>Short Description:</strong> <?php echo $product['short_description']; ?></p>
            <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
            <p><strong>Featured Product:</strong> <?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
            
            <?php if (!empty($product['old_price'])): ?>
                <p><strong>Old Price:</strong> <span style="text-decoration: line-through;">$<?php echo number_format($product['old_price'], 2); ?></span></p>
            <?php endif; ?>

            <h3>Product Attributes</h3>
            <?php if (mysqli_num_rows($attribute_result) > 0): ?>
                <ul>
                    <?php while ($attribute = mysqli_fetch_assoc($attribute_result)): ?>
                        <li><strong><?php echo $attribute['name']; ?>:</strong> <?php echo $attribute['value']; ?></li>
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
                            <img src="<?php echo $image['image_path']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid">
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