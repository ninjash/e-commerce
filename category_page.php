<?php
require 'web/db_connect.php';
require 'classes/Product.php';
require 'classes/Category.php';
require 'classes/Cart.php';

session_start();

// Instantiate the Category, Product, and Cart classes
$categoryClass = new Category($conn);
$productClass = new Product($conn);
$userId = $_SESSION['user_id'] ?? null;
$cart = new Cart($conn, $userId);

// Handle Add-to-Cart AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    $productId = $input['product_id'] ?? 0;
    $quantity = $input['quantity'] ?? 1;

    if (!$productId) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
        exit;
    }

    try {
        // Add product to the cart
        $cart->addToCart($productId, $quantity);
        $cartCount = $cart->getTotalCartItemCount();
        echo json_encode(['status' => 'success', 'message' => 'Product added to cart successfully!', 'cartCount' => $cartCount]);
    } catch (Exception $e) {
        error_log('Add to Cart Error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart.']);
    }
    exit;
}

// Fetch main categories (parent_id is NULL)
$page_main_category_result = Category::getMainCategories($conn);

// Handle selected category (default to all products)
$page_category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$page_category_name = "All Products";

if ($page_category_id > 0) {
    $page_category_detail_result = $categoryClass->getCategoryDetails($page_category_id);

    if (empty($page_category_detail_result)) {
        echo "Category not found.";
        exit;
    }

    $page_category_name = $page_category_detail_result['category_name'];
    $category_ids = [$page_category_id];
    $child_categories = Category::getAllChildCategories($conn, $page_category_id);
    $category_ids = array_merge($category_ids, $child_categories);
    $category_ids_string = implode(',', $category_ids);

    $page_product_result = Product::getProductsByCategory($category_ids_string, $conn);
} else {
    $page_product_result = Product::getAllProducts($conn);
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
                    <?php if (!empty($page_product_result)): ?>
                        <?php foreach ($page_product_result as $page_product): ?>
                            <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                                <a href="product_page.php?id=<?php echo htmlspecialchars($page_product['id']); ?>" class="text-decoration-none text-reset">
                                    <div class="product-category-card p-3 pb-0 position-relative">
                                        <img src="<?php echo htmlspecialchars($page_product['image_path']); ?>" alt="Product Image" class="img-fluid product-image">
                                        <div class="overlay-container">
                                        <?php include 'functions/overlay-buttons.php'; ?>
                                            <div class="product-info text-center pt-3">
                                                <div class="product-rating-category">
                                                    <p><i class="bi bi-star-fill"></i> 4.0</p>
                                                </div>
                                                <h5 class="product-category-name"><?php echo htmlspecialchars($page_product['name']); ?></h5>
                                                <p class="product-category-price">
                                                    <span class="category-old-price">$<?php echo number_format($page_product['old_price'], 2); ?></span>
                                                    <span class="category-new-price">$<?php echo number_format($page_product['price'], 2); ?></span>
                                                </p>
                                            </div>
                                            <?php 
                                            // Pass product data to the overlay-buttons.php
                                            $product = $page_product; 
                                            ?>
                                        </div>
                                    </div>
                                </a>
                                <div class="row w-100 product-nav-category px-0">
                                    <div class="col p-0 text-center">
                                        <a href="add_to_cart.php" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
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
                    <?php else: ?>
                        <p class="text-center">No products found in this category.</p>
                    <?php endif; ?>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle categories
        document.querySelectorAll('.category-toggle').forEach(function (mainCategoryLink) {
            mainCategoryLink.addEventListener('click', function (e) {
                e.preventDefault();
                const mainCategoryId = this.getAttribute('data-id');
                const subcategoriesList = document.getElementById('subcategories-' + mainCategoryId);
                subcategoriesList.style.display = subcategoriesList.style.display === 'none' ? 'block' : 'none';
            });
        });

        document.querySelectorAll('.subcategory-toggle').forEach(function (secondCategoryLink) {
            secondCategoryLink.addEventListener('click', function (e) {
                e.preventDefault();
                const secondCategoryId = this.getAttribute('data-id');
                const thirdCategoriesList = document.getElementById('thirdcategories-' + secondCategoryId);
                thirdCategoriesList.style.display = thirdCategoriesList.style.display === 'none' ? 'block' : 'none';
            });
        });

        // Add to Cart Functionality
        $(document).on('click', '.add-to-cart', function (e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            const quantity = 1; // Default quantity

            if (!productId) {
                alert('Product ID is missing.');
                console.error('Add to Cart: Missing Product ID.');
                return;
            }

            $.ajax({
                url: 'handle_overlay_buttons.php', // Use the correct handler for AJAX actions
                type: 'POST',
                data: JSON.stringify({ action: 'add_to_cart', product_id: productId, quantity: quantity }),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message || 'Product added to cart successfully!');
                        updateCartCount(response.cartCount); // Update cart count dynamically
                    } else {
                        alert(response.message || 'Failed to add product to cart.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Add to Cart AJAX Error:', error);
                    alert('An error occurred while adding the product to the cart.');
                }
            });
        });

        // Function to update cart count dynamically
        function updateCartCount(count) {
            const cartCountElement = document.querySelector('#cartCount');
            if (cartCountElement) {
                cartCountElement.textContent = count; // Update the cart count element
            }
        }

        // View Product Functionality
        $(document).on('click', '.view-product', function (e) {
            e.preventDefault(); // Prevent default behavior
            const productId = $(this).data('product-id');
            if (productId) {
                // Redirect to product page
                window.location.href = `product_page.php?id=${productId}`;
            } else {
                alert('Product ID is missing.');
                console.error('View Product: Missing Product ID.');
            }
        });

        // Initialize hover effects for dynamically loaded content
        function initializeHoverEffects() {
            $('.category-product').hover(
                function () {
                    $(this).find('.overlay-buttons').css({
                        opacity: 1,
                        visibility: 'visible',
                    });
                },
                function () {
                    $(this).find('.overlay-buttons').css({
                        opacity: 0,
                        visibility: 'hidden',
                    });
                }
            );
        }

        // Add to Wishlist Functionality
        $(document).on('click', '.add-to-wishlist', function (e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            if (!productId) {
                alert('Product ID is missing.');
                return;
            }

            $.ajax({
                url: 'handle_overlay_buttons.php',
                type: 'POST',
                data: JSON.stringify({ action: 'add_to_wishlist', product_id: productId }),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    alert(response.message || 'Product added to wishlist!');
                },
                error: function (xhr, status, error) {
                    console.error('Add to Wishlist AJAX Error:', error);
                    alert('An error occurred while adding the product to the wishlist.');
                }
            });
        });

        // Call hover effects initialization
        initializeHoverEffects();
    });
</script>
</body>
</html>