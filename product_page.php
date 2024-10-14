<?php
require 'web/db_connect.php';
require 'Product.php';

if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$product_id = $_GET['id'];

$product = new Product($conn, $product_id);
$product_details = $product->getProductDetails();

// Fetch the product along with its manufacturer details
$product_query = "SELECT p.*, m.logo_path, m.name as manufacturer_name 
                  FROM products p 
                  LEFT JOIN manufacturers m ON p.manufacturer_id = m.id 
                  WHERE p.id = $product_id";
$product_result = mysqli_query($conn, $product_query);

if (!$product_result || mysqli_num_rows($product_result) == 0) {
    echo "Product not found.";
    exit;
}

$product = mysqli_fetch_assoc($product_result);

// Fetch product attributes
$product_attributes_query = "SELECT a.name, pa.value 
                             FROM product_attributes pa 
                             LEFT JOIN attributes a ON pa.attribute_id = a.id 
                             WHERE pa.product_id = $product_id";
$product_attributes = mysqli_query($conn, $product_attributes_query);

// Fetch product categories (Main, Second, Third)
$product_categories_query = "SELECT mc.name AS main_category, sc.name AS second_category, tc.name AS third_category
                             FROM product_categories pc
                             LEFT JOIN main_categories mc ON pc.main_category_id = mc.id
                             LEFT JOIN second_categories sc ON pc.second_category_id = sc.id
                             LEFT JOIN third_categories tc ON pc.third_category_id = tc.id
                             WHERE pc.product_id = $product_id";
$product_categories_result = mysqli_query($conn, $product_categories_query);

$next_query = "SELECT id FROM products WHERE id > $product_id ORDER BY id ASC LIMIT 1";
$next_result = mysqli_query($conn, $next_query);
$next_product = mysqli_fetch_assoc($next_result);

$prev_query = "SELECT id FROM products WHERE id < $product_id ORDER BY id DESC LIMIT 1";
$prev_result = mysqli_query($conn, $prev_query);
$prev_product = mysqli_fetch_assoc($prev_result);

$next_id = isset($next_product['id']) ? $next_product['id'] : null;
$prev_id = isset($prev_product['id']) ? $prev_product['id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product_details['name']; ?> - Car Parts E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/e-commerce/styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                <img src="<?php echo $product_details['image_path']; ?>" alt="Product Image" class="img-fluid">
            </div>

            <!-- Product Info Section -->
            <div class="col-md-12 col-lg-6">
                <div class="products-main-info">
                    <nav aria-label="breadcrumb" class="breadcrumb-tab py-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $product_details['name']; ?></li>
                            <li class="ms-auto">
                                <?php if ($prev_id): ?>
                                    <a href="product_page.php?id=<?php echo $prev_id; ?>" class="text-muted">
                                        <i class="bi bi-chevron-left"></i> prev
                                    </a>
                                <?php endif; ?>
                                <?php if ($next_id): ?>
                                    <a href="product_page.php?id=<?php echo $next_id; ?>" class="text-muted">
                                        next <i class="bi bi-chevron-right"></i>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ol>
                    </nav>
                    <div class="title-rating d-flex flex-lg-column flex-sm-column-reverse">
                        <div class="product-title">
                            <h2 class="product-title"><?php echo $product_details['name']; ?></h2>
                        </div>
                        <div class="product-rating m-0">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                    </div>
                    <p class="sku">SKU: <?php echo $product_details['sku']; ?></p>
                    <p class="definition m-0">
                    <?php echo $product_details['short_description']; ?>
                    </p>
                </div>
                <div class="col-md-12 col-lg-6 product-buttons-section d-flex flex-column justify-content-start py-2 m-0 w-100">
                    <div class="product-price">
                        <span class="ms-2 new-price" style="color: #000">$<?php echo number_format($product_details['price'], 2); ?></span>
                        <span class="text-decoration-line-through text-danger">$<?php echo number_format($product_details['old_price'], 2); ?></span>
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
                <!-- Display Manufacturer Logo -->
                <div class="brand-logo">
                    <?php if ($product['logo_path']): ?>
                        <img src="<?php echo $product['logo_path']; ?>" alt="<?php echo $product['manufacturer_name']; ?> logo" class="img-fluid">
                    <?php endif; ?>
                </div>

                <!-- Display Categories (Main, Second, Third) -->
                <div class="product-categories">
                    <p class="text-muted mb-0">
                        <strong>Categories:</strong>
                        <?php while ($category = mysqli_fetch_assoc($product_categories_result)): ?>
                            <span><?php echo $category['main_category']; ?> > <?php echo $category['second_category']; ?> > <?php echo $category['third_category']; ?></span><br>
                        <?php endwhile; ?>
                    </p>
                </div>

                <!-- Wishlist and Terms -->
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
                            <?php echo $product_details['description']; ?>
                        </p>
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

    <!-- Product Specifications Section -->
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-6 table-category mt-4">
                <h4 class="mb-4">Specifications</h4>
                <div class="col-3 table-body w-100">
                    <table class="table col-6">
                        <tbody>
                            <?php while ($attribute = mysqli_fetch_assoc($product_attributes)) : ?>
                                <?php if (!empty($attribute['value'])) : // Only display attributes with a value ?>
                                    <tr>
                                        <th><?php echo $attribute['name']; ?></th>
                                        <td><?php echo $attribute['value']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>
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

<?php
mysqli_free_result($product_attributes);
mysqli_free_result($product_categories_result);
mysqli_close($conn);
?>