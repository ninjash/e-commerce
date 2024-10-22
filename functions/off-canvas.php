<?php
require 'web/db_connect.php';

// Fetch main categories (parent_id is NULL)
$header_main_category_query = "SELECT id, name FROM categories WHERE parent_id IS NULL";
$header_main_category_result = mysqli_query($conn, $header_main_category_query);
?>

<!-- Off Canvas for Mobile View -->
<div class="container-fluid">
    <div class="offcanvas offcanvas-end offcanvas-lg offcanvas-75" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <!-- Close button -->
        <div class="offcanvas-header d-flex justify-content-end">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!-- Offcanvas Body -->
        <div class="offcanvas-body">
           <!-- Search Bar -->
           <form class="d-flex off-search-bar mb-3">
                <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                <button class="btn search-btn" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Navigation Links -->
            <ul class="navbar-nav off-navbar-nav">
                <!-- Dropdown for ALL CATEGORIES -->
                <li class="nav-item dropdown my-2">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ALL CATEGORIES
                    </a>
                    <ul class="dropdown-menu w-100" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="category_page.php">All Products</a></li>
                        <!-- Fetching main categories -->
                        <?php if (mysqli_num_rows($header_main_category_result) > 0): ?>
                            <?php while ($main_category = mysqli_fetch_assoc($header_main_category_result)): ?>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">
                                        <?= htmlspecialchars($main_category['name']) ?>
                                        <i class="bi bi-chevron-right ms-auto"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        // Fetch second-level categories based on the main category's ID
                                        $second_category_query = "SELECT id, name FROM categories WHERE parent_id = " . $main_category['id'];
                                        $second_category_result = mysqli_query($conn, $second_category_query);
                                        while ($second_category = mysqli_fetch_assoc($second_category_result)): ?>
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item" href="#">
                                                    <?= htmlspecialchars($second_category['name']) ?>
                                                    <i class="bi bi-chevron-right ms-auto"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <?php
                                                    // Fetch third-level categories based on the second category's ID
                                                    $third_category_query = "SELECT id, name FROM categories WHERE parent_id = " . $second_category['id'];
                                                    $third_category_result = mysqli_query($conn, $third_category_query);
                                                    while ($third_category = mysqli_fetch_assoc($third_category_result)): ?>
                                                        <li><a class="dropdown-item" href="category_page.php?category_id=<?= $third_category['id'] ?>"><?= htmlspecialchars($third_category['name']) ?></a></li>
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
                </li>

                <!-- Simple Nav Links -->
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="homepage.php">HOME</a></li>
                <li class="nav-item dropdown my-2">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        GADGETS
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Digital Screen & Audio</a></li>
                        <li><a class="dropdown-item" href="#">GPS Unit</a></li>
                    </ul>
                </li>
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="#">SHOP</a></li>
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="#">BLOG</a></li>
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="#">INDUSTRY</a></li>
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="#">SHOP BY CATEGORY</a></li>
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="#">EXTRA PAGES</a></li>
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="#">CONTACT US</a></li>

                <!-- Contact and Sign-in Links -->
                <li class="nav-item my-3" style="border-top: solid 1px #a8a8a8;">
                    <a class="nav-link" href="tel:+16505550111">
                        <i class="bi bi-telephone-fill" style="font-size: 18px;"></i> +1 (650) 555-0111
                    </a>
                </li>
            </ul>

            <div class="sign-in my-3">
                <a href="#" class="btn btn-outline-primary w-100 py-2">Sign in</a>
            </div>

            <!-- Bottom Section -->
            <div class="my-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Default USD Pricelist</span>
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        USD
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">English (US)</span>
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        English
                    </button>
                </div>
            </div>

            <!-- Contact Us Button -->
            <button class="btn btn-primary w-100 py-2">Contact Us</button>
        </div>
    </div>
</div>
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