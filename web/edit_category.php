<?php
require 'db_connect.php';

// Check if the category ID is provided
if (!isset($_GET['id'])) {
    echo "Category ID is missing.";
    exit;
}

$category_id = (int)$_GET['id']; // Ensure it's an integer to avoid SQL injection issues

// Fetch category details including the 'featured' field
$category_query = "SELECT c.id AS category_id, c.name AS category_name, c.description, c.parent_id, c.featured, ci.image_path
                   FROM categories c
                   LEFT JOIN category_images ci ON c.id = ci.category_id
                   WHERE c.id = ?";
$stmt = $conn->prepare($category_query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$category_result = $stmt->get_result();

if ($category_result->num_rows == 0) {
    echo "Category not found.";
    exit;
}

$category = $category_result->fetch_assoc();

// Fetch all main categories (for assigning second categories)
$main_categories = $conn->query("SELECT id, name FROM categories WHERE parent_id IS NULL");

// Fetch all second categories grouped by their main categories (for assigning third categories)
$second_categories = $conn->query("
    SELECT sc.id AS second_id, sc.name AS second_name, mc.id AS main_id, mc.name AS main_name
    FROM categories sc
    JOIN categories mc ON sc.parent_id = mc.id
    WHERE sc.parent_id IS NOT NULL
");

// Organize second categories under their respective main categories
$grouped_second_categories = [];
while ($row = $second_categories->fetch_assoc()) {
    $grouped_second_categories[$row['main_name']][] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_type = $_POST['category_type'];
    $category_name = $_POST['name'];
    $description = $_POST['description'];
    $parent_id = null; // Default to NULL for main categories
    $featured = isset($_POST['featured']) ? 1 : 0;  // Check if the "featured" checkbox is checked

    // Set the parent ID based on the category type
    if ($category_type == 'second') {
        $parent_id = !empty($_POST['main_category']) ? (int)$_POST['main_category'] : null;  // For second category
    } elseif ($category_type == 'third') {
        $parent_id = !empty($_POST['second_category']) ? (int)$_POST['second_category'] : null;  // For third category
    }

    // Prepare the update query and handle NULL parent_id
    $update_category_query = "UPDATE categories SET name = ?, description = ?, parent_id = ?, featured = ? WHERE id = ?";
    $stmt = $conn->prepare($update_category_query);
    $stmt->bind_param("ssiii", $category_name, $description, $parent_id, $featured, $category_id);

    if ($stmt->execute()) {
        // Check if image was uploaded
        if (isset($_FILES['category_images']) && $_FILES['category_images']['error'] == 0) {
            $image = $_FILES['category_images'];
            $target_dir = "/e-commerce/assets/category_images/";
            $target_file = $target_dir . basename($image["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $max_file_size = 2 * 1024 * 1024; // 2MB file size limit

            // Check file size
            if ($image['size'] > $max_file_size) {
                echo "Sorry, your file is too large. Maximum size is 2MB.";
                exit;
            }

            // Check if image file is a valid format
            $valid_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array($imageFileType, $valid_image_types)) {

                // Ensure the directory exists
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $target_dir)) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . $target_dir, 0777, true);
                }

                // Move uploaded file to the target directory
                if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                    // Insert or update category image in the database
                    $image_update_query = "INSERT INTO category_images (category_id, image_path)
                                           VALUES (?, ?)
                                           ON DUPLICATE KEY UPDATE image_path = ?";
                    $stmt = $conn->prepare($image_update_query);
                    $stmt->bind_param("iss", $category_id, $target_file, $target_file);

                    if ($stmt->execute()) {
                        echo "Image saved successfully.";
                    } else {
                        echo "Error saving image to database: " . $conn->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Invalid file type. Please upload a JPG, JPEG, PNG, or GIF image.";
            }
        }

        // Redirect back to the category list or view page
        header("Location: category.php?id=$category_id");
        exit();
    } else {
        echo "Error updating category: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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
    <h1>Edit Category</h1>

    <form method="POST" action="edit_category.php?id=<?php echo $category_id; ?>" enctype="multipart/form-data">
        <!-- Category Type (Hidden or Read-only for Editing) -->
        <div class="mb-3">
            <label for="category_type" class="form-label">Category Type</label>
            <select class="form-control" id="category_type" name="category_type" onchange="toggleCategoryType()" required>
                <option value="main" <?php echo is_null($category['parent_id']) ? 'selected' : ''; ?>>Main Category</option>
                <option value="second" <?php echo isset($category['parent_id']) && is_null($category['parent_id']) === false ? 'selected' : ''; ?>>Second Category</option>
                <option value="third" <?php echo isset($category['parent_id']) && isset($grouped_second_categories) ? 'selected' : ''; ?>>Third Category</option>
            </select>
        </div>

        <!-- Category Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
        </div>

        <!-- Category Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($category['description']); ?></textarea>
        </div>

        <!-- Main Category selection for Second Categories -->
        <div class="mb-3" id="main_category_select" style="display:<?php echo isset($category['parent_id']) && is_null($category['parent_id']) ? 'none' : 'block'; ?>;">
            <label for="main_category" class="form-label">Select Main Category</label>
            <select class="form-control" name="main_category">
                <option value="">Select Main Category</option>
                <?php while ($main_category = $main_categories->fetch_assoc()) { ?>
                    <option value="<?php echo $main_category['id']; ?>" <?php echo ($category['parent_id'] == $main_category['id']) ? 'selected' : ''; ?>>
                        <?php echo $main_category['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Second Category selection for Third Categories, grouped by Main Category -->
        <div class="mb-3" id="second_category_select" style="display:<?php echo isset($category['parent_id']) && isset($grouped_second_categories) ? 'block' : 'none'; ?>;">
            <label for="second_category" class="form-label">Select Second Category</label>
            <select class="form-control" name="second_category">
                <option value="">Select Second Category</option>
                <?php foreach ($grouped_second_categories as $main_category_name => $second_category_list) { ?>
                    <optgroup label="<?php echo $main_category_name; ?>">
                        <?php foreach ($second_category_list as $second_category) { ?>
                            <option value="<?php echo $second_category['second_id']; ?>" <?php echo ($category['parent_id'] == $second_category['second_id']) ? 'selected' : ''; ?>>
                                <?php echo $second_category['second_name']; ?>
                            </option>
                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
        </div>

        <!-- Category Image -->
        <div class="mb-3">
            <label for="category_images" class="form-label">Category Image</label><br>
            <?php if (!empty($category['image_path'])) { ?>
                <img src="<?php echo $category['image_path']; ?>" alt="Category Image" width="100"><br>
                <small>Current Image</small><br>
            <?php } ?>
            <input type="file" name="category_images">
        </div>
        
        <!-- Featured Checkbox -->
        <div class="mb-3">
            <label for="featured" class="form-label">Featured</label>
            <input type="checkbox" id="featured" name="featured" <?php echo ($category['featured'] == 1) ? 'checked' : ''; ?>>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Save Changes</button>
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
$conn->close();
?>