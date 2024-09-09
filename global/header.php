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
                <div class="dropdown d-flex" style="width: 100%; height: 100%;">    
                    <button class="btn btn-orange category-btn d-flex justify-content-start align-items-center" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list"></i> 
                        <span>ALL CATEGORIES</span>
                        <span class="ms-auto d-flex align-items-center">
                            <i class="bi bi-chevron-down d-flex justify-content-end align-items-end"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">All Products</a></li>
                        <li><a class="dropdown-item" href="#">Automobile</a></li>
                        <li><a class="dropdown-item" href="#">Automotive Parts</a></li>
                        <li><a class="dropdown-item" href="#">Tires and Wheels</a></li>
                        <li><a class="dropdown-item" href="#">Car Maintenance</a></li>
                        <li><a class="dropdown-item" href="#">Electronics and Gadgets</a></li>
                        <li><a class="dropdown-item" href="#">Exterior Upgrades</a></li>
                        <li><a class="dropdown-item" href="#">Interior Accessories</a></li>
                        <li><a class="dropdown-item" href="#">Performance Parts</a></li>
                        <li><a class="dropdown-item" href="#">Safety and Security</a></li>
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