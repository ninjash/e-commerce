<?php
require 'web/db_connect.php';
require 'Product.php';

// Fetch main categories (parent_id is NULL)
$main_category_query = "SELECT c.id, c.name, 
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
$main_category_result = mysqli_query($conn, $main_category_query);

// Handle selected category (default to all products)
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$product_query = "SELECT p.*, pi.image_path 
                  FROM products p
                  LEFT JOIN product_images pi ON p.id = pi.product_id";

// Fetch the specific category details if a category is selected
if ($category_id > 0) {
    $category_detail_query = "SELECT * FROM categories WHERE id = $category_id";
    $category_detail_result = mysqli_query($conn, $category_detail_query);

    if ($category_detail_result && mysqli_num_rows($category_detail_result) > 0) {
        $category = mysqli_fetch_assoc($category_detail_result); // Store the category details
        // Use the product_categories table to filter products by selected category
        $product_query .= " JOIN product_categories pc ON p.id = pc.product_id WHERE pc.category_id = $category_id"; 
    } else {
        echo "Category not found.";
        exit;
    }
}

// Fetch products
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/e-commerce/styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<header>
    <?php include 'global/header.php'; ?>
</header>
<main>
    <!-- Category List -->
    <div class="container-fluid py-lg-5">
        <div class="row w-100">
            <div class="col-3 category-list-column px-0">
                <div class="category-list-section py-4" id="categoryListSection">
                    <h5 class="category-list-title mb-3">Categories</h5>
                    <ul class="category-list-menu d-flex flex-column justify-content-start px-3" id="categoryMenu">
                        <li><a href="?category_id=0">All Products</a></li>
                        <?php while ($main_category = mysqli_fetch_assoc($main_category_result)): ?>
                            <li>
                                <a href="#" class="category-toggle" data-id="<?php echo $main_category['id']; ?>">
                                    <?php echo $main_category['name']; ?>
                                    <span>(<?php echo $main_category['product_count']; ?>)</span>
                                </a>
                                <ul class="subcategory-list" id="subcategories-<?php echo $main_category['id']; ?>" style="display: none;">
                                    <?php
                                    // Fetch second-level categories based on the main category's ID
                                    $second_category_query = "SELECT c.id, c.name, 
                                        (SELECT COUNT(p.id) 
                                         FROM product_categories pc
                                         JOIN products p ON pc.product_id = p.id
                                         WHERE pc.category_id = c.id OR pc.category_id IN 
                                             (SELECT id FROM categories WHERE parent_id = c.id)) 
                                         as product_count
                                        FROM categories c WHERE c.parent_id = " . $main_category['id'];
                                    $second_category_result = mysqli_query($conn, $second_category_query);
                                    while ($second_category = mysqli_fetch_assoc($second_category_result)): ?>
                                        <li>
                                            <a href="#" class="subcategory-toggle" data-id="<?php echo $second_category['id']; ?>">
                                                <?php echo $second_category['name']; ?>
                                                <span>(<?php echo $second_category['product_count']; ?>)</span>
                                            </a>
                                            <ul class="subcategory-list" id="thirdcategories-<?php echo $second_category['id']; ?>" style="display: none;">
                                                <?php
                                                // Fetch third-level categories based on the second category's ID
                                                $third_category_query = "SELECT c.id, c.name, 
                                                    (SELECT COUNT(p.id) 
                                                     FROM product_categories pc
                                                     JOIN products p ON pc.product_id = p.id
                                                     WHERE pc.category_id = c.id) 
                                                     as product_count
                                                    FROM categories c WHERE c.parent_id = " . $second_category['id'];
                                                $third_category_result = mysqli_query($conn, $third_category_query);
                                                while ($third_category = mysqli_fetch_assoc($third_category_result)): ?>
                                                    <li>
                                                        <a href="?category_id=<?php echo $third_category['id']; ?>">
                                                            <?php echo $third_category['name']; ?>
                                                            <span>(<?php echo $third_category['product_count']; ?>)</span>
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
                    <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
                        <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                            <a href="product_page.php?id=<?php echo $product['id']; ?>" class="text-decoration-none text-reset">
                                <div class="product-category-card p-3 pb-0 position-relative">
                                    <img src="<?php echo $product['image_path']; ?>" alt="Product Image" class="img-fluid product-image">
                                    <div class="overlay-container">
                                        <div class="product-info text-center pt-3">
                                            <div class="product-rating-category">
                                                <p><i class="bi bi-star-fill"></i> 4.0</p>
                                            </div>
                                            <h5 class="product-category-name"><?php echo $product['name']; ?></h5>
                                            <p class="product-category-price">
                                                <span class="category-old-price">$<?php echo number_format($product['old_price'], 2); ?></span>
                                                <span class="category-new-price">$<?php echo number_format($product['price'], 2); ?></span>
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