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

// Fetch existing third categories for the product
$product_categories_query = "SELECT third_category_id FROM product_categories WHERE product_id = $product_id";
$product_categories_result = mysqli_query($conn, $product_categories_query);
$product_third_categories = [];
while ($pc = mysqli_fetch_assoc($product_categories_result)) {
    $product_third_categories[] = $pc['third_category_id'];
}

// Fetch manufacturers for the dropdown
$manufacturers_query = "SELECT id, name FROM manufacturers";
$manufacturers_result = mysqli_query($conn, $manufacturers_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $short_description = $_POST['short_description'];
    $price = $_POST['price'];
    $old_price = $_POST['old_price'];
    $description = $_POST['description'];
    $feature_product = isset($_POST['feature_product']) ? 1 : 0;
    $third_categories = $_POST['third_categories']; // This will be an array of selected third categories
    $manufacturer_id = $_POST['manufacturer_id'];

    // Update product details
    $update_query = "UPDATE products 
                     SET name = '$name', sku = '$sku', short_description = '$short_description', 
                         price = $price, old_price = $old_price, description = '$description', 
                         feature_product = $feature_product, manufacturer_id = $manufacturer_id
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
        mysqli_query($conn, "DELETE FROM product_categories WHERE product_id = $product_id");

        // Insert the selected third categories for the product
        foreach ($third_categories as $third_category_id) {
            // Fetch the second category linked to the third category
            $second_category_query = "SELECT second_category_id FROM third_categories WHERE id = $third_category_id";
            $second_category_result = mysqli_query($conn, $second_category_query);
            if (mysqli_num_rows($second_category_result) > 0) {
                $second_category_row = mysqli_fetch_assoc($second_category_result);
                $second_category_id = $second_category_row['second_category_id'];
        
                // Fetch the main category linked to the second category
                $main_category_query = "SELECT main_category_id FROM second_categories WHERE id = $second_category_id";
                $main_category_result = mysqli_query($conn, $main_category_query);
                if (mysqli_num_rows($main_category_result) > 0) {
                    $main_category_row = mysqli_fetch_assoc($main_category_result);
                    $main_category_id = $main_category_row['main_category_id'];
        
                    // Insert into product_categories only if valid data is found
                    $category_insert_query = "INSERT INTO product_categories (product_id, main_category_id, second_category_id, third_category_id) 
                                              VALUES ($product_id, $main_category_id, $second_category_id, $third_category_id)";
                    mysqli_query($conn, $category_insert_query);
                } else {
                    echo "Main category not found for second category $second_category_id.";
                }
            } else {
                echo "Second category not found for third category $third_category_id.";
            }
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
    <style>
        .scrollable-checkboxes {
            max-height: 150px;
            max-width: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
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

        <!-- Third Category Selection (checkboxes) -->
        <label>Third Categories</label><br>
        <div class="scrollable-checkboxes">
            <?php
            $third_category_query = "SELECT id, name FROM third_categories";
            $third_category_result = mysqli_query($conn, $third_category_query);
            while ($row = mysqli_fetch_assoc($third_category_result)) {
                $checked = in_array($row['id'], $product_third_categories) ? 'checked' : '';
                echo "<div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='third_categories[]' value='" . $row['id'] . "' $checked>
                        <label class='form-check-label'>" . $row['name'] . "</label>
                    </div>";
            }
            ?>
        </div><br>

        <!-- Manufacturer dropdown -->
        <label>Manufacturer</label><br>
        <select name="manufacturer_id" required>
            <?php while ($manufacturer = mysqli_fetch_assoc($manufacturers_result)): ?>
                <option value="<?php echo $manufacturer['id']; ?>" <?php echo $manufacturer['id'] == $product['manufacturer_id'] ? 'selected' : ''; ?>>
                    <?php echo $manufacturer['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

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
    <form method="GET" action="product.php" style="margin-top: 20px;">
        <input type="hidden" name="id" value="<?php echo $product_id; ?>">
        <button type="submit" class="btn btn-secondary">Back to Product</button>
    </form>
</div>
</body>
</html>
