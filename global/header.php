<?php
session_start();
require 'web/db_connect.php';
require_once 'classes/Cart.php';

// Fetch main categories (parent_id is NULL) for the header
$header_main_category_query = "SELECT id, name FROM categories WHERE parent_id IS NULL";
$header_main_category_result_header = mysqli_query($conn, $header_main_category_query); // Renamed result variable to avoid conflict

// Fetch the total cart item count for the header
$userId = $_SESSION['user_id'] ?? null;
$cart = new Cart($conn, $userId);
$totalCartItems = $cart->getTotalCartItemCount();
?>

<!-- Top Bar -->
<nav class="top-bar bg-dark py-2">
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-4">
                <a href="#" class="text-white me-3">Shipping</a>
                <a href="#" class="text-white me-3">FAQ</a>
                <a href="#" class="text-white">Track Order</a>
            </div>
            <div class="col-4 text-white mx-auto text-center">
                Free Shipping Worldwide
            </div>
            <div class="col-4 d-flex justify-content-end align-items-end">
                <a href="#" class="text-white me-3">Default USD pricelist <i class="bi bi-chevron-down"></i></a>
                <span class="separator text-white">|</span>
                <a href="#" class="text-white ms-3">English (US) <i class="bi bi-chevron-down"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid d-flex">
        <div class="row w-100">
            <!-- Logo -->
            <div class="col-sm-2 col-md-2 col-lg-2 d-flex justify-content-start align-items-center">
                <a class="navbar-brand" href="/e-commerce/homepage.php">
                    <img src="/e-commerce/assets/auto-logo.png" alt="Auto-Logo" style="max-height: 80px; width: auto;">
                </a>
            </div>
            <!-- Search Bar -->
            <div class="col-sm-8 col-md-8 col-8 d-flex justify-content-start align-items-center search-bar p-0">
                <form class="d-flex search-bar">
                    <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                    <button class="btn search-btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
            <!-- Icons -->
            <div class="col-sm-2 col-md-2 col-lg-2 d-flex justify-content-end align-items-center pe-0">
                <a href="login.php" class="btn btn-light icon-buttons"><i class="bi bi-person"></i></a>
                <a href="shop_cart.php" class="btn btn-light position-relative">
                    <i class="bi bi-cart"></i>
                    <span id="cartItemCount" class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $totalCartItems > 0 ? $totalCartItems : ''; ?>
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="d-lg-none">
                <?php include 'functions/off-canvas.php'; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Category and Navigation Links -->
