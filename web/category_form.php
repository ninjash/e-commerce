<?php
require 'db_connect.php';
require_once '../classes/Category.php';

// Instantiate the Category class
$categoryClass = new Category($conn);

// Fetch all main categories
$main_categories = $categoryClass::getMainCategories($conn);

// Fetch all second categories along with their parent main categories
$second_categories = $categoryClass::getSecondLevelCategoriesWithParentNames($conn);

// Organize second categories under their respective main categories
$grouped_second_categories = [];
foreach ($second_categories as $second_category) {
    $grouped_second_categories[$second_category['parent_name']][] = $second_category;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['name'];
    $description = $_POST['description'];
    $category_type = $_POST['category_type'];
    $parent_id = NULL; // Default to NULL for main categories
    $featured = isset($_POST['featured']) ? 1 : 0;

    // Set the parent ID based on the category type
    if ($category_type == 'second') {
        $parent_id = !empty($_POST['main_category']) ? $_POST['main_category'] : NULL; // For second category
    } elseif ($category_type == 'third') {
        $parent_id = !empty($_POST['second_category']) ? $_POST['second_category'] : NULL; // For third category
    }

    // Create a new Category object and set its properties
    $newCategory = new Category($conn);
    $newCategory->setName($category_name);
    $newCategory->setDescription($description);
    $newCategory->setParentId($parent_id);
    $newCategory->setFeatured($featured);

    // Save the category
    if ($newCategory->save()) {
        $category_id = $conn->insert_id; // Get the last inserted ID for the category

        // Handle the image upload if an image was provided
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
            $image = $_FILES['category_image'];
            $target_file = "/e-commerce/assets/category_images/" . basename($image["name"]);

            // Move the uploaded image to the target directory
            if (move_uploaded_file($image["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                // Insert image path into the category_images table
                $query = "INSERT INTO category_images (category_id, image_path) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("is", $category_id, $target_file);

                if (!$stmt->execute()) {
                    echo "Error inserting image: " . $conn->error;
                    exit();
                }
            } else {
                echo "Error uploading image.";
                exit();
            }
        }

        // Redirect to the category list
        header("Location: category_list.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
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
                <?php foreach ($main_categories as $main_category): ?>
                    <option value="<?php echo $main_category['id']; ?>"><?php echo htmlspecialchars($main_category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Second Category selection for Third Categories, grouped by Main Category -->
        <div class="mb-3" id="second_category_select" style="display:none;">
            <label for="second_category" class="form-label">Select Second Category</label>
            <select class="form-control" name="second_category">
                <option value="">Select Second Category</option>
                <?php foreach ($grouped_second_categories as $main_category_name => $second_category_list): ?>
                    <optgroup label="<?php echo htmlspecialchars($main_category_name); ?>">
                        <?php foreach ($second_category_list as $second_category): ?>
                            <option value="<?php echo $second_category['id']; ?>">
                                <?php echo htmlspecialchars($second_category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="featured" class="form-label">Featured</label>
            <input type="checkbox" id="featured" name="featured">
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
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