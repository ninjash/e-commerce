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
                <h2 class="category-section-title pt-5 pb-4" style="font-size: 50px; font-weight: 800; font-family: 'Roboto', sans-serif;">Featured Categories</h2>
            </div>
        </div>
    </div>
    <div class="container-fluid category-menu d-flex justify-content-between d-none d-lg-block">
        <div class="row d-flex justify-content-between w-100 p-0 m-0">
            <!-- Category 1 -->
            <div class="col-sm-6 col-md-4 col-lg-2 category-card">
                <a href="bumper-cover.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/bumper_cover.png" alt="Bumper Cover" class="img-fluid">
                    <h5 class="category-title mt-3">Bumper Cover</h5>
                    <p class="text-muted">4 Items</p>
                </a>
            </div>
            <!-- Category 2 -->
            <div class="col-sm-6 col-md-4 col-lg-2 category-card">
                <a href="headlights.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/headlights_-and-_components.png" alt="Headlights and Components" class="img-fluid">
                    <h5 class="category-title mt-3">Headlights</h5>
                    <p class="text-muted">1 Items</p>
                </a>
            </div>
            <!-- Category 3 -->
            <div class="col-sm-6 col-md-4 col-lg-2 category-card">
                <a href="mirrors.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/part-mirrors.png" alt="Mirrors" class="img-fluid">
                    <h5 class="category-title mt-3">Mirrors</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 4 -->
            <div class="col-sm-6 col-md-4 col-lg-2 category-card">
                <a href="grille-assemblies.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/grille_assembly_bundles_images.png" alt="Grille Assembly" class="img-fluid">
                    <h5 class="category-title mt-3">Grille Assemblies</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 5 -->
            <div class="col-sm-6 col-md-4 col-lg-2 category-card">
                <a href="fenders.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/fenders_-and-_components.png" alt="Fender" class="img-fluid">
                    <h5 class="category-title mt-3">Fenders</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 6 -->
            <div class="col-sm-6 col-md-4 col-lg-2 category-card">
                <a href="tail-lights.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/tail_lights_-and-_components.png" alt="Tail lights and Components" class="img-fluid">
                    <h5 class="category-title mt-3">Tail Lights</h5>
                    <p class="text-muted">1 Items</p>
                </a>
            </div>
        </div>
    </div>
    <!-- Carousel for Mobile View -->
    <div id="categoryCarousel" class="carousel slide d-lg-none">
        <div class="carousel-inner w-100 p-0 m-0">
            <!-- Category 1 -->
            <div class="carousel-item active">
                <div class="row w-100">
                    <div class="col">
                        <a href="bumper-cover.html" class="category-link" style="text-decoration: none;">
                            <img src="/e-commerce/assets/bumper_cover.png" alt="Bumper Cover" class="img-fluid">
                            <h5 class="category-title mt-3">Bumper Cover</h5>
                            <p class="text-muted">4 Items</p>
                        </a>
                    </div>
                <!-- Category 2 -->
                    <div class="col">
                        <a href="headlights.html" class="category-link" style="text-decoration: none;">
                            <img src="/e-commerce/assets/headlights_-and-_components.png" alt="Headlights and Components" class="img-fluid">
                            <h5 class="category-title mt-3">Headlights</h5>
                            <p class="text-muted">1 Items</p>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Category 3 -->
            <div class="carousel-item">
                <div class="row">
                    <div class="col">
                        <a href="mirrors.html" class="category-link" style="text-decoration: none;">
                            <img src="/e-commerce/assets/part-mirrors.png" alt="Mirrors" class="img-fluid">
                            <h5 class="category-title mt-3">Mirrors</h5>
                            <p class="text-muted">2 Items</p>
                        </a>
                    </div>
                <!-- Category 4 -->
                    <div class="col">
                        <a href="grille-assemblies.html" class="category-link" style="text-decoration: none;">
                            <img src="/e-commerce/assets/grille_assembly_bundles_images.png" alt="Grille Assembly" class="img-fluid">
                            <h5 class="category-title mt-3">Grille Assemblies</h5>
                            <p class="text-muted">2 Items</p>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Category 5 -->
            <div class="carousel-item">
                <div class="row">
                    <div class="col">
                        <a href="fenders.html" class="category-link" style="text-decoration: none;">
                            <img src="/e-commerce/assets/fenders_-and-_components.png" alt="Fender" class="img-fluid">
                            <h5 class="category-title mt-3">Fenders</h5>
                            <p class="text-muted">2 Items</p>
                        </a>
                    </div>
                <!-- Category 6 -->
                    <div class="col">
                        <a href="tail-lights.html" class="category-link" style="text-decoration: none;">
                            <img src="/e-commerce/assets/tail_lights_-and-_components.png" alt="Tail lights and Components" class="img-fluid">
                            <h5 class="category-title mt-3">Tail Lights</h5>
                            <p class="text-muted">1 Items</p>
                        </a>
                    </div>
                </div>
            </div>
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
            <!-- Row 1 -->
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <img src="/e-commerce/assets/aluminum-intercooler.png" alt="Aluminum Intercooler" class="img-fluid">
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
                    <div class="product-info text-center py-3">
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
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <img src="/e-commerce/assets/reverse-backup-camera.png" alt="AutoSky Reverse Backup Camera HD" class="img-fluid">
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
                    <div class="product-info text-center py-3">
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="product-name">AutoSky Reverse Backup Camera HD Wide View Angle</h5>
                        <p class="product-price">
                            <span class="old-price">$5,000.00</span> 
                            <span class="new-price">$4,500.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <div class="image-container position-relative">
                        <div class="new-tag position-absolute">New</div>
                        <img src="/e-commerce/assets/ball-joints.png" alt="Ball Joints" class="img-fluid">
                    </div>
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
                    <div class="product-info text-center py-3">
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
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <img src="/e-commerce/assets/brake-disc.png" alt="Brake Disc" class="img-fluid">
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
                    <div class="product-info text-center py-3">
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
             <!-- Product 5 -->
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <div class="image-container position-relative">
                        <div class="sale-tag position-absolute">Sale</div>
                        <img src="/e-commerce/assets/products/car-battery-charger.png" alt="Car Battery Charger" class="img-fluid product-image">
                    </div>
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
                    <div class="product-info text-center py-3">
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
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <img src="/e-commerce/assets/catalytic-converters.png" alt="Catalytic Converters" class="img-fluid">
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
                    <div class="product-info text-center py-3">
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
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <img src="/e-commerce/assets/oxygen-sensors.png" alt="Oxygen Sensors" class="img-fluid">
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
                    <div class="product-info text-center py-3">
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
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="featured-product-card">
                    <img src="/e-commerce/assets/power-steering-pump.png" alt="Power Steering Pump" class="img-fluid">
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
                    <div class="product-info text-center py-3">
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
                <h2 class="category-section-title pt-5 pb-4" style="font-size: 50px; font-weight: 800; font-family: 'Roboto', sans-serif;">Trending Products</h2>
            </div>
        </div>
    </div>
    <div class="container-fluid trending-products">
        <div class="row w-100">
            <!-- Categories Navigation -->
            <div class="col-lg-12 col-xl-3 px-0">
                <div class="category-nav">
                    <ul class="nav flex-nowrap overflow-auto overflow-x-auto flex-xl-column flex-lg-row overflow-hidden" id="categoryTabs">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Automotive Parts<span class="chevron-right"><i class="bi bi-chevron-right"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tires and Wheels<span class="chevron-right"><i class="bi bi-chevron-right"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Car Maintenance<span class="chevron-right"><i class="bi bi-chevron-right"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Electronics and Gadgets<span class="chevron-right"><i class="bi bi-chevron-right"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Exterior Upgrades<span class="chevron-right"><i class="bi bi-chevron-right"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Interior Accessories<span class="chevron-right"><i class="bi bi-chevron-right"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Performance Parts<span class="chevron-right"><i class="bi bi-chevron-right"></i></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Products Display -->
            <div id="productsCarousel" class="col-lg-12 col-xl-9 d-flex flex-xl-column flex-lg-row carousel slide p-2" style="border: 2px solid #d9d9d9">
                <div class="carousel-inner w-100 py-4 px-2 m-0">
                    <div class="carousel-item active">
                        <div class="row w-100">
                            <div class="col">
                                <div class="trending-product-card">
                                    <img src="/e-commerce/assets/brake-disc.png" alt="Brake Disc" class="img-fluid">
                                    <div class="product-info text-center py-3">
                                        <h5 class="product-name">Brake Disc</h5>
                                        <div class="product-rating">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                            <i class="bi bi-star"></i>
                                        </div>
                                        <div class="product-price">
                                            <span class="old-price">$5,000.00</span>
                                            <span class="new-price">$4,500.00</span>
                                        </div>
                                        <div class="row w-100 trending-product-nav">
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-heart"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="trending-product-card">
                                    <img src="/e-commerce/assets/car-battery-charger.png" alt="Car Battery" class="img-fluid">
                                    <div class="product-info text-center py-3">
                                        <h5 class="product-name">Car Battery</h5>
                                        <div class="product-rating">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                        </div>
                                        <div class="product-price">
                                            <span class="old-price">$8,000.00</span>
                                            <span class="new-price">$7,200.00</span>
                                        </div>
                                        <div class="row w-100 trending-product-nav">
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-heart"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="trending-product-card">
                                    <img src="/e-commerce/assets/power-steering-pump.png" alt="Power Steering Pump" class="img-fluid">
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
                                        <div class="row w-100 trending-product-nav">
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-heart"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--slide 2-->
                    <div class="carousel-item">
                        <div class="row w-100">
                            <div class="col">
                                <div class="trending-product-card">
                                    <img src="/e-commerce/assets/oxygen-sensors.png" alt="Oxygen Sensor" class="img-fluid">
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
                                        <div class="row w-100 trending-product-nav">
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-heart"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="trending-product-card">
                                    <img src="/e-commerce/assets/catalytic-converters.png" alt="Catalytic Converter Single" class="img-fluid">
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
                                        <div class="row w-100 trending-product-nav">
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-heart"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="trending-product-card">
                                    <img src="/e-commerce/assets/aluminum-intercooler.png" alt="Aluminum Intercooler" class="img-fluid">
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
                                        <div class="row w-100 trending-product-nav">
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-heart"></i></a>
                                            </div>
                                            <div class="col p-0 text-center">
                                                <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
                        <span class="visually-hidden">Previous</span>
                        <span class="custom-control-icon">&#10094;</span>
                    </button>
                    <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
                        <span class="visually-hidden">Next</span>
                        <span class="custom-control-icon">&#10095;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Deal of the Day Section -->
    <div class="container-fluid dod-section">
        <div class="row w-100">
            <div class="col-md-8 col-lg-3 col-xl-3 py-lg-5 px-lg-5 py-md-3 px-md-4 d-flex justify-content-start align-items-center">
                <h1>Deal Of The Day</h1>
            </div>
            <div class="col-md-8 col-lg-3 col-xl-3 py-lg-5 px-lg-3 py-md-3 px-md-4 d-flex flex-row justify-content-center align-items-center">
                <h3>Sale is expired</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid dod-section pb-5">
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
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 px-2 text-center brand-container">
                <a href="#">
                    <img src="/e-commerce/assets/brand (1).png" alt="Brand 1" class="img-fluid brand-logo">
                </a>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 px-2 text-center brand-container">
                <a href="#">
                    <img src="/e-commerce/assets/brand (2).png" alt="Brand 2" class="img-fluid brand-logo">
                </a>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 px-2 text-center brand-container">
                <a href="#">
                    <img src="/e-commerce/assets/brand (3).png" alt="Brand 3" class="img-fluid brand-logo">
                </a>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 px-2 text-center brand-container">
                <a href="#">
                    <img src="/e-commerce/assets/brand (4).png" alt="Brand 4" class="img-fluid brand-logo">
                </a>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 px-2 text-center brand-container">
                <a href="#">
                    <img src="/e-commerce/assets/brand (5).png" alt="Brand 5" class="img-fluid brand-logo">
                </a>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 px-2 text-center brand-container">
                <a href="#">
                    <img src="/e-commerce/assets/brand (6).png" alt="Brand 6" class="img-fluid brand-logo">
                </a>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
