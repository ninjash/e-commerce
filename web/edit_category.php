<?php
require 'db_connect.php';

if (!isset($_GET['id'])) {
    echo "Category ID is missing.";
    exit;
}

$category_id = $_GET['id'];

// Fetch category details
$category_query = "SELECT c.*, ci.image_path FROM categories c 
                   LEFT JOIN category_images ci ON c.id = ci.category_id 
                   WHERE c.id = $category_id";
$category_result = mysqli_query($conn, $category_query);

if (!$category_result || mysqli_num_rows($category_result) == 0) {
    echo "Category not found.";
    exit;
}

$category = mysqli_fetch_assoc($category_result);

// Fetch products currently in this category (using the product_categories table)
$current_products_query = "
    SELECT p.id, p.name, p.sku 
    FROM products p
    JOIN product_categories pc ON p.id = pc.product_id
    WHERE pc.category_id = $category_id";
$current_products_result = mysqli_query($conn, $current_products_query);

// Fetch all products not in this category (to add to the category)
$all_products_query = "
    SELECT p.id, p.name, p.sku 
    FROM products p
    WHERE p.id NOT IN (SELECT product_id FROM product_categories WHERE category_id = $category_id)";
$all_products_result = mysqli_query($conn, $all_products_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    // Update category details
    $update_category_query = "UPDATE categories 
                              SET name = '$category_name', description = '$description', featured = $featured 
                              WHERE id = $category_id";
    mysqli_query($conn, $update_category_query);

    // Handle image upload if provided
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
        $image = $_FILES['category_image'];
        $target_file = "/e-commerce/assets/categories/" . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            $image_update_query = "INSERT INTO category_images (category_id, image_path) 
                                   VALUES ($category_id, '$target_file')
                                   ON DUPLICATE KEY UPDATE image_path = '$target_file'";
            mysqli_query($conn, $image_update_query);
        }
    }

    // Add new products to this category
    if (isset($_POST['add_products'])) {
        foreach ($_POST['add_products'] as $product_id) {
            $add_product_query = "INSERT INTO product_categories (product_id, category_id) VALUES ($product_id, $category_id)";
            mysqli_query($conn, $add_product_query);
        }
    }

    // Remove selected products from this category
    if (isset($_POST['remove_products'])) {
        foreach ($_POST['remove_products'] as $product_id) {
            $remove_product_query = "DELETE FROM product_categories WHERE product_id = $product_id AND category_id = $category_id";
            mysqli_query($conn, $remove_product_query);
        }
    }

    header("Location: category.php?id=$category_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>

<div class="container mt-4">
    <h1>Edit Category</h1>

    <form method="POST" action="edit_category.php?id=<?php echo $category_id; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category['name']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $category['description']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="featured" class="form-label">Feature Category</label>
            <input type="checkbox" id="featured" name="featured" <?php echo $category['featured'] ? 'checked' : ''; ?>>
        </div>

        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label><br>
            <?php if (!empty($category['image_path'])) { ?>
                <img src="<?php echo $category['image_path']; ?>" alt="Category Image" width="100"><br>
                <small>Current Image</small><br>
            <?php } ?>
            <input type="file" name="category_image">
        </div>

        <h3>Remove Products from this Category</h3>
        <?php if (mysqli_num_rows($current_products_result) > 0): ?>
            <div class="mb-3">
                <?php while ($product = mysqli_fetch_assoc($current_products_result)): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remove_products[]" value="<?php echo $product['id']; ?>">
                        <label class="form-check-label">
                            <?php echo $product['name']; ?> (SKU: <?php echo $product['sku']; ?>)
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No products currently assigned to this category.</p>
        <?php endif; ?>

        <h3>Add Products to this Category</h3>
        <?php if (mysqli_num_rows($all_products_result) > 0): ?>
            <div class="mb-3">
                <?php while ($product = mysqli_fetch_assoc($all_products_result)): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="add_products[]" value="<?php echo $product['id']; ?>">
                        <label class="form-check-label">
                            <?php echo $product['name']; ?> (SKU: <?php echo $product['sku']; ?>)
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No available products to add to this category.</p>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="category.php?id=<?php echo $category_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>