<nav class="navbar navbar-expand-lg navbar-light category-nav bg-white border-bottom py-0">
    <div class="container-fluid">
        <div class="row w-100" style="height: 100%;">
            <div class="col-sm-4 col-md-4 col-lg-2 d-flex justify-content-start align-items-center ps-0 pe-0">
                <div class="dropdown" style="width: 100%; height: 100%;">    
                    <button class="btn btn-orange category-btn d-flex justify-content-start align-items-center" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list"></i> 
                        <span>ALL CATEGORIES</span>
                        <span class="ms-auto d-flex align-items-center">
                            <i class="bi bi-chevron-down d-flex justify-content-end align-items-end"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="category_page.php">All Products</a></li>
                        <!-- Fetching main categories for the header -->
                        <?php if (mysqli_num_rows($header_main_category_result_header) > 0): ?>
                            <?php while ($header_main_category = mysqli_fetch_assoc($header_main_category_result_header)): ?>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">
                                        <?= htmlspecialchars($header_main_category['name']) ?>
                                        <i class="bi bi-chevron-right ms-auto"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        // Fetch second-level categories for the header
                                        $header_second_category_query = "SELECT id, name FROM categories WHERE parent_id = " . $header_main_category['id'];
                                        $header_second_category_result_header = mysqli_query($conn, $header_second_category_query); // Renamed variable
                                        while ($header_second_category = mysqli_fetch_assoc($header_second_category_result_header)): ?>
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item" href="#">
                                                    <?= htmlspecialchars($header_second_category['name']) ?>
                                                    <i class="bi bi-chevron-right ms-auto"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <?php
                                                    // Fetch third-level categories for the header
                                                    $header_third_category_query = "SELECT id, name FROM categories WHERE parent_id = " . $header_second_category['id'];
                                                    $header_third_category_result_header = mysqli_query($conn, $header_third_category_query); // Renamed variable
                                                    while ($header_third_category = mysqli_fetch_assoc($header_third_category_result_header)): ?>
                                                        <li><a class="dropdown-item" href="category_page.php?category_id=<?= $header_third_category['id'] ?>"><?= htmlspecialchars($header_third_category['name']) ?></a></li>
                                                    <?php endwhile; ?>
                                                </ul>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="#">No Categories Available</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 col-md-12 col-lg-8 d-flex justify-content-evenly align-items-center ps-3 pe-5">
                <ul class="navbar-nav d-flex justify-content-between w-100 p-0 m-0">
                    <li class="nav-item"><a class="nav-link" href="/e-commerce/homepage.php">HOME</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            GADGETS
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Digital Screen & Audio</a></li>
                            <li><a class="dropdown-item" href="#">GPS Unit</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">SHOP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">BLOG</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">INDUSTRY</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">SHOP BY CATEGORY</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">EXTRA PAGES</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span><i class="bi bi-plus" style="font-size: 18px;"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-4 col-md-6 col-lg-2 d-flex justify-content-start px-0">
                <a href="#" class="btn call-btn d-flex align-items-center ms-0 py-0 px-0">
                    <div class="d-flex justify-content-end align-items-center">
                        <span class="icon-circle">
                            <i class="bi bi-telephone-fill"></i>
                        </span>
                        <div class="col text-start py-1">
                            <p class="call-text ms-2">CALL US ON</p>
                            <span class="call-num ms-2">(1800) 11-55-854</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Custom CSS for toggling subcategory -->
<style>
    .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
}

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%; /* Moves the submenu to the right */
    margin-top: -1px;
}

.dropdown-submenu:hover > .dropdown-menu {
        display: block;
}

.dropdown-menu > li > a {
    white-space: nowrap;
    padding-right: 20px;
}

.dropdown-menu > li:hover > .dropdown-menu {
    display: block;
}
</style>

<!-- JavaScript to handle toggle functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle main category toggling to show/hide second categories
        document.querySelectorAll('.header-category-toggle').forEach(function(mainCategoryLink) {
            mainCategoryLink.addEventListener('click', function(e) {
                e.preventDefault();
                var mainCategoryId = this.getAttribute('data-id');
                var subcategoriesList = document.getElementById('header-subcategories-' + mainCategoryId);
                if (subcategoriesList) {
                    subcategoriesList.style.display = (subcategoriesList.style.display === 'none') ? 'block' : 'none';
                }
            });
        });

        $(document).ready(function () {
            // Function to update the cart item count dynamically
            function updateCartItemCount() {
                $.ajax({
                    url: 'fetch_cart_item_count.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            const count = response.count || 0;
                            const badge = $('#cartItemCount');
                            if (count > 0) {
                                badge.text(count).show(); // Display the count
                            } else {
                                badge.text('').hide(); // Hide badge if count is zero
                            }
                        } else {
                            console.error('Failed to fetch cart item count:', response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching cart item count:', error);
                    }
                });
            }

            // Call the function on page load
            updateCartItemCount();

            // Update the cart count whenever cart items are modified
            $(document).on('click', '.js_increase_quantity, .js_decrease_quantity, .js_delete_product', function () {
                updateCartItemCount();
            });

            // Update cart item count after any page reload or refresh
            $(window).on('load', function () {
                updateCartItemCount();
            });
        });
        
        // Handle second category toggle for third categories
        document.querySelectorAll('.dropdown-submenu > a').forEach(function(subcategoryLink) {
            subcategoryLink.addEventListener('click', function(e) {
                e.preventDefault();
                var subcategoryId = this.getAttribute('data-id');
                var thirdCategoryList = document.getElementById('header-third-categories-' + subcategoryId);
                if (thirdCategoryList) {
                    thirdCategoryList.style.display = (thirdCategoryList.style.display === 'none') ? 'block' : 'none';
                }
            });
        });
    });
</script>