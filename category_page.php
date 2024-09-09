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
                    <h3 class="m-0"><strong>All Products</strong></h3>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <nav aria-label="breadcrumb" class="breadcrumb-tab">
                        <ol class="breadcrumb ms-auto">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">
                                <i class="bi bi-chevron-right mx-2"></i>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Products</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-lg-5">
        <div class="row w-100">
            <div class="col-3 category-list-column px-0">
                <div class="category-list-section py-4" id="categoryListSection">
                    <h5 class="category-list-title mb-3">Categories</h5>
                    <ul class="category-list-menu d-flex flex-column justify-content-start px-3">
                        <li><a href="#">All Products</a></li>
                        <li><a href="#">Automobile <span>(1)</span></a></li>
                        <li><a href="#">Automotive Parts <span>(7)</span></a></li>
                        <li><a href="#">Tires and Wheels <span>(4)</span></a></li>
                        <li><a href="#">Car Maintenance <span>(1)</span></a></li>
                        <li><a href="#">Electronics and Gadgets <span>(2)</span></a></li>
                        <li><a href="#">Exterior Upgrades <span>(1)</span></a></li>
                        <li><a href="#">Interior Accessories <span>(2)</span></a></li>
                        <li><a href="#">Performance Parts <span>(2)</span></a></li>
                        <li><a href="#">Safety and Security <span>(1)</span></a></li>
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
                    <!-- Product 1 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0 position-relative">
                            <img src="/e-commerce/assets/products/aluminum-intercooler.png" alt="Aluminum Intercooler" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Aluminum Intercooler</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$1,500.00</span> 
                                        <span class="category-new-price">$1,350.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
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
                    <!-- Product 2 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/power-steering-pump.png" alt="Power Steering Pump" class="img-fluid product-image">
                            <div class="overlay-container">  
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 3.5</p>
                                    </div>
                                    <h5 class="product-category-name">Power Steering Pump</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$1,800.00</span> 
                                        <span class="category-new-price">$1,620.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>  
                        </div>
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
                    <!-- Product 3 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/rims-tires.png" alt="Rim and Tire set" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Rim and Tire set</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$4,500.00</span> 
                                        <span class="category-new-price">$3,150.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>  
                        </div>
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
                    <!-- Product 4 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <div class="image-container position-relative">
                                <div class="new-tag position-absolute">New</div>
                                <img src="/e-commerce/assets/products/ball-joints.png" alt="Ball Joints" class="img-fluid product-image">
                            </div>
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Ball Joints</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$900.00</span> 
                                        <span class="category-new-price">$810.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>  
                        </div>
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
                    <!-- Product 5 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/oxygen-sensors.png" alt="Oxygen Sensors" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Oxygen Sensors</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$2,000.00</span> 
                                        <span class="category-new-price">$1,800.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 6 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/momo-steering-wheel-1.png" alt="Momo MOD27/C Steering Wheel" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Momo MOD27/C Steering Wheel</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$7,600.00</span> 
                                        <span class="category-new-price">$6,750.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 7 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/reverse-backup-camera.png" alt="AutoSky Reverse Backup Camera HD Wide View Angle" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">AutoSky Reverse Backup Camera HD Wide View Angle</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$5,000.00</span> 
                                        <span class="category-new-price">$4,500.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 8 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/bosch-oil-filter.png" alt="Bosch Oil Filter" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 5.0</p>
                                    </div>
                                    <h5 class="product-category-name">Bosch Oil Filter</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$5,000.00</span> 
                                        <span class="category-new-price">$4,500.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 9 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/car-spark-plug.png" alt="Spark Plug Car" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Spark Plug Car</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$750.00</span> 
                                        <span class="category-new-price">$675.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 10 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/brake-kit.png" alt="Front and Rear Autospecialty Brake Kit" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.5</p>
                                    </div>
                                    <h5 class="product-category-name">Front and Rear Autospecialty Brake Kit</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$10,000.00</span> 
                                        <span class="category-new-price">$9,000.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 11 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <div class="image-container position-relative">
                                <div class="sale-tag position-absolute">Sale</div>
                                <img src="/e-commerce/assets/products/car-battery-charger.png" alt="Car Battery Charger" class="img-fluid product-image">
                            </div>
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Car Battery Charger</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$15,000.00</span> 
                                        <span class="category-new-price">$13,500.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 12 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/catalytic-converters.png" alt="Catalytic Converters" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 5.0</p>
                                    </div>
                                    <h5 class="product-category-name">Catalytic Converters</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$5,500.00</span> 
                                        <span class="category-new-price">$4,950.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 13 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/gear-stick.png" alt="Gear Stick" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 5.0</p>
                                    </div>
                                    <h5 class="product-category-name">Gear Stick</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$1,500.00</span> 
                                        <span class="category-new-price">$1,350.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 14 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/momo-steering-wheel-2.png" alt="Momo R1907/33S Steering Wheel" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Momo R1907/33S Steering Wheel</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$2,000.00</span> 
                                        <span class="category-new-price">$1,800.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 15 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/car-seat.png" alt="Recliner Car Seat" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 5.0</p>
                                    </div>
                                    <h5 class="product-category-name">Recliner Car Seat</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$15,000.00</span> 
                                        <span class="category-new-price">$13,500.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 16 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/piston-sparkplug.png" alt="Engine Piston and Spark Plug Isolated White" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 5.0</p>
                                    </div>
                                    <h5 class="product-category-name">Engine Piston and Spark Plug Isolated White</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$8,000.00</span> 
                                        <span class="category-new-price">$7,200.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 17 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/brake-disc.png" alt="Brake Disc" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 3.0</p>
                                    </div>
                                    <h5 class="product-category-name">Brake Disc</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$5,000.00</span> 
                                        <span class="category-new-price">$4,500.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div> 
                        </div>
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
                    <!-- Product 18 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/alternator.png" alt="Alternator Electrical Wires & Cable Spare Part" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 5.0</p>
                                    </div>
                                    <h5 class="product-category-name">Alternator Electrical Wires & Cable Spare Part</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$20,000.00</span> 
                                        <span class="category-new-price">$18,000.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
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
                    <!-- Product 19 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/spark-plugs.png" alt="Spark Plugs" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 4.0</p>
                                    </div>
                                    <h5 class="product-category-name">Spark Plugs</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$2,500.00</span> 
                                        <span class="category-new-price">$2,250.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
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
                    <!-- Product 20 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/service-tyre.png" alt="Service Tyre" class="img-fluid product-image">
                            <div class="overlay-container">
                                <div class="product-info text-center pt-3">
                                    <div class="product-rating-category">
                                        <p><i class="bi bi-star-fill"></i> 0</p>
                                    </div>
                                    <h5 class="product-category-name">Service Tyre</h5>
                                    <p class="product-category-price">
                                        <span class="category-old-price">$8,000.00</span> 
                                        <span class="category-new-price">$7,200.00</span>
                                    </p>
                                </div>
                                <?php include 'functions/overlay-buttons.php'; ?>
                            </div>
                        </div>
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