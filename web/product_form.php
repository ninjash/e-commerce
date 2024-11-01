<?php
session_start();
require 'db_connect.php';
require '../classes/Product.php';

// Enable detailed MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$target_dir = "/e-commerce/assets/products/";

// Initialize products in session if not set
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

// Fetch all attributes
$attributes_query = "SELECT * FROM attributes";
$attributes_result = mysqli_query($conn, $attributes_query);

// Fetch all main categories (where parent_id is NULL)
$main_category_query = "SELECT id, name FROM categories WHERE parent_id IS NULL";
$main_category_result = mysqli_query($conn, $main_category_query);

// Fetch all manufacturers
$manufacturer_query = "SELECT id, name FROM manufacturers";
$manufacturer_result = mysqli_query($conn, $manufacturer_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    // Handle product addition logic
    $name = htmlspecialchars(trim($_POST['name']));
    $sku = htmlspecialchars(trim($_POST['sku']));
    $short_description = htmlspecialchars(trim($_POST['short_description']));
    $price = floatval($_POST['price']);
    $description = htmlspecialchars(trim($_POST['description']));
    $feature_product = isset($_POST['feature_product']) ? 1 : 0;
    $categories = array_map('intval', $_POST['categories']); // Sanitize category IDs
    $manufacturer_id = intval($_POST['manufacturer_id']);

    // Handle file upload with validation
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $main_image = $_FILES['main_image'];
        $imageFileType = strtolower(pathinfo($main_image["name"], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowedTypes)) {
            echo "Invalid file type. Only JPG, JPEG, PNG & GIF are allowed.";
        } elseif ($main_image["size"] > 5000000) { // Limit file size to 5MB
            echo "File is too large.";
        } else {
            $target_file = $target_dir . basename($main_image["name"]);
            if (move_uploaded_file($main_image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                // Collect attributes data
                $attributes = [];
                if (isset($_POST['attributes'])) {
                    foreach ($_POST['attributes'] as $attribute_id => $value) {
                        $attributes[$attribute_id] = htmlspecialchars(trim($value));
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
                    'manufacturer_id' => $manufacturer_id,
                    'attributes' => $attributes
                ];

                $_SESSION['products'][] = $product_data;

                echo "Product added successfully. Add another product or save all.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product'])) {
    $remove_index = intval($_POST['remove_index']);

    // Remove the product from the session array
    if (isset($_SESSION['products'][$remove_index])) {
        array_splice($_SESSION['products'], $remove_index, 1);
    }

    echo "Product removed successfully.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_products'])) {
    $productClass = new Product($conn); // Instantiate the Product class
    foreach ($_SESSION['products'] as $productData) {
        $productClass->saveProduct($productData); // Save each product
    }
    $_SESSION['products'] = [];
    echo "All products have been saved!";
    header("Location: product_list.php");
    exit;
}
?>

<!-- HTML Form to Add Product -->
<form method="POST" action="product_form.php" enctype="multipart/form-data">
    <h2>Add New Product</h2>
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

    <!-- Manufacturer Dropdown -->
    <label>Manufacturer</label><br>
    <select name="manufacturer_id" required>
        <option value="">Select Manufacturer</option>
        <?php while ($manufacturer = mysqli_fetch_assoc($manufacturer_result)): ?>
            <option value="<?php echo $manufacturer['id']; ?>"><?php echo htmlspecialchars($manufacturer['name']); ?></option>
        <?php endwhile; ?>
    </select><br>

    <!-- Categories Block (with dynamic dropdowns for main, second, and third categories) -->
    <div id="categories-container">
        <div class="category-assignment">
            <label>Assign Category</label><br>

            <select class="main_category" name="main_category[]">
                <option value="">Select Main Category</option>
                <?php while ($main_category = mysqli_fetch_assoc($main_category_result)): ?>
                    <option value="<?php echo $main_category['id']; ?>"><?php echo htmlspecialchars($main_category['name']); ?></option>
                <?php endwhile; ?>
            </select><br>

            <select class="second_category" name="second_category[]" style="display:none;">
                <option value="">Select Second Category</option>
            </select><br>

            <select class="third_category" name="categories[]" style="display:none;">
                <option value="">Select Third Category</option>
            </select><br>
        </div>
    </div>

    <button type="button" id="add-category-assignment">Add Another Category</button><br><br>

    <label>Main Image</label><br>
    <input type="file" name="main_image" required><br>

    <h3>Product Attributes</h3>
    <?php if (mysqli_num_rows($attributes_result) > 0): ?>
        <?php while ($attribute = mysqli_fetch_assoc($attributes_result)): ?>
            <label><?php echo htmlspecialchars($attribute['name']); ?></label>
            <input type="text" name="attributes[<?php echo $attribute['id']; ?>]" placeholder="Enter <?php echo htmlspecialchars($attribute['name']); ?>"><br>
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
        <?php foreach ($_SESSION['products'] as $index => $product): ?>
            <li>
                <?php echo htmlspecialchars($product['name']); ?> - <?php echo htmlspecialchars($product['sku']); ?>
                <form method="POST" action="product_form.php" style="display:inline;">
                    <input type="hidden" name="remove_index" value="<?php echo $index; ?>">
                    <button type="submit" name="remove_product">Remove</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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