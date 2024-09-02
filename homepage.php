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
                    <a class="navbar-brand" href="#">
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
                <div class="col-sm-4 col-md-4 col-lg-2 d-flex justify-content-start align-items-center pe-0">
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
    <!-- Hero/Carousel Section -->
    <div class="container-fluid bg-image">
        <div class="row w-100">
            <div class="col-md-12 col-lg-6 d-flex justify-content-center align-items-center">
                <div class="content-wrapper px-5">
                    <p class="small-heading pt-5"><img src="/e-commerce/assets/orange-line.svg" class="orange-line"> UPGRADE YOUR RIDE</p>
                    <h1 class="main-heading py-4">
                        Find the <span class="highlight">Perfect Parts</span> for Performance and Reliability
                    </h1>
                    <a href="#" class="btn btn-outline-light shop-now-btn py-3 px-5">Shop Now</a>
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
            <div class="col-md-4 col-lg-4 col-xl-2">
                <a href="bumper-cover.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/bumper_cover.png" alt="Bumper Cover" class="img-fluid">
                    <h5 class="category-title mt-3">Bumper Cover</h5>
                    <p class="text-muted">4 Items</p>
                </a>
            </div>
            <!-- Category 2 -->
            <div class="col-md-4 col-lg-4 col-xl-2">
                <a href="headlights.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/headlights_-and-_components.png" alt="Headlights and Components" class="img-fluid">
                    <h5 class="category-title mt-3">Headlights</h5>
                    <p class="text-muted">1 Items</p>
                </a>
            </div>
            <!-- Category 3 -->
            <div class="col-md-4 col-lg-4 col-xl-2">
                <a href="mirrors.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/part-mirrors.png" alt="Mirrors" class="img-fluid">
                    <h5 class="category-title mt-3">Mirrors</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 4 -->
            <div class="col-md-4 col-lg-4 col-xl-2">
                <a href="grille-assemblies.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/grille_assembly_bundles_images.png" alt="Grille Assembly" class="img-fluid">
                    <h5 class="category-title mt-3">Grille Assemblies</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 5 -->
            <div class="col-md-4 col-lg-4 col-xl-2">
                <a href="fenders.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/fenders_-and-_components.png" alt="Fender" class="img-fluid">
                    <h5 class="category-title mt-3">Fenders</h5>
                    <p class="text-muted">2 Items</p>
                </a>
            </div>
            <!-- Category 6 -->
            <div class="col-md-4 col-lg-4 col-xl-2">
                <a href="tail-lights.html" class="category-link" style="text-decoration: none;">
                    <img src="/e-commerce/assets/tail_lights_-and-_components.png" alt="Tail lights and Components" class="img-fluid">
                    <h5 class="category-title mt-3">Tail Lights</h5>
                    <p class="text-muted">1 Items</p>
                </a>
            </div>
        </div>
    </div>
    <!-- Carousel for Mobile View -->
    <div id="categoryCarousel" class="carousel slide d-lg-none" data-bs-ride="carousel">
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
            <div class="col-md-12 col-lg-6 mb-4 d-flex justify-content-start align-items-center">
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
            <div class="col-md-12 col-lg-6 mb-4 justify-content-start align-items-center">
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
                <div class="product-card">
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
                <div class="product-card">
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
                        <h5 class="product-name">AutoSky Reverse Backup Camera HD</h5>
                        <p class="product-price">
                            <span class="old-price">$5,000.00</span> 
                            <span class="new-price">$4,500.00</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
                <div class="product-card">
                    <img src="/e-commerce/assets/ball-joints.png" alt="Ball Joints" class="img-fluid">
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
                <div class="product-card">
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
                <div class="product-card">
                    <img src="/e-commerce/assets/car-battery-charger.png" alt="Car Battery Charger" class="img-fluid">
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
                <div class="product-card">
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
                <div class="product-card">
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
                <div class="product-card">
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
            <div class="col-lg-3 col-md-4">
                <div class="category-nav bg-dark text-white">
                    <ul class="nav flex-column">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Automotive Parts <span class="chevron-right">></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tires and Wheels <span class="chevron-right">></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Car Maintenance <span class="chevron-right">></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Electronics and Gadgets <span class="chevron-right">></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Exterior Upgrades <span class="chevron-right">></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Interior Accessories <span class="chevron-right">></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Performance Parts <span class="chevron-right">></span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Products Display -->
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="/e-commerce/assets/brake-disc.png" alt="Brake Disc" class="img-fluid">
                            <div class="card-body text-center">
                                <h5 class="product-name">Brake Disc</h5>
                                <div class="product-rating mb-2">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="product-price">
                                    <span class="product-old-price">$5,000.00</span>
                                    <span class="product-new-price">$4,500.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat for other products -->
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="/e-commerce/assets/car-battery-charger.png" alt="Car Battery" class="img-fluid">
                            <div class="card-body text-center">
                                <h5 class="product-name">Car Battery</h5>
                                <div class="product-rating mb-2">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="product-price">
                                    <span class="product-old-price">$8,000.00</span>
                                    <span class="product-new-price">$7,200.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="/e-commerce/assets/power-steering-pump.png" alt="Power Steering Pump" class="img-fluid">
                            <div class="card-body text-center">
                                <h5 class="product-name">Power Steering Pump</h5>
                                <div class="product-rating mb-2">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="product-price">
                                    <span class="product-old-price">$10,000.00</span>
                                    <span class="product-new-price">$9,000.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
