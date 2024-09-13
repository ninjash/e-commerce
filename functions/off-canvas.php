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
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="category_page.php">All Products</a></li>
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
                </li>

                <!-- Simple Nav Links -->
                <li class="nav-item my-2"><a class="nav-link fw-bold" href="homepage.php">HOME</a></li>
                <li class="nav-item dropdown my-2">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        GADGETS
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Digital Screen & Audio/a></li>
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
