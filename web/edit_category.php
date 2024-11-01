<?php
require 'db_connect.php';
require_once '../classes/Category.php';

// Check if the category ID is provided
if (!isset($_GET['id'])) {
    echo "Category ID is missing.";
    exit;
}

$category_id = (int)$_GET['id']; // Ensure it's an integer

// Instantiate the Category class and fetch details
$categoryClass = new Category($conn, $category_id);
$category_name = $categoryClass->getName();
$description = $categoryClass->getDescription();
$parent_id = $categoryClass->getParentId();
$featured = $categoryClass->getFeatured();
$image_path = $categoryClass->getImagePath();

// Fetch all main categories for assigning second categories
$main_categories = Category::getMainCategories($conn);

// Fetch all second categories grouped by their main categories for assigning third categories
$second_categories = Category::getSecondLevelCategoriesWithParentNames($conn);
$grouped_second_categories = [];
foreach ($second_categories as $second_category) {
    $grouped_second_categories[$second_category['parent_name']][] = $second_category;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_type = $_POST['category_type'];
    $category_name = $_POST['name'];
    $description = $_POST['description'];
    $parent_id = null; // Default to NULL for main categories
    $featured = isset($_POST['featured']) ? 1 : 0;

    // Set the parent ID based on the category type
    if ($category_type == 'second') {
        $parent_id = !empty($_POST['main_category']) ? (int)$_POST['main_category'] : null; // For second category
    } elseif ($category_type == 'third') {
        $parent_id = !empty($_POST['second_category']) ? (int)$_POST['second_category'] : null; // For third category
    }

    // Update the Category object
    $categoryClass->setName($category_name);
    $categoryClass->setDescription($description);
    $categoryClass->setParentId($parent_id);
    $categoryClass->setFeatured($featured);

    if ($categoryClass->update()) {
        // Check if an image was uploaded
        if (isset($_FILES['category_images']) && $_FILES['category_images']['error'] == 0) {
            $image = $_FILES['category_images'];
            $target_dir = "/e-commerce/assets/category_images/";
            $target_file = $target_dir . basename($image["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $max_file_size = 2 * 1024 * 1024; // 2MB limit

            // Check file size
            if ($image['size'] > $max_file_size) {
                echo "File is too large. Max size is 2MB.";
                exit;
            }

            // Validate file type
            $valid_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array($imageFileType, $valid_types)) {
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $target_dir)) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . $target_dir, 0777, true);
                }

                if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                    // Update or insert the image
                    $query = "INSERT INTO category_images (category_id, image_path)
                              VALUES (?, ?)
                              ON DUPLICATE KEY UPDATE image_path = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("iss", $category_id, $target_file, $target_file);

                    if (!$stmt->execute()) {
                        echo "Error saving image: " . $conn->error;
                    }
                } else {
                    echo "Error uploading the file.";
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.";
            }
        }

        // Redirect after successful update
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
        <div class="mb-3">
            <label for="category_type" class="form-label">Category Type</label>
            <select class="form-control" id="category_type" name="category_type" onchange="toggleCategoryType()" required>
                <option value="main" <?php echo is_null($parent_id) ? 'selected' : ''; ?>>Main Category</option>
                <option value="second" <?php echo !is_null($parent_id) && empty($grouped_second_categories) ? 'selected' : ''; ?>>Second Category</option>
                <option value="third" <?php echo !is_null($parent_id) && !empty($grouped_second_categories) ? 'selected' : ''; ?>>Third Category</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category_name); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Category Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <div class="mb-3" id="main_category_select" style="display:<?php echo !is_null($parent_id) ? 'block' : 'none'; ?>;">
            <label for="main_category" class="form-label">Select Main Category</label>
            <select class="form-control" name="main_category">
                <option value="">Select Main Category</option>
                <?php foreach ($main_categories as $main_category): ?>
                    <option value="<?php echo $main_category['id']; ?>" <?php echo ($parent_id == $main_category['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($main_category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3" id="second_category_select" style="display:<?php echo !is_null($parent_id) && !empty($grouped_second_categories) ? 'block' : 'none'; ?>;">
            <label for="second_category" class="form-label">Select Second Category</label>
            <select class="form-control" name="second_category">
                <option value="">Select Second Category</option>
                <?php foreach ($grouped_second_categories as $main_name => $second_list): ?>
                    <optgroup label="<?php echo htmlspecialchars($main_name); ?>">
                        <?php foreach ($second_list as $second): ?>
                            <option value="<?php echo $second['id']; ?>" <?php echo ($parent_id == $second['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($second['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_images" class="form-label">Category Image</label><br>
            <?php if (!empty($image_path)): ?>
                <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Category Image" width="100"><br>
                <small>Current Image</small><br>
            <?php endif; ?>
            <input type="file" name="category_images">
        </div>

        <div class="mb-3">
            <label for="featured" class="form-label">Featured</label>
            <input type="checkbox" id="featured" name="featured" <?php echo ($featured == 1) ? 'checked' : ''; ?>>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="category_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    toggleCategoryType();
</script>

</body>
</html>

<?php
$conn->close();
?>