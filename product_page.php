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
    <div class="container-fluid my-5">
        <div class="row w-100">
            <!-- Product Image Section -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="/e-commerce/assets/aluminum-intercooler.png" alt="Product Image" class="img-fluid">
            </div>
            
            <!-- Product Info Section -->
            <div class="col-md-12 col-lg-6">
                <div class="products-main-info">
                    <nav aria-label="breadcrumb" class="breadcrumb-tab py-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Aluminium Intercooler</li>
                            <li class="ms-auto">
                                <a href="#" class="text-muted"><i class="bi bi-chevron-left"></i> prev</a>
                                <a href="#" class="text-muted">next <i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ol>
                    </nav>
                    <h2 class="product-title">Aluminium Intercooler</h2>
                    <div class="product-rating m-0">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <p class="sku">SKU: SCT0017</p>
                    <p class="definition m-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                </div>  
                <div class="col-md-12 col-lg-6 product-buttons-section d-flex flex-column justify-content-start py-2 m-0 w-100">
                    <div class="product-price">
                        <span class="ms-2 new-price" style="color: #000">$1,350.00</span>
                        <span class="text-decoration-line-through text-danger">$1,500.00</span>
                    </div>
                    <!-- Quantity and Add to Cart Button -->
                    <div class="d-flex align-items-center m-0">
                        <!-- Quantity Selector -->
                        <div class="quantity-wrapper">
                            <button class="quantity-btn minus">-</button>
                            <input type="text" class="quantity-input" value="1" aria-label="Quantity" readonly>
                            <button class="quantity-btn plus">+</button>
                        </div>
                        <!-- Add to Cart Button -->
                        <button class="btn btn-orange ms-3"><i class="bi bi-cart"></i> Add to Cart</button>
                    </div>
                    <!-- Add to Wishlist Button -->
                    <a href="#" class="text-muted py-4"><i class="bi bi-heart"></i><span> Add to wishlist</span></a>
                </div>
                 <!-- Wishlist and Terms -->
                <div class="brand-logo">
                    <img src="/e-commerce/assets/brand (5).png" alt="brand logo">
                </div>
                <div class="wishlist-terms d-flex justify-content-between align-items-center">
                    <div class="terms">
                        <p class="text-title mb-0"><u>Terms and Conditions</u></p>
                        <p class="text-muted mb-0">30-day money-back guarantee</p>
                        <p class="text-muted">Shipping: 2-3 Business Days</p>
                    </div>
                    <!-- Share Buttons -->
                    <div class="d-flex align-items-center mt-3">
                        <span class="me-2">Share:</span>
                        <a href="#" class="me-3"><i class="bi bi-facebook text-primary"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-twitter text-info"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-pinterest text-danger"></i></a>
                        <a href="#"><i class="bi bi-envelope text-secondary"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabs Section -->
    <div class="container-fluid py-3">
        <div class="row w-100">
            <div class="col-12">
                <ul class="nav nav-underline" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                    </li>
                </ul>
                <div class="tab-content d-flex justify-content-center align-items-center pt-4" id="productTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <h4 class="d-flex justify-content-center align-items-center mb-4">Product Details</h4>
                        <ul>
                            <li>
                            <span>Lightweight: </span>Aluminum is a lightweight material, reducing the overall weight of your vehicle and improving fuel efficiency.
                            </li>
                            <li>
                            <span>Efficient Heat Dissipation: </span>Aluminum is an excellent conductor of heat, allowing the intercooler to efficiently cool the compressed air and prevent heat soak.
                            </li>
                            <li>
                            <span>Durability: </span>Aluminum is a strong and durable material, ensuring long-lasting performance.
                            </li>
                            <li>
                            <span>Corrosion Resistance: </span>Aluminum is naturally resistant to corrosion, making it ideal for outdoor use and harsh environments.
                            </li>
                        </ul>
                        <div class="read-more d-flex justify-content-center align-items-center">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <p class="product-reviews">
                            No reviews yet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- History Section -->
    <div class="container-fluid py-3 history-section">
        <div class="row w-100">
            <!-- Left Column (Title and Story Button) -->
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <div class="title-history">
                    <h1>Trusted and Professional business consultant to fulfill your dreams.</h1>
                </div>
                <div class="our-story d-flex align-items-center mt-3">
                    <a href="#" class="story-link">
                        <span class="story-text">Our story</span>
                        <i class="bi bi-play-circle ms-2 story-icon"></i>
                    </a>
                </div>
            </div>
            <!-- Right Column (Description) -->
            <div class="col-md-6">
                <p class="history-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, 
                    consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <p class="history-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.
                </p>
                <a href="#" class="read-more">Read more</a>
            </div>
        </div>
    </div>

        
    <!-- Product Details and Specifications Section -->
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-6 mt-4">
                <h4 class="mb-4">Specifications</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>SUSPENSION LOCATION</th>
                        <td>Front</td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td>2kg</td>
                    </tr>
                    <tr>
                        <th>Length</th>
                        <td>2 Feet</td>
                    </tr>
                </table>
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