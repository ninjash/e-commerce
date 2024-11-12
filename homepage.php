<?php
require 'web/db_connect.php';
require 'classes/Category.php';
require 'classes/Product.php';
require 'classes/Manufacturer.php';

// Initialize objects
$categoryObj = new Category($conn);
$productObj = new Product($conn);
$manufacturerObj = new Manufacturer($conn);

// Fetch featured categories using the Category class
$featuredCategories = $categoryObj->getFeaturedCategories(6);

// Fetch featured products using the Product class
$featuredProducts = $productObj->getFeaturedProducts();

// Fetch manufacturers using the Manufacturer class
$manufacturers = $manufacturerObj->getTopManufacturers(6);

// Fetch trending categories using the Category class
$trendingCategories = $categoryObj->getTrendingCategories();

// Fetch trending products using the Product class
$trendingProducts = $productObj->getTrendingProducts(3);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <?php include 'global/header.php'; ?>
</header>
<main>
    <!-- Hero/Carousel Section -->
    <div class="container-fluid bg-image">
        <div class="row w-100">
            <div class="col-md-12 col-lg-6 d-flex justify-content-center align-items-center">
                <div class="content-wrapper px-5">
                    <p class="small-heading pt-5"><img src="/e-commerce/assets/orange-line.svg" class="orange-line"> UPGRADE YOUR RIDE</p>
                    <h1 class="main-heading py-4">
                        Find the <span class="highlight">Perfect Parts</span> for Performance and Reliability
                    </h1>
                    <a href="category_page.php" class="btn btn-outline-light shop-now-btn py-3 px-5">Shop Now</a>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 d-flex justify-content-center align-items-center">
            <img src="/e-commerce/assets/carousel-item.png" alt="Car Parts Image" class="img-fluid" style="max-width: 450px; height: auto;">
            </div>
        </div>
    </div>


    <!-- Featured Categories Section -->
    <div class="container-fluid category-section">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-start align-items-center">
                <h2 class="category-section-title pt-5 pb-4" style="font-size: 50px; font-weight: 800;">Featured Categories</h2>
            </div>
        </div>
    </div>
    <div class="container-fluid category-menu d-flex justify-content-between d-none d-lg-block">
        <div class="row d-flex justify-content-between w-100 p-0 m-0">
            <?php if (!empty($featuredCategories)): ?>
                <?php foreach ($featuredCategories as $category): ?>
                    <div class="col-sm-6 col-md-4 col-lg-2 category-card">
                        <a href="category_page.php?category_id=<?= htmlspecialchars($category['id']) ?>" class="category-link" style="text-decoration: none;">
                            <img src="<?= htmlspecialchars($category['image_path']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="img-fluid">
                            <h5 class="category-title mt-3"><?= htmlspecialchars($category['name']) ?></h5>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No featured categories available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Carousel for Mobile View -->
    <div id="categoryCarousel" class="carousel slide d-lg-none" data-bs-ride="carousel">
        <div class="carousel-inner w-100 p-0 m-0">
            <?php
            $active = true; // This will be used to mark the first item as active
            $counter = 0; // Counter to manage items per slide

            if (!empty($featuredCategories)):
                foreach ($featuredCategories as $category):
                    if ($counter % 2 == 0): // Start a new carousel-item every 2 categories
            ?>
                <div class="carousel-item <?= $active ? 'active' : '' ?>">
                    <div class="row w-100">
            <?php $active = false; endif; ?>
                        <div class="col-6">
                            <a href="category_page.php?id=<?= htmlspecialchars($category['id']) ?>" class="category-link" style="text-decoration: none;">
                                <img src="<?= htmlspecialchars($category['image_path']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="img-fluid">
                                <h5 class="category-title mt-3"><?= htmlspecialchars($category['name']) ?></h5>
                            </a>
                        </div>
            <?php
                    $counter++;
                    if ($counter % 2 == 0): // Close the carousel-item every 2 categories
            ?>
                    </div>
                </div>
            <?php endif; endforeach; ?>
            <?php if ($counter % 2 != 0): ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php else: ?>
                <p class="text-center">No featured categories available.</p>
            <?php endif; ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
            <span class="visually-hidden">Previous</span>
            <span class="custom-control-icon">&#10094;</span>
        </button>
        <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
            <span class="visually-hidden">Next</span>
            <span class="custom-control-icon">&#10095;</span>
        </button>
    </div>
    

    <!-- Promotional Banners Section -->
    <div class="container-fluid py-5 promotional-banners">
        <div class="row w-100 gx-3">
            <!-- Promotional Banner 1 -->
            <div class="col-sm-12 col-md-12 col-lg-6 mb-4 d-flex justify-content-start align-items-center">
                <div class="card bg-dark text-white h-100">
                    <img src="/e-commerce/assets/promo-1.png" class="card-img" alt="Premium Interior Accessories">
                    <div class="col-8 card-img-overlay d-flex flex-column justify-content-center px-5">
                        <h2 class="card-title mb-3">Upgrade Your Ride with <span class="highlight">Premium Interior Accessories</span></h2>
                        <p class="card-text mb-5">Save Up to <span class="discount">40%</span> on Selected Interior Upgrades</p>
                        <a href="#" class="btn btn-orange align-self-start">
                            Shop Now <i class="bi bi-chevron-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Promotional Banner 2 -->
            <div class="col-sm-12 col-md-12 col-lg-6 mb-4 justify-content-start align-items-center">
                <div class="card bg-dark text-white h-100">
                    <img src="/e-commerce/assets/promo-2.png" class="card-img" alt="Car Lighting">
                    <div class="col-8 card-img-overlay d-flex flex-column justify-content-center px-5">
                        <h2 class="card-title mb-3">Upgrade Your <span class="highlight">Car's Lighting</span> with Premium Options</h2>
                        <p class="card-text mb-5">Save Up to <span class="discount">50%</span> on Selected Interior Upgrades</p>
                        <a href="#" class="btn btn-orange align-self-start">
                            Shop Now <i class="bi bi-chevron-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Featured Products Section -->
    <div class="container-fluid category-section">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <h2 class="category-section-title pt-5 pb-4" style="font-size: 50px; font-weight: 800; font-family: 'Roboto', sans-serif;">Featured Products</h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row w-100">
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                        <!-- Wrap the entire product card with an anchor tag -->
                        <a href="product_page.php?id=<?= htmlspecialchars($product['id']) ?>" class="product-link" style="text-decoration: none;">
                            <div class="featured-product-card">
                                <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
                                <div class="row w-100 product-nav py-2 px-0">
                                    <div class="col p-0 text-center">
                                        <a href="product_page.php?id=<?= htmlspecialchars($product['id']) ?>" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                    </div>
                                    <div class="col p-0 text-center">
                                        <a href="#" class="btn pnav-icon"><i class="bi bi-heart-fill"></i></a>
                                    </div>
                                    <div class="col p-0 text-center">
                                        <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                    </div>
                                </div>
                                <div class="product-info text-center py-3">
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <h5 class="product-name"><?= htmlspecialchars($product['name']) ?></h5>
                                    <p class="product-price">
                                        <span class="old-price">$<?= number_format($product['old_price'], 2) ?></span> 
                                        <span class="new-price">$<?= number_format($product['price'], 2) ?></span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No featured products available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Top Dealers Section -->
    <div class="top-dealers" style="background-image: url('/e-commerce/assets/carousel-bg.png');">
        <div class="container-fluid py-4">
            <div class="row w-100">
                <div class="col-12 d-flex justify-content-start align-items-center">
                    <h2 class="text-right-align my-4">Top Dealers</h2>
                </div>
                <!-- Dealer 1 -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="dealer-card d-flex p-4 shadow-sm">
                        <div class="col-12 d-flex justify-content-between dealer-logo mb-3">
                            <img src="/e-commerce/assets/dealer-logo1.png" alt="Dealer 1 Logo" class="img-fluid">
                            <p class="col-6 dealer-products">0 Products</p>
                        </div>
                        <div class="dealer-info">
                            <p class="dealer-address"><i class="bi bi-geo-alt-fill"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                            <p class="dealer-contact"><i class="bi bi-telephone-fill"></i> (+91) - 540-025-124553</p>
                        </div>
                    </div>
                </div>
                <!-- Dealer 2 -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="dealer-card d-flex p-4 shadow-sm">
                        <div class="col-12 d-flex justify-content-between dealer-logo mb-3">
                            <img src="/e-commerce/assets/dealer-logo2.png" alt="Dealer 2 Logo" class="img-fluid">
                            <p class="col-6 dealer-products">0 Products</p>
                        </div>
                        <div class="dealer-info">
                            <p class="dealer-address"><i class="bi bi-geo-alt-fill"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                            <p class="dealer-contact"><i class="bi bi-telephone-fill"></i> (+91) - 540-025-124553</p>
                        </div>
                    </div>
                </div>
                <!-- Dealer 3 -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="dealer-card d-flex p-4 shadow-sm">
                        <div class="col-12 d-flex justify-content-between dealer-logo mb-3">
                            <img src="/e-commerce/assets/dealer-logo3.png" alt="Dealer 3 Logo" class="img-fluid">
                            <p class="col-6 dealer-products">0 Products</p>
                        </div>
                        <div class="dealer-info">
                            <p class="dealer-address"><i class="bi bi-geo-alt-fill"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                            <p class="dealer-contact"><i class="bi bi-telephone-fill"></i> (+91) - 540-025-124553</p>
                        </div>
                    </div>
                </div>
                <!-- Dealer 4 -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="dealer-card d-flex p-4 shadow-sm">
                        <div class="col-12 d-flex justify-content-between dealer-logo mb-3">
                            <img src="/e-commerce/assets/dealer-logo4.png" alt="Dealer 4 Logo" class="img-fluid">
                            <p class="col-6 dealer-products">0 Products</p>
                        </div>
                        <div class="dealer-info">
                            <p class="dealer-address"><i class="bi bi-geo-alt-fill"></i> Suite 740 27542 Langworth Bridge, New Columbusshire, United States of America</p>
                            <p class="dealer-contact"><i class="bi bi-telephone-fill"></i> (+91) - 540-025-124553</p>
                        </div>
                    </div>
                </div>
                <!-- Dealer 5 -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="dealer-card d-flex p-4 shadow-sm">
                        <div class="col-12 d-flex justify-content-between dealer-logo mb-3">
                            <img src="/e-commerce/assets/dealer-logo5.png" alt="Dealer 5 Logo" class="img-fluid">
                            <p class="col-6 dealer-products">0 Products</p>
                        </div>
                        <div class="dealer-info">
                            <p class="dealer-address"><i class="bi bi-geo-alt-fill"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                            <p class="dealer-contact"><i class="bi bi-telephone-fill"></i> (+91) - 540-025-124553</p>
                        </div>
                    </div>
                </div>
                <!-- Dealer 6 -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="dealer-card d-flex p-4 shadow-sm">
                        <div class="col-12 d-flex justify-content-between dealer-logo mb-3">
                            <img src="/e-commerce/assets/dealer-logo6.png" alt="Dealer 6 Logo" class="img-fluid">
                            <p class="col-6 dealer-products">0 Products</p>
                        </div>
                        <div class="dealer-info">
                            <p class="dealer-address"><i class="bi bi-geo-alt-fill"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                            <p class="dealer-contact"><i class="bi bi-telephone-fill"></i> (+91) - 540-025-124553</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Trending Products Section -->
    <div class="container-fluid trending-section">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-start align-items-center">
                <h2 class="category-section-title pt-5 pb-4" style="font-size: 50px; font-weight: 800;">Trending Products</h2>
            </div>
        </div>
    </div>
    <div class="container-fluid trending-products">
        <div class="row w-100">
            <!-- Categories Navigation for Trending Products -->
            <div class="col-lg-12 col-xl-3 px-0">
                <div class="category-nav">
                    <ul class="nav flex-nowrap overflow-auto overflow-x-auto flex-xl-column flex-lg-row overflow-hidden" id="categoryTabs">
                        <?php if (!empty($trendingCategories)): ?>
                            <?php foreach ($trendingCategories as $category): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-category-id="<?= htmlspecialchars($category['id']) ?>" data-category-active="false">
                                        <?= htmlspecialchars($category['name']) ?>
                                        <span class="chevron-right"><i class="bi bi-chevron-right"></i></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No categories with trending products available.</p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- Trending Products Display -->
            <div id="productsCarousel" class="col-lg-12 col-xl-9 d-flex flex-xl-column flex-lg-row carousel slide p-2" style="border: 2px solid #d9d9d9">
                <div class="carousel-inner w-100 py-4 px-2 m-0">
                    <!-- Initially Display Trending Products -->
                    <?php if (!empty($trendingProducts)): ?>
                        <div class="carousel-item active">
                            <div class="row w-100">
                                <?php foreach ($trendingProducts as $product): ?>
                                    <div class="col">
                                        <div class="trending-product-card">
                                            <div class="overlay-container">
                                            <?php include 'functions/overlay-buttons.php'; ?>
                                                <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
                                            </div>
                                            <!-- Product Info -->
                                            <div class="product-info text-center py-3">
                                                <h5 class="product-name"><?= htmlspecialchars($product['name']) ?></h5>
                                                <div class="product-rating">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                                <div class="product-price">
                                                    <span class="old-price">$<?= number_format($product['old_price'], 2) ?></span>
                                                    <span class="new-price">$<?= number_format($product['price'], 2) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>No products available for this category.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Deal of the Day Section -->
    <div class="container-fluid pt-5 mt-5">
        <div class="d-flex flex-column dod-body" style="border: solid 15px #f67350;">
            <div class="container-fluid dod-section position-relative">
                <div class="row position-absolute" style="background: white">
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <h1>Deal Of The Day</h1>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center justify-content-sm-start">
                        <h3>Sale is expired</h3>
                    </div>
                </div>
            </div>
            <div class="dod-section pt-5 mt-5 px-4">
                <div class="row w-100">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="dod-product-card">
                            <img src="/e-commerce/assets/oxygen-sensors.png" alt="Oxygen Sensor" class="img-fluid product-image">
                            <div class="row w-100 product-nav py-2 px-0">
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-heart-fill"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                </div>
                            </div>
                            <div class="overlay-container">
                                <div class="product-info text-center py-3">
                                    <h5 class="product-name">Oxygen Sensor Single</h5>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <div class="product-price">
                                        <span class="old-price">$6,000.00</span>
                                        <span class="new-price">$5,500.00</span>
                                    </div>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="dod-product-card">
                            <img src="/e-commerce/assets/catalytic-converters.png" alt="Catalytic Converter Single" class="img-fluid product-image">
                            <div class="row w-100 product-nav py-2 px-0">
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-heart-fill"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                </div>
                            </div>
                            <div class="overlay-container">
                                <div class="product-info text-center py-3">
                                    <h5 class="product-name">Catalytic Converter Single</h5>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <span class="old-price">$9,000.00</span>
                                        <span class="new-price">$7,000.00</span>
                                    </div>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="dod-product-card">
                            <img src="/e-commerce/assets/power-steering-pump.png" alt="Power Steering Pump" class="img-fluid product-image">
                            <div class="row w-100 product-nav py-2 px-0">
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-heart-fill"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                </div>
                            </div>
                            <div class="overlay-container">
                                <div class="product-info text-center py-3">
                                    <h5 class="product-name">Power Steering Pump</h5>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <span class="old-price">$10,000.00</span>
                                        <span class="new-price">$9,000.00</span>
                                    </div>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="dod-product-card">
                            <img src="/e-commerce/assets/aluminum-intercooler.png" alt="Aluminum Intercooler" class="img-fluid product-image">
                            <div class="row w-100 product-nav py-2 px-0">
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-heart-fill"></i></a>
                                </div>
                                <div class="col p-0 text-center">
                                    <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                </div>
                            </div>
                            <div class="overlay-container">
                                <div class="product-info text-center py-3">
                                    <h5 class="product-name">Aluminum Intercooler</h5>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <div class="product-price">
                                        <span class="old-price">$15,000.00</span>
                                        <span class="new-price">$11,000.00</span>
                                    </div>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Browse by Brands Section -->
    <div class="container-fluid bbb-section py-5">
        <div class="row w-100">
            <div class="col-12 py-3 px-0 d-flex justify-content-start align-items-center">
                <h1>Browse By Brands</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid brands-section pb-5">
        <div class="row d-flex justify-content-between">
            <?php if (!empty($manufacturers)): ?>
                <?php foreach ($manufacturers as $manufacturer): ?>
                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 px-2 text-center brand-container">
                        <a href="manufacturer_page.php?id=<?= htmlspecialchars($manufacturer['id']) ?>">
                            <img src="<?= htmlspecialchars($manufacturer['logo_path']) ?>" alt="<?= htmlspecialchars($manufacturer['name']) ?>" class="img-fluid brand-logo">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No manufacturers available.</p>
            <?php endif; ?>
        </div>
    </div>


    <!--Promo Footer-->
    <div class="container-fluid promo-features py-5" style="background-color: #f67350;">
        <div class="row w-100 text-center">
            <!-- Feature 1 -->
            <div class="col-sm-6 col-md-6 col-lg-3 d-flex align-items-center justify-content-center">
                <div class="promo-logo">
                    <i class="bi bi-tags mb-3"></i>
                </div>
                <div class="feature-info px-3 d-flex flex-column justify-content-start">
                    <h5 class="feature-title">Best prices & offers</h5>
                    <p class="feature-text">Orders $50 or more</p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="col-sm-6 col-md-6 col-lg-3 d-flex align-items-center justify-content-center">
                <div class="promo-logo">
                    <i class="bi bi-shield-lock mb-3"></i>
                </div>
                <div class="feature-info px-3 d-flex flex-column justify-content-start">
                    <h5 class="feature-title">Secure payment</h5>
                    <p class="feature-text">100% secure payment</p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="col-sm-6 col-md-6 col-lg-3 d-flex align-items-center justify-content-center">
                <div class="promo-logo">
                    <i class="bi bi-headset mb-3"></i>
                </div>
                <div class="feature-info px-3 d-flex flex-column justify-content-start">
                    <h5 class="feature-title">Support</h5>
                    <p class="feature-text">24/7 amazing services</p>
                </div>
            </div>
            <!-- Feature 4 -->
            <div class="col-sm-6 col-md-6 col-lg-3 d-flex align-items-center justify-content-center">
                <div class="promo-logo">
                    <i class="bi bi-arrow-repeat mb-3"></i>
                </div>
                <div class="feature-info px-3 d-flex flex-column justify-content-start">
                    <h5 class="feature-title">Easy returns</h5>
                    <p class="feature-text">Orders $50 or more</p>
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

    <script>
        $(document).ready(function () {
            // Handle category click event
            $('.category-nav .nav-link').click(function (e) {
                e.preventDefault(); // Prevent default link behavior

                var categoryId = $(this).data('category-id'); // Get the category ID

                // Remove 'active' class from all and add to the clicked category
                $('.category-nav .nav-link').removeClass('active');
                $(this).addClass('active');

                // AJAX request to fetch trending products using the selected category ID
                $.ajax({
                    url: 'fetch_trending_products.php', // PHP script to fetch products
                    type: 'POST',
                    data: { category_id: categoryId }, // Pass the selected category ID
                    success: function (response) {
                        // Replace the product section with the new products
                        $('#productsCarousel .carousel-inner').html(response);

                        // Reinitialize hover effects for dynamically loaded content
                        initializeOverlayHoverEffects();
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching products: " + error);
                    }
                });
            });

            // Function to initialize hover effects for dynamically loaded content
            function initializeOverlayHoverEffects() {
                $('.trending-product-card').hover(
                    function () {
                        // On hover, show overlay buttons
                        $(this).find('.overlay-buttons').css({
                            opacity: 1,
                            visibility: 'visible',
                        });
                    },
                    function () {
                        // On hover out, hide overlay buttons
                        $(this).find('.overlay-buttons').css({
                            opacity: 0,
                            visibility: 'hidden',
                        });
                    }
                );
            }

            // Initial call to setup hover effects for existing content
            initializeOverlayHoverEffects();
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
