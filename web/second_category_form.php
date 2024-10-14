<?php
require 'db_connect.php';

// Get the main_category_id from the URL, if provided
$selected_main_category_id = isset($_GET['main_category_id']) ? $_GET['main_category_id'] : '';

// Fetch the list of main categories for the dropdown
$main_category_query = "SELECT id, name FROM main_categories";
$main_category_result = mysqli_query($conn, $main_category_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $second_category_name = $_POST['second_category_name'];
    $description = $_POST['description'];
    $main_category_id = $_POST['main_category_id']; // Get the selected main category ID from the dropdown

    // Start transaction
    mysqli_begin_transaction($conn);

    // Insert into the second_categories table
    $query = "INSERT INTO second_categories (name, description, main_category_id) VALUES ('$second_category_name', '$description', $main_category_id)";
    
    if (mysqli_query($conn, $query)) {
        $second_category_id = mysqli_insert_id($conn); // Get the last inserted ID for second category

        // Handle the image upload if provided
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
            $image = $_FILES['category_image'];
            $target_file = "/e-commerce/assets/category_images/" . basename($image["name"]);

            // Move the uploaded image to the target directory
            if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                // Insert the image path into the category_images table
                $image_query = "INSERT INTO category_images (second_category_id, image_path) VALUES ($second_category_id, '$target_file')";
                if (!mysqli_query($conn, $image_query)) {
                    mysqli_rollback($conn); // Rollback the transaction if image insertion fails
                    echo "Error inserting image: " . mysqli_error($conn);
                    exit();
                }
            } else {
                mysqli_rollback($conn); // Rollback the transaction if the file upload fails
                echo "Error uploading image.";
                exit();
            }
        }

        // Commit the transaction if the query is successful
        mysqli_commit($conn);
        // Redirect to the view_main_category.php with the selected main_category_id
        header("Location: view_main_category.php?id=" . $main_category_id);
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
    <title>Add New Second Category</title>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Add New Second Category</h1>

    <form method="POST" action="second_category_form.php<?php echo isset($_GET['main_category_id']) ? '?main_category_id=' . $_GET['main_category_id'] : ''; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="second_category_name" class="form-label">Second Category Name</label>
            <input type="text" class="form-control" id="second_category_name" name="second_category_name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="main_category_id" class="form-label">Assign to Main Category</label>
            <select class="form-select" id="main_category_id" name="main_category_id" required>
                <option value="" disabled>Select Main Category</option>
                <?php while ($main_category = mysqli_fetch_assoc($main_category_result)) { ?>
                    <option value="<?php echo $main_category['id']; ?>"
                        <?php echo ($main_category['id'] == $selected_main_category_id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($main_category['name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Add Second Category</button>

        <!-- Modify the Cancel button to redirect back to the view_main_category.php with the selected main_category_id -->
        <a href="view_main_category.php?id=<?php echo $selected_main_category_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>