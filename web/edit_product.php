<?php
require 'db_connect.php';

if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$product_id = $_GET['id'];

// Fetch product details
$product_query = "SELECT * FROM products WHERE id = $product_id";
$product_result = mysqli_query($conn, $product_query);

if (!$product_result || mysqli_num_rows($product_result) == 0) {
    echo "Product not found.";
    exit;
}

$product = mysqli_fetch_assoc($product_result);

// Fetch all attributes
$attributes_query = "SELECT * FROM attributes";
$attributes_result = mysqli_query($conn, $attributes_query);

// Fetch existing product attributes
$product_attributes_query = "SELECT attribute_id, value FROM product_attributes WHERE product_id = $product_id";
$product_attributes_result = mysqli_query($conn, $product_attributes_query);

$product_attributes = [];
while ($pa = mysqli_fetch_assoc($product_attributes_result)) {
    $product_attributes[$pa['attribute_id']] = $pa['value'];
}

// Fetch existing categories for the product
$product_categories_query = "SELECT category_id FROM product_categories WHERE product_id = $product_id";
$product_categories_result = mysqli_query($conn, $product_categories_query);
$product_categories = [];
while ($pc = mysqli_fetch_assoc($product_categories_result)) {
    $product_categories[] = $pc['category_id'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $short_description = $_POST['short_description'];
    $price = $_POST['price'];
    $old_price = $_POST['old_price'];
    $description = $_POST['description'];
    $feature_product = isset($_POST['feature_product']) ? 1 : 0;
    $categories = $_POST['categories'];

    // Update product details
    $update_query = "UPDATE products 
                     SET name = '$name', sku = '$sku', short_description = '$short_description', 
                         price = $price, old_price = $old_price, description = '$description', feature_product = $feature_product
                     WHERE id = $product_id";

    if (mysqli_query($conn, $update_query)) {
        // Update product attributes
        if (isset($_POST['attributes'])) {
            foreach ($_POST['attributes'] as $attribute_id => $value) {
                $value = mysqli_real_escape_string($conn, $value);

                if (isset($product_attributes[$attribute_id])) {
                    $attribute_update_query = "UPDATE product_attributes 
                                               SET value = '$value' 
                                               WHERE product_id = $product_id AND attribute_id = $attribute_id";
                } else {
                    $attribute_update_query = "INSERT INTO product_attributes (product_id, attribute_id, value) 
                                               VALUES ($product_id, $attribute_id, '$value')";
                }
                mysqli_query($conn, $attribute_update_query);
            }
        }

        // Handle product images (if provided)
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
            $main_image = $_FILES['main_image'];
            $target_file = "/e-commerce/assets/products/" . basename($main_image["name"]);

            if (move_uploaded_file($main_image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                $image_update_query = "UPDATE product_images 
                                       SET image_path = '$target_file' 
                                       WHERE product_id = $product_id";
                mysqli_query($conn, $image_update_query);
            }
        }

        // Update product categories
        // First, delete existing product-category relationships
        mysqli_query($conn, "DELETE FROM product_categories WHERE product_id = $product_id");

        // Insert new product-category relationships
        foreach ($categories as $category_id) {
            $category_insert_query = "INSERT INTO product_categories (product_id, category_id) VALUES ($product_id, $category_id)";
            mysqli_query($conn, $category_insert_query);
        }

        header("Location: product.php?id=$product_id");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>

<div class="container mt-4">
    <h1>Edit Product</h1>

    <form method="POST" action="edit_product.php?id=<?php echo $product_id; ?>" enctype="multipart/form-data">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>

        <label>SKU</label>
        <input type="text" name="sku" value="<?php echo $product['sku']; ?>" required><br>

        <label>Short Description</label>
        <textarea name="short_description" required><?php echo $product['short_description']; ?></textarea><br>

        <label>Price</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required><br>

        <label>Old Price</label>
        <input type="number" name="old_price" step="0.01" value="<?php echo $product['old_price']; ?>"><br>

        <label>Description</label>
        <textarea name="description" required><?php echo $product['description']; ?></textarea><br>

        <label>Feature Product</label>
        <input type="checkbox" name="feature_product" <?php echo $product['feature_product'] ? 'checked' : ''; ?>><br>

        <!-- Modify to select multiple categories -->
        <label>Categories</label><br>
            <?php
            $category_query = "SELECT id, name FROM categories";
            $category_result = mysqli_query($conn, $category_query);
            while ($row = mysqli_fetch_assoc($category_result)) {
                $checked = in_array($row['id'], $product_categories) ? 'checked' : '';
                echo "<div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='categories[]' value='" . $row['id'] . "' $checked>
                        <label class='form-check-label'>" . $row['name'] . "</label>
                    </div>";
                }
            ?><br>

        <label>Main Image</label><br>
        <input type="file" name="main_image"><br>

        <h3>Product Attributes</h3>
        <?php while ($attribute = mysqli_fetch_assoc($attributes_result)): ?>
            <label><?php echo $attribute['name']; ?></label>
            <input type="text" name="attributes[<?php echo $attribute['id']; ?>]" 
                   value="<?php echo isset($product_attributes[$attribute['id']]) ? $product_attributes[$attribute['id']] : ''; ?>"><br>
        <?php endwhile; ?>

        <button type="submit">Update Product</button>
    </form>
</div>
</body>
</html>
