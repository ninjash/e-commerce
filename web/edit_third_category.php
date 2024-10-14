<?php
require 'db_connect.php';

// Check if third category ID is provided
if (!isset($_GET['id'])) {
    echo "Third Category ID is missing.";
    exit;
}

$third_category_id = $_GET['id'];

// Fetch the related second and main categories for the third category, including whether it's featured
$category_query = "
    SELECT tc.name AS third_category_name, tc.description AS third_category_description, tc.is_featured, sc.id AS second_category_id, mc.id AS main_category_id 
    FROM third_categories tc
    JOIN second_categories sc ON tc.second_category_id = sc.id
    JOIN main_categories mc ON sc.main_category_id = mc.id
    WHERE tc.id = $third_category_id";

$category_result = mysqli_query($conn, $category_query);

if (!$category_result || mysqli_num_rows($category_result) == 0) {
    echo "Third Category not found.";
    exit;
}

$category = mysqli_fetch_assoc($category_result);
$second_category_id = $category['second_category_id'];
$main_category_id = $category['main_category_id'];

// Fetch current products assigned to this third category
$current_products_query = "
    SELECT p.id, p.name 
    FROM products p 
    JOIN product_categories pc ON p.id = pc.product_id 
    WHERE pc.third_category_id = $third_category_id";
$current_products_result = mysqli_query($conn, $current_products_query);

// Fetch all products to allow for adding new ones
$available_products_query = "
    SELECT p.id, p.name 
    FROM products p 
    WHERE p.id NOT IN (
        SELECT product_id FROM product_categories WHERE third_category_id = $third_category_id)";
$available_products_result = mysqli_query($conn, $available_products_query);

// Handle form submission to update the third category
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $category_description = mysqli_real_escape_string($conn, $_POST['category_description']);
    $featured = isset($_POST['is_featured']) ? 1 : 0; // Check if the checkbox is selected

    // Update third category details
    $update_query = "
        UPDATE third_categories
        SET name = '$category_name', description = '$category_description', is_featured = $featured
        WHERE id = $third_category_id";
    mysqli_query($conn, $update_query);

    // Handle image upload
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
        $image = $_FILES['category_image'];
        $target_file = "/e-commerce/assets/categories/" . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            $image_update_query = "INSERT INTO category_images (third_category_id, image_path) 
                                   VALUES ($third_category_id, '$target_file')
                                   ON DUPLICATE KEY UPDATE image_path = '$target_file'";
            mysqli_query($conn, $image_update_query);
        }
    }

    // Add new products to this third category
    if (isset($_POST['add_products'])) {
        foreach ($_POST['add_products'] as $product_id) {
            // Insert or update the main, second, and third categories for the product
            $add_product_query = "
                INSERT INTO product_categories (product_id, main_category_id, second_category_id, third_category_id) 
                VALUES ($product_id, $main_category_id, $second_category_id, $third_category_id)
                ON DUPLICATE KEY UPDATE main_category_id = $main_category_id, second_category_id = $second_category_id, third_category_id = $third_category_id";
            mysqli_query($conn, $add_product_query);
        }
    }

    // Remove selected products from this third category
    if (isset($_POST['remove_products'])) {
        foreach ($_POST['remove_products'] as $product_id) {
            // Set third_category_id to NULL or to a default value (as needed)
            $remove_product_query = "
                DELETE FROM product_categories 
                WHERE product_id = $product_id AND third_category_id = $third_category_id";
            mysqli_query($conn, $remove_product_query);
        }
    }

    // Redirect to view_third_category.php with the correct third_id
    header("Location: view_third_category.php?third_id=" . $third_category_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Third Category</title>
</head>
<body>

<h1>Edit Third Category: <?php echo htmlspecialchars($category['third_category_name']); ?></h1>

<form method="POST" action="edit_third_category.php?id=<?php echo $third_category_id; ?>" enctype="multipart/form-data">
    <div>
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['third_category_name']); ?>" required>
    </div>
    <div>
        <label for="category_description">Category Description:</label>
        <textarea id="category_description" name="category_description" rows="4" required><?php echo htmlspecialchars($category['third_category_description']); ?></textarea>
    </div>

    <!-- Featured Category Checkbox -->
    <div>
        <label for="is_featured">Featured Category:</label>
        <input type="checkbox" id="is_featured" name="is_featured" <?php if ($category['is_featured']) echo 'checked'; ?>>
    </div>

    <div>
        <label for="category_image">Category Image:</label><br>
        <?php if (!empty($category['image_path'])) { ?>
            <img src="<?php echo $category['image_path']; ?>" alt="Category Image" width="100"><br>
            <small>Current Image</small><br>
        <?php } ?>
        <input type="file" name="category_image">
    </div>

    <h3>Assign Products to this Third Category</h3>
    <?php if (mysqli_num_rows($available_products_result) > 0) { ?>
        <div>
            <label>Add Products:</label>
            <?php while ($product = mysqli_fetch_assoc($available_products_result)) { ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="add_products[]" value="<?php echo $product['id']; ?>">
                    <label class="form-check-label"><?php echo $product['name']; ?></label>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No products available to add.</p>
    <?php } ?>

    <h3>Remove Products from this Third Category</h3>
    <?php if (mysqli_num_rows($current_products_result) > 0) { ?>
        <div>
            <label>Remove Products:</label>
            <?php while ($product = mysqli_fetch_assoc($current_products_result)) { ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remove_products[]" value="<?php echo $product['id']; ?>">
                    <label class="form-check-label"><?php echo $product['name']; ?></label>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No products assigned to this category.</p>
    <?php } ?>

    <button type="submit">Save Changes</button>
</form>

<a href="view_third_category.php?third_id=<?php echo $_GET['id']?>">Cancel</a>

</body>
</html>

<?php
mysqli_close($conn);
?>