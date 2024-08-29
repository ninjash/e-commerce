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
    <!-- Top Bar -->
    <div class="top-bar bg-dark py-2">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-around w-100">
                <div class="d-flex align-items-center" style="padding-left: 90px">
                    <a href="#" class="text-white me-3">Shipping</a>
                    <a href="#" class="text-white me-3">FAQ</a>
                    <a href="#" class="text-white">Track Order</a>
                </div>
                <div class="text-white mx-auto text-center">
                    Free Shipping Worldwide
                </div>
                <div class="d-flex align-items-center" style="padding-right: 90px">
                    <a href="#" class="text-white me-3">Default USD pricelist <i class="bi bi-chevron-down"></i></a>
                    <span class="separator text-white">|</span>
                    <a href="#" class="text-white ms-3">English (US) <i class="bi bi-chevron-down"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>
    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="/e-commerce/assets/auto-logo.png" alt="Auto-Logo" style="max-height: 150px; width: auto;">
            </a>
            <!-- Search Bar -->
            <form class="d-flex search-bar">
                <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                <button class="btn search-btn" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <!-- Icons -->
            <div class="d-flex align-items-center">
                <a href="#" class="btn btn-light me-3"><i class="bi bi-person"></i></a>
                <a href="#" class="btn btn-light"><i class="bi bi-cart"></i></a>
            </div>
        </div>
    </nav>
    <!-- Category and Navigation Links -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" style="padding: 0px;">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <button class="btn btn-orange category-btn">
                <i class="bi bi-list"></i> ALL CATEGORIES <i class="bi bi-chevron-down"></i>
            </button>
            <ul class="navbar-nav ms-1 me-5">
                <li class="nav-item"><a class="nav-link" href="#">HOME</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        GADGETS
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">SHOP</a></li>
                <li class="nav-item"><a class="nav-link" href="#">BLOG</a></li>
                <li class="nav-item"><a class="nav-link" href="#">INDUSTRY</a></li>
                <li class="nav-item"><a class="nav-link" href="#">SHOP BY CATEGORY</a></li>
                <li class="nav-item"><a class="nav-link" href="#">EXTRA PAGES</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span><i class="bi bi-plus"></i></span>
                    </a>
                </li>
            </ul>
            <a href="#" class="btn call-btn d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <span class="icon-circle">
                        <i class="bi bi-telephone-fill"></i>
                    </span>
                    <div class="col text-start py-2">
                        <p class="call-text ms-2">CALL US ON</p>
                        <span class="call-num ms-2">(1800) 11-55-854</span>
                    </div>
                </div>
            </a>
        </div>
    </nav>
