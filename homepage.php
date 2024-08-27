<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/e-commerce/styles/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<header>
    <!-- Top Bar -->
    <div class="top-bar bg-dark py-2">
        <div class="container-fluid d-flex justify-content-between">
            <div class="col-lg-4">
                <a href="#" class="text-white me-3">Shipping</a>
                <a href="#" class="text-white me-3">FAQ</a>
                <a href="#" class="text-white">Track Order</a>
            </div>
            <div class="col-lg-4">
                <h6 class="free-shipping">Free Shipping Worldwide</h6>
            </div>
            <div class="col-lg-4">
                <a href="#" class="text-white me-3">Default USD pricelist <i class="bi bi-chevron-down"></i></a>
                <a href="#" class="text-white">English (US) <i class="bi bi-chevron-down"></i></a>
            </div>
        </div>
    </div>
</header>
    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <!-- Logo and Search Bar Row -->
            <div class="row w-100 align-items-center">
                <div class="col-md-3 d-flex align-items-center">
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img src="/e-commerce/assets/auto-logo.png" alt="Auto-Logo" style="max-height: 100px;">
                    </a>
                </div>
                <div class="col-md-6">
                    <form class="d-flex mx-auto search-bar">
                        <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                        <button class="btn search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-3 d-flex justify-content-end align-items-center">
                    <a href="#" class="btn btn-light"><i class="bi bi-person"></i></a>
                    <a href="#" class="btn btn-light"><i class="bi bi-cart"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Category and Navigation Links Row -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <div class="row w-100 align-items-center mt-3">
                <div class="col-md-3">
                    <button class="btn btn-orange category-btn w-100">
                        <i class="bi bi-list"></i> ALL CATEGORIES <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
                <div class="col-md-6">
                    <ul class="navbar-nav justify-content-center">
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
                    </ul>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <a href="#" class="btn btn-light call-btn">
                        <i class="bi bi-telephone-fill"></i> CALL US ON <span>(1800) 11-55-854</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
<main>
    <!-- Hero/Carousel Section -->
    <div class="container d-flex align-items-center justify-content-center gray-background">
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
            <h1>PICTURE HERE</h1>
        </div>
    </div>
    <!-- Featured Categories Section -->
    <div class="container my-5">
        <h2 class="text-center">Featured Categories</h2>
        <div class="d-flex overflow-auto">
            <!-- Category 1 -->
            <div class="me-3">
                <img src="/e-commerce/assets/temp.png" alt="Category 1" class="img-fluid">
                <h5 class="text-center">Tires and Wheels</h5>
            </div>
            <!-- next Category -->
        </div>
    </div>

    <!-- Promotional Banners Section -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="/e-commerce/assets/temp.png" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">Upgrade Your Ride</h5>
                        <a href="#" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="/e-commerce/assets/temp.png" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">Upgrade Your Car's Lighting</h5>
                        <a href="#" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="container my-5">
        <h2 class="text-center">Featured Products</h2>
        <div class="row">
            <!-- Product 1 -->
            <div class="col-md-3">
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

    <!-- Top Dealers Section -->
    <div class="container my-5">
        <h2 class="text-center">Top Dealers</h2>
        <div class="row">
            <!-- Dealer 1 -->
            <div class="col-md-3">
                <div class="card text-center">
                    <img src="/e-commerce/assets/temp.png" class="card-img-top" alt="Dealer Name">
                    <div class="card-body">
                        <h5 class="card-title">Dealer Name</h5>
                        <p class="card-text">Location: City, Country</p>
                        <a href="#" class="btn btn-primary">View Products</a>
                    </div>
                </div>
            </div>
            <!-- Next Dealer -->
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
