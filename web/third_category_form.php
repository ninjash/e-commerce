<?php
require 'db_connect.php';

// Get the second_category_id from the URL, if provided
$selected_second_category_id = isset($_GET['second_category_id']) ? $_GET['second_category_id'] : '';

// Fetch the list of second categories for the dropdown
$second_category_query = "SELECT id, name FROM second_categories";
$second_category_result = mysqli_query($conn, $second_category_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $third_category_name = $_POST['third_category_name'];
    $description = $_POST['description'];
    $second_category_id = $_POST['second_category_id']; // Get the selected second category ID from the dropdown
    $is_featured = isset($_POST['is_featured']) ? 1 : 0; // Check if the category should be featured

    // Start transaction
    mysqli_begin_transaction($conn);

    // Insert into the third_categories table
    $query = "INSERT INTO third_categories (name, description, second_category_id, is_featured) 
              VALUES ('$third_category_name', '$description', $second_category_id, $is_featured)";
    
    if (mysqli_query($conn, $query)) {
        $third_category_id = mysqli_insert_id($conn); // Get the last inserted ID for the third category

        // Handle the image upload if an image was provided
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
            $image = $_FILES['category_image'];
            $target_file = "/e-commerce/assets/category_images/" . basename($image["name"]);

            // Move the uploaded image to the target directory
            if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                // Insert image path into the category_images table
                $image_query = "INSERT INTO category_images (third_category_id, image_path) VALUES ($third_category_id, '$target_file')";
                if (!mysqli_query($conn, $image_query)) {
                    mysqli_rollback($conn);
                    echo "Error inserting image: " . mysqli_error($conn);
                    exit();
                }
            } else {
                mysqli_rollback($conn);
                echo "Error uploading image.";
                exit();
            }
        }

        // Commit the transaction if the query is successful
        mysqli_commit($conn);
        // Redirect to the view_second_category.php with the selected second_category_id
        header("Location: view_second_category.php?second_id=" . $second_category_id);
        exit();
    } else {
        // Rollback the transaction if the insert failed
        mysqli_rollback($conn);
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Third Category</title>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Add New Third Category</h1>

    <form method="POST" action="third_category_form.php<?php echo isset($_GET['second_category_id']) ? '?second_category_id=' . $_GET['second_category_id'] : ''; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="third_category_name" class="form-label">Third Category Name</label>
            <input type="text" class="form-control" id="third_category_name" name="third_category_name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="second_category_id" class="form-label">Assign to Second Category</label>
            <select class="form-select" id="second_category_id" name="second_category_id" required>
                <option value="" disabled>Select Second Category</option>
                <?php while ($second_category = mysqli_fetch_assoc($second_category_result)) { ?>
                    <option value="<?php echo $second_category['id']; ?>"
                        <?php echo ($second_category['id'] == $selected_second_category_id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($second_category['name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured">
            <label for="is_featured" class="form-check-label">Mark as Featured Category</label>
        </div>

        <button type="submit" class="btn btn-primary">Add Third Category</button>
        <a href="view_second_category.php?second_id=<?php echo $selected_second_category_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>