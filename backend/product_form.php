<?php
session_start();
require 'db_connect.php';

$target_dir = "/e-commerce/assets/products/";


if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $short_description = $_POST['short_description'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $feature_product = isset($_POST['feature_product']) ? 1 : 0;
    $category_id = $_POST['category_id'];


    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $main_image = $_FILES['main_image'];
        $target_file = $target_dir . basename($main_image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($main_image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {

            $product_data = [
                'name' => $name,
                'sku' => $sku,
                'short_description' => $short_description,
                'price' => $price,
                'description' => $description,
                'feature_product' => $feature_product,
                'category_id' => $category_id,
                'main_image' => $target_file
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
        $category_id = $product['category_id'];
        $main_image = $product['main_image'];


        $query = "INSERT INTO products (name, sku, short_description, price, description, feature_product, category_id) 
                  VALUES ('$name', '$sku', '$short_description', $price, '$description', $feature_product, $category_id)";
        if (mysqli_query($conn, $query)) {
            $product_id = mysqli_insert_id($conn);

            $image_query = "INSERT INTO product_images (product_id, image_path) 
                            VALUES ($product_id, '$main_image')";
            mysqli_query($conn, $image_query);
        }
    }
    $_SESSION['products'] = [];
    echo "All products have been saved!";
    header("Location: product_list.php");
    exit;
}
?>

<!-- Product Form -->
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
    
    <label>Category</label>
    <select name="category_id" required><br>
        <?php
        $category_query = "SELECT id, name FROM categories";
        $category_result = mysqli_query($conn, $category_query);
        while ($row = mysqli_fetch_assoc($category_result)) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select><br>
    
    <label>Main Image</label><br>
    <input type="file" name="main_image" required><br>


    <button type="submit" name="add_product">Add Product</button><br>
</form>


<form method="POST" action="product_form.php">
    <button type="submit" name="save_products">Save All Products</button>
</form>


<?php if (!empty($_SESSION['products'])): ?>
    <h2>Products to be Saved</h2>
    <ul>
        <?php foreach ($_SESSION['products'] as $product): ?>
            <li><?php echo $product['name']; ?> - <?php echo $product['sku']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
