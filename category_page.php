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
                    <a href="#" class="btn btn-light icon-buttons"><i class="bi bi-person"></i></a>
                    <a href="#" class="btn btn-light"><i class="bi bi-cart"></i></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </nav>


    <!-- Category and Navigation Links -->
    <nav class="navbar navbar-expand-lg navbar-light category-nav bg-white border-bottom py-0">
        <div class="container-fluid">
            <div class="row w-100" style="height: 100%;">
                <div class="col-sm-4 col-md-4 col-lg-2 d-flex justify-content-start align-items-center ps-0 pe-0">
                    <div class="dropdown d-flex" style="width: 100%; height: 100%;">    
                        <button class="btn btn-orange category-btn d-flex justify-content-start align-items-center" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list"></i> 
                            <span>ALL CATEGORIES</span>
                            <span class="ms-auto d-flex align-items-center">
                                <i class="bi bi-chevron-down d-flex justify-content-end align-items-end"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Category 1</a></li>
                            <li><a class="dropdown-item" href="#">Category 2</a></li>
                            <li><a class="dropdown-item" href="#">Category 3</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 col-md-12 col-lg-8 d-flex justify-content-evenly align-items-center ps-3 pe-5">
                    <ul class="navbar-nav d-flex justify-content-between w-100 p-0 m-0">
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
    <!-- Off Canvas for Mobile View -->
    <div class="container-fluid">
        <div class="offcanvas offcanvas-end offcanvas-lg" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header d-flex justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body w-100">
                <form class="d-flex search-bar">
                    <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                    <button class="btn search-btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ALL CATEGORIES
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Option 1</a></li>
                            <li><a class="dropdown-item" href="#">Option 2</a></li>
                        </ul>
                    </li>
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
            </div>
        </div>
    </div>
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
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/aluminum-intercooler.png" alt="Aluminum Intercooler" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/power-steering-pump.png" alt="Power Steering Pump" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/rims-tires.png" alt="Rim and Tire set" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/ball-joints.png" alt="Ball Joints" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/oxygen-sensors.png" alt="Oxygen Sensors" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/momo-steering-wheel-1.png" alt="Momo MOD27/C Steering Wheel" class="img-fluid">
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
                        </div>
                        <div class="row w-100 product-nav-category px-0">
                            <div class="col p-0 text-center">
                                <a href="#" class="btn pnav-icon"><i class="bi bi-cart"></i></a>
                            </div>
                            <div class="col p-0 text-center">
                                <a href="#" class="btn pnav-icon"><i class="bi bi-heartbi-heart"></i></a>
                            </div>
                            <div class="col p-0 text-center">
                                <a href="#" class="btn pnav-icon"><i class="bi bi-eye"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Product 7 -->
                    <div class="col-sm-12 col-md-6 col-lg-3 category-product mb-4 p-0">
                        <div class="product-category-card p-3 pb-0">
                            <img src="/e-commerce/assets/products/reverse-backup-camera.png" alt="AutoSky Reverse Backup Camera HD Wide View Angle" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/bosch-oil-filter.png" alt="Bosch Oil Filter" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/car-spark-plug.png" alt="Spark Plug Car" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/brake-kit.png" alt="Front and Rear Autospecialty Brake Kit" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/car-battery-charger.png" alt="Car Battery Charger" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/catalytic-converters.png" alt="Catalytic Converters" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/gear-stick.png" alt="Gear Stick" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/momo-steering-wheel-2.png" alt="Momo R1907/33S Steering Wheel" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/car-seat.png" alt="Recliner Car Seat" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/piston-sparkplug.png" alt="Engine Piston and Spark Plug Isolated White" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/brake-disc.png" alt="Brake Disc" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/alternator.png" alt="Alternator Electrical Wires & Cable Spare Part" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/spark-plugs.png" alt="Spark Plugs" class="img-fluid">
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
                            <img src="/e-commerce/assets/products/service-tyre.png" alt="Service Tyre" class="img-fluid">
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
    <footer class="text-white footer-body py-4">
        <div class="container-fluid">
            <div class="row w-100">
                <!-- Logo and Address Section -->
                <div class="col-md-6 col-lg-3 col-xl-3">
                    <img src="/e-commerce/assets/auto-logo.png" alt="Logo" class="img-fluid mb-3" style="max-height: 150px;">
                    <p>
                        <strong>Address :</strong><br>
                        C/801, Dev Aurum Commercial, Near Anandnagar Cross Roads, Prahlad Nagar, Ahmedabad - 380015, Gujarat, India
                    </p>
                    <p>
                        <strong>Phone :</strong><br>
                        +91 91067 47559
                    </p>
                </div>
                <!-- Our Services Section -->
                <div class="col-md-6 col-lg-3 col-xl-3 pt-4">
                    <h5 class="footer-heading">OUR SERVICES</h5>
                    <ul class="list d-flex flex-column justify-content-between">
                        <li class="flex-grow-1 d-flex align-items-center"><a href="#">Company Information</a></li>
                        <li><a href="#">Conditions of Sales</a></li>
                        <li><a href="#">Privacy policy</a></li>
                        <li><a href="#">Returns and refunds</a></li>
                        <li><a href="#">Dispute Resolution</a></li>
                    </ul>
                </div>
                <!-- Others Section -->
                <div class="col-md-6 col-lg-3 col-xl-3 pt-4">
                    <h5 class="footer-heading">Others</h5>
                    <ul class="list">
                        <li><a href="#">Fast Shipping</a></li>
                        <li><a href="#">Paypal/Secure Payment</a></li>
                        <li><a href="#">30 Days Return Policy</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Business Development</a></li>
                    </ul>
                </div>
                <!-- Payment Options Section -->
                <div class="col-md-6 col-lg-3 col-xl-3 pt-4">
                    <h5 class="footer-heading">PAYMENT OPTIONS</h5>
                    <img src="/e-commerce/assets/credit-card.png" alt="Payment Options" class="img-fluid pt-4">
                <!-- Connect with Us Section -->
                    <h5 class="footer-heading pt-4">CONNECT WITH US</h5>
                    <ul class="list-unstyled d-flex pt-3">
                        <li><a href="#" class="social-icons me-3"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="#" class="social-icons me-3"><i class="bi bi-twitter"></i></a></li>
                        <li><a href="#" class="social-icons me-3"><i class="bi bi-linkedin"></i></a></li>
                        <li><a href="#" class="social-icons me-3"><i class="bi bi-youtube"></i></a></li>
                        <li><a href="#" class="social-icons"><i class="bi bi-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</main>
<div class="text-center text-white footer-secondary py-2">
        <div class="container">
            <p class="mb-0">© 2024 Car Parts E-Commerce. All Rights Reserved.  English  | Francais</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>