<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];

    // Start transaction
    mysqli_begin_transaction($conn);

    // Insert into the main_categories table (without the is_featured column)
    $query = "INSERT INTO main_categories (name, description) VALUES ('$category_name', '$description')";
    
    if (mysqli_query($conn, $query)) {
        $category_id = mysqli_insert_id($conn); // Get the last inserted ID for the category
        
        // Handle the image upload if an image was provided
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
            $image = $_FILES['category_image'];
            $target_file = "/e-commerce/assets/category_images/" . basename($image["name"]);

            // Move the uploaded image to the target directory
            if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                // Insert image path into the category_images table
                $image_query = "INSERT INTO category_images (category_id, image_path) VALUES ($category_id, '$target_file')";
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
        
        // Commit the transaction if all queries were successful
        mysqli_commit($conn);
        header("Location: category_list.php");
        exit();
    } else {
        // Rollback the transaction if the category insert failed
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
    <title>Add New Category</title>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Add New Category</h1>

    <form method="POST" action="main_category_form.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
        <a href="category_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>