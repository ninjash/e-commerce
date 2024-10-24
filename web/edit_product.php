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

// Fetch manufacturers for the dropdown
$manufacturers_query = "SELECT id, name FROM manufacturers";
$manufacturers_result = mysqli_query($conn, $manufacturers_query);

// Fetch existing product categories
$product_categories_query = "SELECT category_id FROM product_categories WHERE product_id = $product_id";
$product_categories_result = mysqli_query($conn, $product_categories_query);

$product_categories = [];
while ($row = mysqli_fetch_assoc($product_categories_result)) {
    $product_categories[] = $row['category_id'];
}

// Fetch all categories (main, second, third level categories)
$categories_query = "SELECT * FROM categories ORDER BY parent_id ASC";
$categories_result = mysqli_query($conn, $categories_query);
$categories = [];
while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories[$row['parent_id']][] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $price = floatval($_POST['price']);
    $old_price = floatval($_POST['old_price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $feature_product = isset($_POST['feature_product']) ? 1 : 0;
    $manufacturer_id = intval($_POST['manufacturer_id']);
    $selected_categories = $_POST['categories'];

    // Update product details
    $update_query = "UPDATE products 
                     SET name = '$name', sku = '$sku', short_description = '$short_description', 
                         price = $price, old_price = $old_price, description = '$description', 
                         feature_product = $feature_product, manufacturer_id = $manufacturer_id
                     WHERE id = $product_id";
    
    if (mysqli_query($conn, $update_query)) {
        // Update product categories
        mysqli_query($conn, "DELETE FROM product_categories WHERE product_id = $product_id");

        // Ensure that selected_categories is not empty and has valid category_ids
        if (!empty($selected_categories) && is_array($selected_categories)) {
            foreach ($selected_categories as $category_id) {
                if (!empty($category_id) && is_numeric($category_id)) {
                    $category_insert_query = "INSERT INTO product_categories (product_id, category_id) 
                                              VALUES ($product_id, $category_id)";
                    mysqli_query($conn, $category_insert_query);
                }
            }
        }

        // If a new image was uploaded, update the product image
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
            $main_image = $_FILES['main_image'];
            $target_file = "/e-commerce/assets/products/" . basename($main_image["name"]);

            if (move_uploaded_file($main_image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                $image_query = "UPDATE product_images SET image_path = '$target_file' WHERE product_id = $product_id";
                mysqli_query($conn, $image_query);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        <!-- Manufacturer dropdown -->
        <label>Manufacturer</label><br>
        <select name="manufacturer_id" required>
            <?php while ($manufacturer = mysqli_fetch_assoc($manufacturers_result)): ?>
                <option value="<?php echo $manufacturer['id']; ?>" <?php echo $manufacturer['id'] == $product['manufacturer_id'] ? 'selected' : ''; ?>>
                    <?php echo $manufacturer['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <!-- Categories Block (pre-selected) -->
        <div id="categories-container">
            <div class="category-assignment">
                <label>Assign Category</label><br>

                <!-- Pre-selecting the main, second, and third categories based on product -->
                <select class="main_category" name="categories[]">
                    <option value="">Select Main Category</option>
                    <?php foreach ($categories[''] as $main_category): ?>
                        <option value="<?php echo $main_category['id']; ?>" <?php echo in_array($main_category['id'], $product_categories) ? 'selected' : ''; ?>>
                            <?php echo $main_category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select class="second_category" name="categories[]">
                    <option value="">Select Second Category</option>
                    <?php if (isset($categories[$main_category['id']])): ?>
                        <?php foreach ($categories[$main_category['id']] as $second_category): ?>
                            <option value="<?php echo $second_category['id']; ?>" <?php echo in_array($second_category['id'], $product_categories) ? 'selected' : ''; ?>>
                                <?php echo $second_category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select><br>

                <select class="third_category" name="categories[]">
                    <option value="">Select Third Category</option>
                    <?php if (isset($categories[$second_category['id']])): ?>
                        <?php foreach ($categories[$second_category['id']] as $third_category): ?>
                            <option value="<?php echo $third_category['id']; ?>" <?php echo in_array($third_category['id'], $product_categories) ? 'selected' : ''; ?>>
                                <?php echo $third_category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
        function setupCategoryDropdowns(categoryBlock) {
            $(categoryBlock).find('.main_category').change(function() {
                var main_category_id = $(this).val();
                var secondCategoryDropdown = $(this).closest('.category-assignment').find('.second_category');
                var thirdCategoryDropdown = $(this).closest('.category-assignment').find('.third_category');
                
                if(main_category_id) {
                    $.ajax({
                        url: 'fetch_categories.php',
                        method: 'POST',
                        data: { main_category_id: main_category_id },
                        success: function(response) {
                            secondCategoryDropdown.html(response).show();
                            thirdCategoryDropdown.hide();
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + status + " - " + error);
                        }
                    });
                } else {
                    secondCategoryDropdown.hide();
                    thirdCategoryDropdown.hide();
                }
            });

            $(categoryBlock).find('.second_category').change(function() {
                var second_category_id = $(this).val();
                var thirdCategoryDropdown = $(this).closest('.category-assignment').find('.third_category');

                if(second_category_id) {
                    $.ajax({
                        url: 'fetch_categories.php',
                        method: 'POST',
                        data: { second_category_id: second_category_id },
                        success: function(response) {
                            thirdCategoryDropdown.html(response).show();
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + status + " - " + error);
                        }
                    });
                } else {
                    thirdCategoryDropdown.hide();
                }
            });
        }

        // Initialize first category assignment
        setupCategoryDropdowns($('.category-assignment').first());

        // Handle the "Add Another Category" button
        $('#add-category-assignment').click(function() {
            var newCategoryBlock = $('.category-assignment').first().clone();
            newCategoryBlock.find('select').val('');  // Reset the selects
            newCategoryBlock.find('.second_category, .third_category').hide();  // Hide second and third category initially
            $('#categories-container').append(newCategoryBlock);

            // Initialize the new block's dropdowns
            setupCategoryDropdowns(newCategoryBlock);
        });
    });
</script>

</body>
</html>