<main>
   <!-- Hero/Carousel Section -->
   <div class="hero-section d-flex align-items-center justify-content-center"
        style="
        background-image: url('/e-commerce/assets/carousel-bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 100%;
        display: flex;
        align-items: center;">
        <div class="container">
            <div class="row w-100 align-items-center">
                <div class="col-lg-6">
                    <div class="content-wrapper">
                        <p class="small-heading">UPGRADE YOUR RIDE</p>
                        <h1 class="main-heading">
                            Find the <span class="highlight">Perfect Parts</span> for Performance and Reliability
                        </h1>
                        <a href="#" class="btn btn-outline-light shop-now-btn">Shop Now</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="/e-commerce/assets/carousel-item.png" alt="Car Parts Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Categories Section -->
    <div class="container-fluid">
        <div class="col-12 category-menu px-5">
            <h2 class="text-right-align m-4">Featured Categories</h2>
        </div>
    </div>
    <div class="container-fluid d-flex justify-content-evenly">
        <div class="row justify-content-around text-center">
            <!-- Category 1 -->
            <div class="col-md-4 col-lg-2">
                <a href="bumper-cover.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/bumper_cover.webp" alt="Bumper Cover" class="img-fluid">
                    <h5 class="category-title mt-3">Bumper Cover</h5>
                    <p class="text-muted">4 Items</p>
                </a>
            </div>
            <!-- Category 2 -->
            <div class="col-md-4 col-lg-2">
                <a href="headlights.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/headlights_-and-_components.webp" alt="Headlights and Components" class="img-fluid">
                    <h5 class="category-title mt-3">Headlights</h5>
                    <p class="text-muted">1 Items</p>
                </a>
            </div>
            <!-- Category 3 -->
            <div class="col-md-4 col-lg-2">
                <a href="mirrors.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/part-mirrors.webp" alt="Mirrors" class="img-fluid">
                    <h5 class="category-title mt-3">Mirrors</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 4 -->
            <div class="col-md-4 col-lg-2">
                <a href="grille-assemblies.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/grille_assembly_bundles_images.webp" alt="Grille Assembly" class="img-fluid">
                    <h5 class="category-title mt-3">Grille Assemblies</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 5 -->
            <div class="col-md-4 col-lg-2">
                <a href="fenders.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/fenders_-and-_components.webp" alt="Fender" class="img-fluid">
                    <h5 class="category-title mt-3">Fenders</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 6 -->
            <div class="col-md-4 col-lg-2">
                <a href="tail-lights.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/tail_lights_-and-_components.webp" alt="Tail lights and Components" class="img-fluid">
                    <h5 class="category-title mt-3">Tail Lights</h5>
                    <p class="text-muted">1 Items</p>
                </a>
            </div>
        </div>
    </div>
    <!-- Promotional Banners Section -->
    <div class="container-fluid my-5">
        <div class="row w-100">
            <!-- Promotional Banner 1 -->
            <div class="col-md-6">
                <div class="promotional-banner position-relative">
                    <img src="/e-commerce/assets/promo-1.png" alt="Premium Interior Accessories" class="img-fluid">
                    <div class="promo-content">
                        <div class="col-7">
                            <h2>Upgrade Your Ride with <span class="highlight">Premium<br>Interior Accessories</span></h2><br>
                            <p>Save Up to <span class="discount">40%</span> on Selected Interior Upgrades</p><br>
                            <a href="#" class="btn btn-orange">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Promotional Banner 2 -->
            <div class="col-md-6">
                <div class="promotional-banner position-relative">
                    <img src="/e-commerce/assets/promo-2.png" alt="Car Lighting" class="img-fluid">
                    <div class="promo-content">
                        <div class="col-7">
                            <h2>Upgrade Your<br><span class="highlight">Car's Lighting</span> with Premium Options</h2><br>
                            <p>Save Up to <span class="discount">50%</span> on Selected Interior Upgrades</p><br>
                            <a href="#" class="btn btn-orange">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Products Section -->
    <div class="container featured-products my-5">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="row justify-content-center text-center">
            <!-- Row 1 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/aluminum-intercooler.webp" alt="Aluminum Intercooler" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">Aluminum Intercooler</h5>
                        <p class="product-price">
                            <span class="old-price">$4,500.00</span> 
                            <span class="new-price">$1,350.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/reverse-backup-camera.webp" alt="AutoSky Reverse Backup Camera HD" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">AutoSky Reverse Backup Camera HD</h5>
                        <p class="product-price">
                            <span class="old-price">$5,000.00</span> 
                            <span class="new-price">$4,500.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/ball-joints.webp" alt="Ball Joints" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">Ball Joints</h5>
                        <p class="product-price">
                            <span class="old-price">$900.00</span> 
                            <span class="new-price">$810.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 4 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/brake-disc.webp" alt="Brake Disc" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">Brake Disc</h5>
                        <p class="product-price">
                            <span class="old-price">$5,000.00</span> 
                            <span class="new-price">$4,500.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Row 2 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/car-battery-charger.webp" alt="Car Battery Charger" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">Car Battery Charger</h5>
                        <p class="product-price">
                            <span class="old-price">$15,000.00</span> 
                            <span class="new-price">$13,500.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 6 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/catalytic-converters.webp" alt="Catalytic Converters" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">Catalytic Converters</h5>
                        <p class="product-price">
                            <span class="old-price">$5,500.00</span> 
                            <span class="new-price">$4,950.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 7 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/oxygen-sensors.webp" alt="Oxygen Sensors" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">Oxygen Sensors</h5>
                        <p class="product-price">
                            <span class="old-price">$2,000.00</span> 
                            <span class="new-price">$1,800.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 8 -->
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/power-steering-pump.webp" alt="Power Steering Pump" class="img-fluid">
                    <div class="product-info">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">Power Steering Pump</h5>
                        <p class="product-price">
                            <span class="old-price">$1,000.00</span> 
                            <span class="new-price">$1,620.00</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Top Dealers Section -->
<div class="top-dealers" style="background-image: url('/e-commerce/assets/carousel-bg.png');">
    <div class="container py-4">
        <h2 class="text-right-align my-4">Top Dealers</h2>
        <div class="row justify-content-center">
            <!-- Dealer 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="dealer-card p-4 shadow-sm">
                    <div class="dealer-logo mb-3 text-center">
                        <img src="/e-commerce/assets/dealer-logo1.png" alt="Dealer 1 Logo" class="img-fluid">
                    </div>
                    <div class="dealer-info">
                        <p class="dealer-products">0 Products</p>
                        <p class="dealer-address"><i class="bi bi-geo-alt"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                        <p class="dealer-contact"><i class="bi bi-telephone"></i> (+91) - 540-025-124553</p>
                    </div>
                </div>
            </div>
            <!-- Dealer 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="dealer-card p-4 shadow-sm">
                    <div class="dealer-logo mb-3 text-center">
                        <img src="/e-commerce/assets/dealer-logo2.png" alt="Dealer 2 Logo" class="img-fluid">
                    </div>
                    <div class="dealer-info">
                        <p class="dealer-products">0 Products</p>
                        <p class="dealer-address"><i class="bi bi-geo-alt"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                        <p class="dealer-contact"><i class="bi bi-telephone"></i> (+91) - 540-025-124553</p>
                    </div>
                </div>
            </div>
            <!-- Dealer 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="dealer-card p-4 shadow-sm">
                    <div class="dealer-logo mb-3 text-center">
                        <img src="/e-commerce/assets/dealer-logo3.png" alt="Dealer 3 Logo" class="img-fluid">
                    </div>
                    <div class="dealer-info">
                        <p class="dealer-products">0 Products</p>
                        <p class="dealer-address"><i class="bi bi-geo-alt"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                        <p class="dealer-contact"><i class="bi bi-telephone"></i> (+91) - 540-025-124553</p>
                    </div>
                </div>
            </div>
            <!-- Dealer 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="dealer-card p-4 shadow-sm">
                    <div class="dealer-logo mb-3 text-center">
                        <img src="/e-commerce/assets/dealer-logo4.png" alt="Dealer 4 Logo" class="img-fluid">
                    </div>
                    <div class="dealer-info">
                        <p class="dealer-products">0 Products</p>
                        <p class="dealer-address"><i class="bi bi-geo-alt"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                        <p class="dealer-contact"><i class="bi bi-telephone"></i> (+91) - 540-025-124553</p>
                    </div>
                </div>
            </div>
            <!-- Dealer 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="dealer-card p-4 shadow-sm">
                    <div class="dealer-logo mb-3 text-center">
                        <img src="/e-commerce/assets/dealer-logo5.png" alt="Dealer 5 Logo" class="img-fluid">
                    </div>
                    <div class="dealer-info">
                        <p class="dealer-products">0 Products</p>
                        <p class="dealer-address"><i class="bi bi-geo-alt"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                        <p class="dealer-contact"><i class="bi bi-telephone"></i> (+91) - 540-025-124553</p>
                    </div>
                </div>
            </div>
            <!-- Dealer 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="dealer-card p-4 shadow-sm">
                    <div class="dealer-logo mb-3 text-center">
                        <img src="/e-commerce/assets/dealer-logo6.png" alt="Dealer 6 Logo" class="img-fluid">
                    </div>
                    <div class="dealer-info">
                        <p class="dealer-products">0 Products</p>
                        <p class="dealer-address"><i class="bi bi-geo-alt"></i> 892382 J Ajman Fujairah United Arab Emirates</p>
                        <p class="dealer-contact"><i class="bi bi-telephone"></i> (+91) - 540-025-124553</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Trending Products Section -->
    <div class="container my-5">
        <h2 class="text-center">Trending Products</h2>
        <div class="row">
            <div class="col-md-3">
                <!-- Vertical Tabs for Categories -->
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Automotive Parts</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Tires and Wheels</a>
                    <!-- Additional Categories -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="row">
                            <!-- Trending Product 1 -->
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="/e-commerce/assets/temp.png" class="card-img-top" alt="Product Name">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Product Name</h5>
                                        <p class="card-text">$Price</p>
                                        <a href="#" class="btn btn-primary">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Next Product -->
                        </div>
                    </div>
                    <!-- Additional Sections -->
                </div>
            </div>
        </div>
    </div>

    <!-- Deal of the Day Section -->
    <div class="container my-5">
        <h2 class="text-center">Deal of the Day</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/e-commerce/assets/temp.png" class="img-fluid rounded-start" alt="Deal Product">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Deal Product Name</h5>
                                <p class="card-text">$Price</p>
                                <p class="card-text"><small class="text-danger">Sale is expired</small></p>
                                <a href="#" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Browse by Brands Section -->
    <div class="container my-5">
        <h2 class="text-center">Browse By Brands</h2>
        <div class="d-flex overflow-auto">
            <!-- Brand 1 -->
            <div class="me-3">
                <img src="/e-commerce/assets/temp.png" alt="Brand Name" class="img-fluid">
            </div>
            <!-- Next Brand -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Our Services</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Company Information</a></li>
                        <li><a href="#" class="text-white">Conditions of Sale</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Others</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Fast Shipping</a></li>
                        <li><a href="#" class="text-white">Secure Payment</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Payment Options</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Visa</a></li>
                        <li><a href="#" class="text-white">MasterCard</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Connect with Us</h5>
                    <ul class="list-unstyled d-flex">
                        <li><a href="#" class="text-white me-3">Facebook</a></li>
                        <li><a href="#" class="text-white me-3">Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</main>
    <div class="bg-secondary text-center text-white py-2">
        <div class="container">
            <p class="mb-0">© 2024 Car Parts E-Commerce. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
