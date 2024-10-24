<?php
require 'web/db_connect.php';
require 'Product.php';

// Fetch main categories (parent_id is NULL) for the page
$page_main_category_query = "SELECT c.id, c.name, 
                        (SELECT COUNT(p.id) 
                         FROM product_categories pc
                         JOIN products p ON pc.product_id = p.id
                         WHERE pc.category_id = c.id OR pc.category_id IN 
                             (SELECT id FROM categories WHERE parent_id = c.id)
                             OR pc.category_id IN 
                             (SELECT id FROM categories WHERE parent_id IN 
                                (SELECT id FROM categories WHERE parent_id = c.id))) 
                         as product_count
                        FROM categories c 
                        WHERE c.parent_id IS NULL";
$page_main_category_result = mysqli_query($conn, $page_main_category_query);

// Recursive function to get all child category IDs
function get_all_child_categories($parent_id, $conn) {
    $child_categories = [];
    
    // Get all direct children of this category
    $sql = "SELECT id FROM categories WHERE parent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all child categories
    while ($row = $result->fetch_assoc()) {
        $child_categories[] = $row['id'];
        // Recursively get all children of the current child category
        $child_categories = array_merge($child_categories, get_all_child_categories($row['id'], $conn));
    }

    return $child_categories;
}

// Handle selected category (default to all products)
$page_category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$page_category_name = "All Products"; // Default category name

// Fetch the specific category details if a category is selected
if ($page_category_id > 0) {
    // Fetch the details of the selected category
    $page_category_detail_query = "
        SELECT c1.id, c1.name as category_name, c2.name as parent_name, c3.name as grandparent_name
        FROM categories c1
        LEFT JOIN categories c2 ON c1.parent_id = c2.id
        LEFT JOIN categories c3 ON c2.parent_id = c3.id
        WHERE c1.id = $page_category_id";
        
    $page_category_detail_result = mysqli_query($conn, $page_category_detail_query);

    if ($page_category_detail_result && mysqli_num_rows($page_category_detail_result) > 0) {
        $page_category = mysqli_fetch_assoc($page_category_detail_result);
        $page_category_name = $page_category['category_name']; // Set the category name for display
    } else {
        echo "Category not found.";
        exit;
    }

    // Fetch all child categories of the selected category
    $category_ids = [$page_category_id]; // Include the selected category
    $category_ids = array_merge($category_ids, get_all_child_categories($page_category_id, $conn));

    // Convert category IDs to a comma-separated string for SQL query
    $category_ids_string = implode(',', $category_ids);

    // Filter products by selected category and its child categories
    $page_product_query = "SELECT p.*, pi.image_path 
                      FROM products p
                      JOIN product_categories pc ON p.id = pc.product_id
                      LEFT JOIN product_images pi ON p.id = pi.product_id
                      WHERE pc.category_id IN ($category_ids_string)";
} else {
    // Fetch all products if no specific category is selected
    $page_product_query = "SELECT p.*, pi.image_path 
                      FROM products p
                      LEFT JOIN product_images pi ON p.id = pi.product_id";
}

