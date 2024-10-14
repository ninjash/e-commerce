<?php
require 'db_connect.php';

// Check if the second category ID is provided
if (!isset($_GET['id'])) {
    echo "Second Category ID is missing.";
    exit;
}

$second_category_id = $_GET['id'];

// Fetch second category details
$category_query = "SELECT sc.id AS second_category_id, sc.name AS second_category_name, sc.description, ci.image_path
                   FROM second_categories sc
                   LEFT JOIN category_images ci ON sc.id = ci.second_category_id  -- Corrected column to second_category_id
                   WHERE sc.id = $second_category_id";
$category_result = mysqli_query($conn, $category_query);

if (!$category_result || mysqli_num_rows($category_result) == 0) {
    echo "Second Category not found.";
    exit;
}

$category = mysqli_fetch_assoc($category_result);

// Fetch all third categories with information whether they are assigned to the current second category or not
$third_category_query = "
    SELECT tc.id, tc.name, tc.second_category_id
    FROM third_categories tc";
$third_category_result = mysqli_query($conn, $third_category_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];

    // Update second category details
    $update_category_query = "UPDATE second_categories 
                              SET name = '$category_name', description = '$description'
                              WHERE id = $second_category_id";
    mysqli_query($conn, $update_category_query);

    // Handle image upload if provided
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
        $image = $_FILES['category_image'];
        $target_file = "/e-commerce/assets/categories/" . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            $image_update_query = "INSERT INTO category_images (second_category_id, image_path)  -- Updated to second_category_id
                                   VALUES ($second_category_id, '$target_file')
                                   ON DUPLICATE KEY UPDATE image_path = '$target_file'";
            mysqli_query($conn, $image_update_query);
        }
    }

    // Add or remove third categories
    if (isset($_POST['third_categories'])) {
        // Set a valid ID to avoid NULL values
        $default_second_category_id = 1;  // Replace with a valid second_category_id
        
        // Clear all current assignments
        $clear_category_query = "UPDATE third_categories SET second_category_id = $default_second_category_id WHERE second_category_id = $second_category_id";
        mysqli_query($conn, $clear_category_query);

        // Re-assign selected third categories to the second category
        foreach ($_POST['third_categories'] as $third_category_id) {
            $assign_category_query = "UPDATE third_categories SET second_category_id = $second_category_id WHERE id = $third_category_id";
            mysqli_query($conn, $assign_category_query);
        }
    }

    header("Location: view_second_category.php?second_id=$second_category_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Second Category</title>
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
    <h1>Edit Second Category</h1>

    <form method="POST" action="edit_second_category.php?id=<?php echo $second_category_id; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category['second_category_name']; ?>" required>
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

        <h3>Select Third Categories for this Second Category</h3>
        <?php if (mysqli_num_rows($third_category_result) > 0) { ?>
            <div class="scrollable-checkboxes"> <!-- Scrollable div -->
                <?php while ($third_category = mysqli_fetch_assoc($third_category_result)) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="third_categories[]" value="<?php echo $third_category['id']; ?>"
                            <?php echo $third_category['second_category_id'] == $second_category_id ? 'checked' : ''; ?>>
                        <label class="form-check-label">
                            <?php echo $third_category['name']; ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No third categories available.</p>
        <?php } ?>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="view_second_category.php?second_id=<?php echo $second_category_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>