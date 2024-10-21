<?php
require 'db_connect.php';

// Set the number of categories per page
$categories_per_page = 15;

// Get the current page number from the URL, default to 1 if not present
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $categories_per_page;

// Get the filter option from the URL, default to 'all' if not present
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Adjust the query based on the filter
$where_clause = '';
if ($filter == 'main') {
    $where_clause = 'WHERE c1.parent_id IS NULL'; // Main categories
} elseif ($filter == 'second') {
    $where_clause = 'WHERE c1.parent_id IS NOT NULL AND c2.parent_id IS NULL'; // Second categories
} elseif ($filter == 'third') {
    $where_clause = 'WHERE c2.parent_id IS NOT NULL'; // Third categories
}

// Query to count total categories for pagination
$total_categories_query = "SELECT COUNT(*) as total FROM categories c1 LEFT JOIN categories c2 ON c1.parent_id = c2.id $where_clause";
$total_result = mysqli_query($conn, $total_categories_query);
$total_categories = mysqli_fetch_assoc($total_result)['total'];

// Query to fetch categories with pagination and filtering
$category_query = "
    SELECT c1.id AS category_id, c1.name AS category_name, c1.description, 
           c2.name AS parent_category_name,
           CASE 
             WHEN c1.parent_id IS NULL THEN 'Main Category'
             WHEN c2.parent_id IS NULL THEN 'Second Category'
             ELSE 'Third Category'
           END AS category_level
    FROM categories c1
    LEFT JOIN categories c2 ON c1.parent_id = c2.id
    $where_clause
    ORDER BY category_level, c1.name
    LIMIT $categories_per_page OFFSET $offset";

$categories_result = mysqli_query($conn, $category_query);

// Calculate total number of pages
$total_pages = ceil($total_categories / $categories_per_page);

// Set the range of pages to display
$pages_to_show = 5;  // Show 5 page links at a time
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
                <th>Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($category = mysqli_fetch_assoc($categories_result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($category['description']); ?></td>
                    <td><?php echo htmlspecialchars($category['parent_category_name'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($category['category_level']); ?></td>
                    <td>
                        <a href="category.php?id=<?php echo $category['category_id']; ?>" class="btn btn-info">View</a>
                        <a href="edit_category.php?id=<?php echo $category['category_id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_category.php?id=<?php echo $category['category_id']; ?>" class="btn btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
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