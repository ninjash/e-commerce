<?php
require 'db_connect.php';

// Check if the main category ID is provided
if (!isset($_GET['id'])) {
    echo "Main Category ID is missing.";
    exit;
}

$main_category_id = $_GET['id'];

// Fetch main category details
$category_query = "SELECT mc.id AS main_category_id, mc.name AS main_category_name, mc.description, ci.image_path
                   FROM main_categories mc
                   LEFT JOIN category_images ci ON mc.id = ci.main_category_id  -- Corrected join
                   WHERE mc.id = $main_category_id";
$category_result = mysqli_query($conn, $category_query);

if (!$category_result || mysqli_num_rows($category_result) == 0) {
    echo "Main Category not found.";
    exit;
}

$category = mysqli_fetch_assoc($category_result);

// Fetch all second categories with information whether they are assigned to the current main category or not
$second_category_query = "
    SELECT sc.id, sc.name, sc.main_category_id
    FROM second_categories sc";
$second_category_result = mysqli_query($conn, $second_category_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];

    // Update category details
    $update_category_query = "UPDATE main_categories 
                              SET name = '$category_name', description = '$description'
                              WHERE id = $main_category_id";
    mysqli_query($conn, $update_category_query);

    // Handle image upload if provided
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
        $image = $_FILES['category_image'];
        $target_file = "/e-commerce/assets/categories/" . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            $image_update_query = "INSERT INTO category_images (main_category_id, image_path)  -- Updated main_category_id
                                   VALUES ($main_category_id, '$target_file')
                                   ON DUPLICATE KEY UPDATE image_path = '$target_file'";
            mysqli_query($conn, $image_update_query);
        }
    }

    // Add or remove second categories
    if (isset($_POST['second_categories'])) {
        // Clear all current assignments
        $clear_category_query = "UPDATE second_categories SET main_category_id = NULL WHERE main_category_id = $main_category_id";
        mysqli_query($conn, $clear_category_query);

        // Ensure main_category_id exists before assigning
        $check_main_category_query = "SELECT id FROM main_categories WHERE id = $main_category_id";
        $check_result = mysqli_query($conn, $check_main_category_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Re-assign selected second categories to the main category
            foreach ($_POST['second_categories'] as $second_category_id) {
                $assign_category_query = "UPDATE second_categories SET main_category_id = $main_category_id WHERE id = $second_category_id";
                mysqli_query($conn, $assign_category_query);
            }
        } else {
            echo "Error: Main Category ID does not exist.";
            exit;
        }
    }

    header("Location: view_main_category.php?id=$main_category_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Main Category</title>
    <style>
        .scrollable-checkboxes {
            max-height: 150px; /* Set max height */
            overflow-y: scroll; /* Enable vertical scrolling */
            border: 1px solid #ccc; /* Add border for clarity */
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h1>Edit Main Category</h1>

    <form method="POST" action="edit_main_category.php?id=<?php echo $main_category_id; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category['main_category_name']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $category['description']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label><br>
            <?php if (!empty($category['image_path'])) { ?>
                <img src="<?php echo $category['image_path']; ?>" alt="Category Image" width="100"><br>
                <small>Current Image</small><br>
            <?php } ?>
            <input type="file" name="category_image">
        </div>

        <h3>Select Second Categories for this Main Category</h3>
        <?php if (mysqli_num_rows($second_category_result) > 0) { ?>
            <div class="scrollable-checkboxes"> <!-- Scrollable div -->
                <?php while ($second_category = mysqli_fetch_assoc($second_category_result)) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="second_categories[]" value="<?php echo $second_category['id']; ?>"
                            <?php echo $second_category['main_category_id'] == $main_category_id ? 'checked' : ''; ?>>
                        <label class="form-check-label">
                            <?php echo $second_category['name']; ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No second categories available.</p>
        <?php } ?>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="category_list.php?id=<?php echo $main_category_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>