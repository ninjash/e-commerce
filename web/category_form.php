<?php
require 'db_connect.php';

// Fetch all main categories
$main_categories = mysqli_query($conn, "SELECT id, name FROM categories WHERE parent_id IS NULL");

// Fetch all second categories along with their parent main categories
$second_categories = mysqli_query($conn, "
    SELECT sc.id AS second_id, sc.name AS second_name, mc.id AS main_id, mc.name AS main_name
    FROM categories sc
    JOIN categories mc ON sc.parent_id = mc.id
    WHERE sc.parent_id IS NOT NULL
");

// Organize second categories under their respective main categories
$grouped_second_categories = [];
while ($row = mysqli_fetch_assoc($second_categories)) {
    $grouped_second_categories[$row['main_name']][] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_type = $_POST['category_type'];
    $category_name = $_POST['name'];
    $description = $_POST['description'];
    $parent_id = NULL; // Default to NULL for main categories

    // Set the parent ID based on the category type
    if ($category_type == 'second') {
        $parent_id = !empty($_POST['main_category']) ? $_POST['main_category'] : NULL;  // For second category
    } elseif ($category_type == 'third') {
        $parent_id = !empty($_POST['second_category']) ? $_POST['second_category'] : NULL;  // For third category
    }

    // Use prepared statement to insert the new category into the `categories` table
    $insert_category_query = "INSERT INTO categories (name, description, parent_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_category_query);
    mysqli_stmt_bind_param($stmt, "ssi", $category_name, $description, $parent_id);

    if (mysqli_stmt_execute($stmt)) {
        $category_id = mysqli_insert_id($conn); // Get the last inserted ID for the category

        // Handle the image upload if an image was provided
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
            $image = $_FILES['category_image'];
            $target_file = "/e-commerce/assets/category_images/" . basename($image["name"]);

            // Move the uploaded image to the target directory
            if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                // Insert image path into the category_images table using prepared statements
                $image_query = "INSERT INTO category_images (category_id, image_path) VALUES (?, ?)";
                $stmt_image = mysqli_prepare($conn, $image_query);
                mysqli_stmt_bind_param($stmt_image, "is", $category_id, $target_file);

                if (!mysqli_stmt_execute($stmt_image)) {
                    echo "Error inserting image: " . mysqli_error($conn);
                    exit();
                }
            } else {
                echo "Error uploading image.";
                exit();
            }
        }

        // Redirect to the category list or success page
        header("Location: category_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);  // Close the statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <script>
        // JavaScript function to toggle category dropdowns based on category type
        function toggleCategoryType() {
            var categoryType = document.getElementById('category_type').value;
            document.getElementById('main_category_select').style.display = (categoryType === 'second') ? 'block' : 'none';
            document.getElementById('second_category_select').style.display = (categoryType === 'third') ? 'block' : 'none';
        }
    </script>
</head>
<body>

<div class="container mt-4">
    <h1>Create New Category</h1>

    <form method="POST" action="category_form.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="category_type" class="form-label">Category Type</label>
            <select class="form-control" id="category_type" name="category_type" onchange="toggleCategoryType()" required>
                <option value="main">Main Category</option>
                <option value="second">Second Category</option>
                <option value="third">Third Category</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <!-- Main Category selection for Second Categories -->
        <div class="mb-3" id="main_category_select" style="display:none;">
            <label for="main_category" class="form-label">Select Main Category</label>
            <select class="form-control" name="main_category">
                <option value="">Select Main Category</option>
                <?php while ($main_category = mysqli_fetch_assoc($main_categories)) { ?>
                    <option value="<?php echo $main_category['id']; ?>"><?php echo $main_category['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- Second Category selection for Third Categories, grouped by Main Category -->
        <div class="mb-3" id="second_category_select" style="display:none;">
            <label for="second_category" class="form-label">Select Second Category</label>
            <select class="form-control" name="second_category">
                <option value="">Select Second Category</option>
                <?php foreach ($grouped_second_categories as $main_category_name => $second_category_list) { ?>
                    <optgroup label="<?php echo $main_category_name; ?>"> <!-- Grouped by main category -->
                        <?php foreach ($second_category_list as $second_category) { ?>
                            <option value="<?php echo $second_category['second_id']; ?>">
                                <?php echo $second_category['second_name']; ?>
                            </option>
                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
        <a href="category_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    // Initial call to set the form state correctly
    toggleCategoryType();
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>