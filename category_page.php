<?php
require 'web/db_connect.php';
require 'classes/Product.php';
require 'classes/Category.php';

// Instantiate the Category and Product classes
$categoryClass = new Category($conn);
$productClass = new Product($conn);

// Fetch main categories (parent_id is NULL)
$page_main_category_result = Category::getMainCategories($conn); // Pass $conn

// Handle selected category (default to all products)
$page_category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$page_category_name = "All Products"; // Default category name

// Fetch category details if a category is selected
if ($page_category_id > 0) {
    $page_category_detail_result = $categoryClass->getCategoryDetails($page_category_id);

    // Check if the result is empty or null
    if (empty($page_category_detail_result)) {
        echo "Category not found.";
        exit;
    }

    // Set the category name for display
    $page_category_name = $page_category_detail_result['category_name'];
    
    // Fetch all child categories of the selected category
    $category_ids = [$page_category_id];
    $child_categories = Category::getAllChildCategories($conn, $page_category_id); // Pass $conn
    $category_ids = array_merge($category_ids, $child_categories); // Combine selected category with its children
    $category_ids_string = implode(',', $category_ids);

    // Filter products by selected category
    $page_product_result = Product::getProductsByCategory($category_ids_string, $conn); // Pass $conn

} else {
    // Fetch all products if no specific category is selected
    $page_product_result = Product::getAllProducts($conn); // Pass $conn
}

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
    <div class="container pt-5">
        <h1 class="text-center"><?php echo $page_category_name; ?></h1>
    </div>

    <div class="container-fluid py-lg-5">
        <div class="row w-100">
            <div class="col-3 category-list-column px-0">
                <div class="category-list-section py-4" id="categoryListSection">
                    <h5 class="category-list-title mb-3">Categories</h5>
                    <ul class="category-list-menu d-flex flex-column justify-content-start px-3" id="categoryMenu">
                        <li><a href="?category_id=0">All Products</a></li>
                        <?php foreach ($page_main_category_result as $page_main_category): ?>
                            <li>
                                <a href="#" class="category-toggle" data-id="<?php echo $page_main_category['id']; ?>">
                                    <?php echo $page_main_category['name']; ?>
                                    <span>(<?php echo $page_main_category['product_count']; ?>)</span>
                                </a>
                                <ul class="subcategory-list" id="subcategories-<?php echo $page_main_category['id']; ?>" style="display: none;">
                                    <?php
                                    $page_second_category_result = Category::getSecondLevelCategories($conn, $page_main_category['id']);
                                    foreach ($page_second_category_result as $page_second_category): ?>
                                        <li>
                                            <a href="#" class="subcategory-toggle" data-id="<?php echo $page_second_category['id']; ?>">
                                                <?php echo $page_second_category['name']; ?>
                                                <span>(<?php echo $page_second_category['product_count']; ?>)</span>
                                            </a>
                                            <ul class="subcategory-list" id="thirdcategories-<?php echo $page_second_category['id']; ?>" style="display: none;">
                                                <?php
                                                $page_third_category_result = Category::getThirdLevelCategories($conn, $page_second_category['id']);
                                                foreach ($page_third_category_result as $page_third_category): ?>
                                                    <li>
                                                        <a href="?category_id=<?php echo $page_third_category['id']; ?>">
                                                            <?php echo $page_third_category['name']; ?>
                                                            <span>(<?php echo $page_third_category['product_count']; ?>)</span>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
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
                    <?php foreach ($page_product_result as $page_product): ?>
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
                            <div class="row w-100 product-nav-category px-0">
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-heart"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

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