// Fetch products for the page
$page_product_result = mysqli_query($conn, $page_product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_category_name; ?> - Car Parts E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/e-commerce/styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<header>
    <?php include 'global/header.php'; ?>
</header>
<main>
    <!-- Category Title -->
    <div class="container pt-5">
        <h1 class="text-center"><?php echo $page_category_name; ?></h1> <!-- Display the current category name -->
    </div>
    <!-- Category List -->
    <div class="container-fluid py-lg-5">
        <div class="row w-100">
            <div class="col-3 category-list-column px-0">
                <div class="category-list-section py-4" id="categoryListSection">
                    <h5 class="category-list-title mb-3">Categories</h5>
                    <ul class="category-list-menu d-flex flex-column justify-content-start px-3" id="categoryMenu">
                        <li><a href="?category_id=0">All Products</a></li>
                        <?php while ($page_main_category = mysqli_fetch_assoc($page_main_category_result)): ?>
                            <li>
                                <a href="#" class="category-toggle" data-id="<?php echo $page_main_category['id']; ?>">
                                    <?php echo $page_main_category['name']; ?>
                                    <span>(<?php echo $page_main_category['product_count']; ?>)</span>
                                </a>
                                <ul class="subcategory-list" id="subcategories-<?php echo $page_main_category['id']; ?>" style="display: none;">
                                    <?php
                                    // Fetch second-level categories based on the main category's ID
                                    $page_second_category_query = "SELECT c.id, c.name, 
                                        (SELECT COUNT(p.id) 
                                         FROM product_categories pc
                                         JOIN products p ON pc.product_id = p.id
                                         WHERE pc.category_id = c.id OR pc.category_id IN 
                                             (SELECT id FROM categories WHERE parent_id = c.id)) 
                                         as product_count
                                        FROM categories c WHERE c.parent_id = " . $page_main_category['id'];
                                    $page_second_category_result = mysqli_query($conn, $page_second_category_query);
                                    while ($page_second_category = mysqli_fetch_assoc($page_second_category_result)): ?>
                                        <li>
                                            <a href="#" class="subcategory-toggle" data-id="<?php echo $page_second_category['id']; ?>">
                                                <?php echo $page_second_category['name']; ?>
                                                <span>(<?php echo $page_second_category['product_count']; ?>)</span>
                                            </a>
                                            <ul class="subcategory-list" id="thirdcategories-<?php echo $page_second_category['id']; ?>" style="display: none;">
                                                <?php
                                                // Fetch third-level categories based on the second category's ID
                                                $page_third_category_query = "SELECT c.id, c.name, 
                                                    (SELECT COUNT(p.id) 
                                                     FROM product_categories pc
                                                     JOIN products p ON pc.product_id = p.id
                                                     WHERE pc.category_id = c.id) 
                                                     as product_count
                                                    FROM categories c WHERE c.parent_id = " . $page_second_category['id'];
                                                $page_third_category_result = mysqli_query($conn, $page_third_category_query);
                                                while ($page_third_category = mysqli_fetch_assoc($page_third_category_result)): ?>
                                                    <li>
                                                        <a href="?category_id=<?php echo $page_third_category['id']; ?>">
                                                            <?php echo $page_third_category['name']; ?>
                                                            <span>(<?php echo $page_third_category['product_count']; ?>)</span>
                                                        </a>
                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <div class="col-9 sort-section-column px-0 py-3">
                <div class="sort-section d-flex justify-content-lg-between justify-content-md-start align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <label for="sortSelect" class="form-label m-0">Sort By:</label>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle sort" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Featured
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item" href="#">Newest</a></li>
                                <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                                <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="button-group">
                        <button class="btn btn-toggle active">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </button>
                        <button class="btn btn-toggle">
                            <i class="bi bi-list"></i>
                        </button>
                        <button class="btn btn-filter">
                            <i class="bi bi-sliders"></i>
                     </button>
                    </div>
                </div>
                <div class="product-category-body grid gap-2 gap-lg-3 row d-flex flex-row flex-wrap">
                    <?php while ($page_product = mysqli_fetch_assoc($page_product_result)) : ?>
                        <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                            <a href="product_page.php?id=<?php echo $page_product['id']; ?>" class="text-decoration-none text-reset">
                                <div class="product-category-card p-3 pb-0 position-relative">
                                    <img src="<?php echo $page_product['image_path']; ?>" alt="Product Image" class="img-fluid product-image">
                                    <div class="overlay-container">
                                        <div class="product-info text-center pt-3">
                                            <div class="product-rating-category">
                                                <p><i class="bi bi-star-fill"></i> 4.0</p>
                                            </div>
                                            <h5 class="product-category-name"><?php echo $page_product['name']; ?></h5>
                                            <p class="product-category-price">
                                                <span class="category-old-price">$<?php echo number_format($page_product['old_price'], 2); ?></span>
                                                <span class="category-new-price">$<?php echo number_format($page_product['price'], 2); ?></span>
                                            </p>
                                        </div>
                                        <?php include 'functions/overlay-buttons.php'; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include 'global/footer.php'; ?>
</main>
    <div class="text-center text-white footer-secondary py-2">
        <div class="container">
            <p class="mb-0">© 2024 Car Parts E-Commerce. All Rights Reserved.  English  | Francais</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle click on main category to toggle subcategories
            document.querySelectorAll('.category-toggle').forEach(function(mainCategoryLink) {
                mainCategoryLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    var mainCategoryId = this.getAttribute('data-id');
                    var subcategoriesList = document.getElementById('subcategories-' + mainCategoryId);
                    subcategoriesList.style.display = subcategoriesList.style.display === 'none' ? 'block' : 'none';
                });
            });

            // Handle click on second category to toggle third-level categories
            document.querySelectorAll('.subcategory-toggle').forEach(function(secondCategoryLink) {
                secondCategoryLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    var secondCategoryId = this.getAttribute('data-id');
                    var thirdCategoriesList = document.getElementById('thirdcategories-' + secondCategoryId);
                    thirdCategoriesList.style.display = thirdCategoriesList.style.display === 'none' ? 'block' : 'none';
                });
            });
        });
    </script>
</body>
</html>