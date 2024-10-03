<?php
require 'web/db_connect.php';
require 'Product.php';

// Fetch all categories
$category_query = "SELECT c.id, c.name, c.description, COUNT(p.id) as product_count
                   FROM categories c
                   LEFT JOIN products p ON c.id = p.category_id
                   GROUP BY c.id";
$category_result = mysqli_query($conn, $category_query);

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
        $product_query .= " WHERE p.category_id = $category_id"; // Fetch products for the selected category
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
    <!-- Main Content -->
    <div class="container-fluid category-product-container">
        <div class="row w-100">
            <div class="category-header d-flex justify-content-between align-items-center py-4 px-0">
                <div class="col-6">
                    <h3 class="m-0"><strong>
                        <?php if ($category_id > 0 && isset($category)) : ?>
                            Category: <?php echo $category['name']; ?>
                        <?php else : ?>
                            All Products
                        <?php endif; ?>
                    </strong></h3>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <nav aria-label="breadcrumb" class="breadcrumb-tab">
                        <ol class="breadcrumb ms-auto">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Category List -->
    <div class="container-fluid py-lg-5">
        <div class="row w-100">
            <div class="col-3 category-list-column px-0">
                <div class="category-list-section py-4" id="categoryListSection">
                    <h5 class="category-list-title mb-3">Categories</h5>
                    <ul class="category-list-menu d-flex flex-column justify-content-start px-3">
                        <li><a href="?category_id=0">All Products</a></li>
                        <?php while ($category_row = mysqli_fetch_assoc($category_result)): ?>
                            <li><a href="?category_id=<?= $category_row['id']; ?>">
                                <?php echo $category_row['name']; ?>
                                <span>(<?php echo $category_row['product_count']; ?>)</span>
                            </a></li>
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
                <div class="product-category-body row d-flex justify-content-between">
                    <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
                        <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
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
</body>
</html>