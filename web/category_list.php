<?php
require 'db_connect.php';
require_once '../classes/Category.php';

// Set the number of categories per page
$categories_per_page = 15;

// Get the current page number from the URL, default to 1 if not present
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $categories_per_page;

// Get the filter option from the URL, default to 'all' if not present
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Instantiate the Category class
$categoryClass = new Category($conn);

// Adjust the categories to fetch based on the filter
$categories = [];
switch ($filter) {
    case 'main':
        $categories = $categoryClass->getMainCategories($conn);
        break;
    case 'second':
        $categories = $categoryClass->getSecondLevelCategoriesWithParentNames($conn); // Updated method
        break;
    case 'third':
        $categories = $categoryClass->getThirdLevelCategoriesWithParentNames($conn); // Updated method
        break;
    default:
        $categories = $categoryClass->getCategoriesWithParentNames(); // Updated method to get all categories with parent names
        break;
}

// Calculate total number of pages for pagination
$total_categories = count($categories);
$total_pages = ceil($total_categories / $categories_per_page);

// Slice the categories array to implement pagination
$categories_to_display = array_slice($categories, $offset, $categories_per_page);

// Set the range of pages to display
$pages_to_show = 5; // Show 5 page links at a time
$start_page = max(1, $page - floor($pages_to_show / 2));
$end_page = min($total_pages, $start_page + $pages_to_show - 1);

// Adjust the start page if we are near the end of the page list
if ($end_page - $start_page < $pages_to_show - 1) {
    $start_page = max(1, $end_page - $pages_to_show + 1);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories List</title>
</head>
<body>

<div class="container mt-4">
    <h1>Categories List</h1>

    <!-- Filter Form -->
    <form method="GET" action="category_list.php" class="mb-3">
        <div class="form-group">
            <label for="filter">Filter Categories:</label>
            <select name="filter" id="filter" class="form-control" onchange="this.form.submit()">
                <option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All Categories</option>
                <option value="main" <?php echo $filter == 'main' ? 'selected' : ''; ?>>Main Categories</option>
                <option value="second" <?php echo $filter == 'second' ? 'selected' : ''; ?>>Second Categories</option>
                <option value="third" <?php echo $filter == 'third' ? 'selected' : ''; ?>>Third Categories</option>
            </select>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Description</th>
                <th>Parent Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories_to_display as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td><?php echo htmlspecialchars($category['description'] ?? 'No description available'); ?></td>
                    <td><?php echo htmlspecialchars($category['parent_name'] ?? 'N/A'); ?></td>
                    <td>
                        <a href="category.php?id=<?php echo $category['id']; ?>" class="btn btn-info">View</a>
                        <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination controls with "Create New Category" button included -->
    <nav>
        <ul class="pagination justify-content-center">
            <!-- Create New Category button -->
            <li class="page-item">
                <a href="category_form.php" class="btn btn-primary">Create New Category</a>
            </li>

            <!-- Pagination controls -->
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&filter=<?php echo $filter; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Show the pages within the range -->
            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&filter=<?php echo $filter; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</body>
</html>

<?php
mysqli_close($conn);
?>