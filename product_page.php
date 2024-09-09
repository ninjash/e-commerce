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
    <div class="container-fluid my-5">
        <div class="row w-100">
            <!-- Product Image Section -->
                <div class="col-md-12 col-lg-6 d-flex justify-content-center align-items-center product-image-container">
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
                    <div class="title-rating d-flex flex-lg-column flex-sm-column-reverse">
                        <div class="product-title">
                            <h2 class="product-title">Aluminium Intercooler</h2>
                        </div>
                        <div class="product-rating m-0">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
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
                        <button class="btn btn-orange-cart ms-3"><i class="bi bi-cart"></i> Add to Cart</button>
                    </div>
                    <!-- Add to Wishlist Button -->
                    <a href="#" class="text-muted py-4"><i class="bi bi-heart"></i><span> Add to wishlist</span></a>
                </div>
                 <!-- Wishlist and Terms -->
                <div class="brand-logo">
                    <img src="/e-commerce/assets/brand (5).png" alt="brand logo">
                </div>
                <div class="wishlist-terms d-flex flex-lg-row flex-sm-column justify-content-lg-between justify-content-start align-items-lg-center">
                    <div class="terms">
                        <p class="text-title mb-0"><u>Terms and Conditions</u></p>
                        <p class="text-muted mb-0">30-day money-back guarantee</p>
                        <p class="text-muted">Shipping: 2-3 Business Days</p>
                    </div>
                    <!-- Share Buttons -->
                    <div class="share-section d-flex align-items-center mt-3">
                        <span class="me-2">Share:</span>
                        <a href="#" class="me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-pinterest"></i></a>
                        <a href="#"><i class="bi bi-envelope-fill"></i></a>
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
                <div class="tab-content pt-4" id="productTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <h4 class="tab-title d-flex text-center mb-4">Product Details</h4>
                        <p class="tab-description d-flex text-center px-5 mx-auto">
                            Lightweight: Aluminum is a lightweight material, reducing the overall weight of your vehicle and improving fuel efficiency.<br>
                            Efficient Heat Dissipation: Aluminum is an excellent conductor of heat, allowing the intercooler to efficiently cool the compressed air and prevent heat soak.<br>
                            Durability: Aluminum is a strong and durable material, ensuring long-lasting performance.<br>
                            Corrosion Resistance: Aluminum is naturally resistant to corrosion, making it ideal for outdoor use and harsh environments.
                        </p>
                        <div class="read-more text-center mt-4">
                            <a href="#" class="btn btn-outline-dark px-5 py-2">Read More</a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <p class="product-reviews text-center">
                            No reviews yet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- History Section -->
    <div class="container-fluid history-section py-5">
        <div class="row w-100">
            <!-- Left Column (Title and Story Button) -->
            <div class="col-sm-12 col-md-12 col-lg-6 d-flex flex-column justify-content-center px-md-0 px-lg-5">
                <div class="title-history pt-4">
                    <h1>Trusted and Professional business consultant to fulfill your dreams.</h1>
                </div>
                <div class="our-story d-flex align-items-center m-0">
                    <a href="#" class="story-link">
                        <span class="story-text">Our story</span>
                        <i class="bi bi-play-circle-fill ms-2 story-icon"></i>
                    </a>
                </div>
            </div>
            <!-- Right Column (Description) -->
            <div class="col-sm-12 col-md-12 col-lg-6 px-md-0 px-lg-5 py-4">
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
            <div class="col-6 table-category mt-4">
                <h4 class="mb-4">Specifications</h4>
                <div class="col-3 table-body w-100">
                    <table class="table col-6">
                        <tbody>
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
                        </tbody>
                    </table>
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