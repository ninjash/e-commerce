<?php
session_start();
require 'db_connect.php';

$target_dir = "/e-commerce/assets/products/";

// Initialize products in session if not set
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

// Fetch all attributes
$attributes_query = "SELECT * FROM attributes";
$attributes_result = mysqli_query($conn, $attributes_query);

// Fetch all categories
$category_query = "SELECT id, name FROM categories";
$category_result = mysqli_query($conn, $category_query);

// Fetch all manufacturers
$manufacturer_query = "SELECT id, name FROM manufacturers";
$manufacturer_result = mysqli_query($conn, $manufacturer_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $short_description = $_POST['short_description'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $feature_product = isset($_POST['feature_product']) ? 1 : 0;
    $categories = $_POST['categories'];  // Multiple categories
    $manufacturer_id = $_POST['manufacturer_id'];  // Manufacturer

    // Handle file upload
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $main_image = $_FILES['main_image'];
        $target_file = $target_dir . basename($main_image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($main_image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {

            // Collect attributes data
            $attributes = [];
            if (isset($_POST['attributes'])) {
                foreach ($_POST['attributes'] as $attribute_id => $value) {
                    $attributes[$attribute_id] = $value;
                }
            }

            // Store product data in session
            $product_data = [
                'name' => $name,
                'sku' => $sku,
                'short_description' => $short_description,
                'price' => $price,
                'description' => $description,
                'feature_product' => $feature_product,
                'categories' => $categories,  // Store multiple categories
                'main_image' => $target_file,
                'manufacturer_id' => $manufacturer_id,  // Store manufacturer ID
                'attributes' => $attributes
            ];

            $_SESSION['products'][] = $product_data;

            echo "Product added successfully. Add another product or save all.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_products'])) {
    foreach ($_SESSION['products'] as $product) {
        $name = $product['name'];
        $sku = $product['sku'];
        $short_description = $product['short_description'];
        $price = $product['price'];
        $description = $product['description'];
        $feature_product = $product['feature_product'];
        $categories = $product['categories'];
        $main_image = $product['main_image'];
        $manufacturer_id = $product['manufacturer_id'];

        // Insert product into products table with manufacturer ID
        $query = "INSERT INTO products (name, sku, short_description, price, description, feature_product, manufacturer_id) 
                  VALUES ('$name', '$sku', '$short_description', $price, '$description', $feature_product, $manufacturer_id)";
        if (mysqli_query($conn, $query)) {
            $product_id = mysqli_insert_id($conn);

            // Insert main image into product_images table
            $image_query = "INSERT INTO product_images (product_id, image_path) 
                            VALUES ($product_id, '$main_image')";
            mysqli_query($conn, $image_query);

            // Insert attributes into product_attributes table
            if (isset($product['attributes'])) {
                foreach ($product['attributes'] as $attribute_id => $value) {
                    $attribute_query = "INSERT INTO product_attributes (product_id, attribute_id, value) 
                                        VALUES ($product_id, $attribute_id, '$value')";
                    mysqli_query($conn, $attribute_query);
                }
            }

            // Insert categories into product_categories table
            foreach ($categories as $category_id) {
                $category_query = "INSERT INTO product_categories (product_id, category_id) 
                                   VALUES ($product_id, $category_id)";
                mysqli_query($conn, $category_query);
            }
        }
    }
    $_SESSION['products'] = [];
    echo "All products have been saved!";
    header("Location: product_list.php");
    exit;
}
?>

<!-- HTML Form to Add Product -->
<form method="POST" action="product_form.php" enctype="multipart/form-data">
    <label>Name</label>
    <input type="text" name="name" required><br>

    <label>SKU</label>
    <input type="text" name="sku" required><br>

    <label>Short Description</label>
    <textarea name="short_description" required></textarea><br>

    <label>Price</label>
    <input type="number" name="price" step="0.01" required><br>

    <label>Description</label>
    <textarea name="description" required></textarea><br>

    <label>Feature Product</label>
    <input type="checkbox" name="feature_product"><br>

    <!-- Modify Category Section to allow multiple selections -->
    <label>Categories</label><br>
    <?php
    while ($row = mysqli_fetch_assoc($category_result)) {
        echo "<div class='form-check'>
                <input class='form-check-input' type='checkbox' name='categories[]' value='" . $row['id'] . "'>
                <label class='form-check-label'>" . $row['name'] . "</label>
            </div>";
    }
    ?><br>

    <!-- Manufacturer Selection -->
    <label>Manufacturer</label>
    <select name="manufacturer_id" required>
        <option value="">Select a manufacturer</option>
        <?php
        while ($row = mysqli_fetch_assoc($manufacturer_result)) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select><br>

    <label>Main Image</label><br>
    <input type="file" name="main_image" required><br>

    <h3>Product Attributes</h3>
    <?php if (mysqli_num_rows($attributes_result) > 0): ?>
        <?php while ($attribute = mysqli_fetch_assoc($attributes_result)): ?>
            <label><?php echo $attribute['name']; ?></label>
            <input type="text" name="attributes[<?php echo $attribute['id']; ?>]" placeholder="Enter <?php echo $attribute['name']; ?>"><br>
        <?php endwhile; ?>
    <?php endif; ?>

    <button type="submit" name="add_product">Add Product</button><br>
</form>

<!-- Form to Save All Products -->
<form method="POST" action="product_form.php">
    <button type="submit" name="save_products">Save All Products</button>
</form>

<!-- Display Products Pending Save -->
<?php if (!empty($_SESSION['products'])): ?>
    <h2>Products to be Saved</h2>
    <ul>
        <?php foreach ($_SESSION['products'] as $product): ?>
            <li><?php echo $product['name']; ?> - <?php echo $product['sku']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
