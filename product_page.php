<?php
require_once 'web/db_connect.php';
require_once 'classes/Product.php';
require_once 'classes/ProductAttribute.php';
require_once 'classes/Manufacturer.php';

if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

// Create product object
$product_id = (int)$_GET['id'];
$product = new Product($conn, $product_id);

// Get product details and categories
$product_details = $product->getProductDetailsById($product_id);
$product_categories = $product->getProductCategoriesById($product_id);

// Create Attribute and Manufacturer objects
$productAttribute = new ProductAttribute($conn);
$product_attributes = $productAttribute->getProductAttributesById($product_id);

$manufacturer = new Manufacturer($conn, $product_details['manufacturer_id']);
$manufacturer_details = [
    'name' => $manufacturer->getName(),
    'logo_path' => $manufacturer->getLogoPath()
];

// Get next and previous product IDs
$next_id = $product->getNextProductId();
$prev_id = $product->getPreviousProductId();

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
                            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                            <li class="breadcrumb-item-separator"> \ </li>
                            <?php if (!empty($product_categories) && is_array($product_categories)): ?>
                                <?php foreach ($product_categories as $category): ?>
                                    <?php if (!empty($category['main_category'])): ?>
                                        <li class="breadcrumb-item">
                                            <a href="category_page.php?category_id=<?= htmlspecialchars($category['main_category_id']) ?>">
                                                <?= htmlspecialchars($category['main_category']) ?>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item-separator"> \ </li>
                                    <?php endif; ?>
                                    <?php if (!empty($category['second_category'])): ?>
                                        <li class="breadcrumb-item">
                                            <a href="category_page.php?category_id=<?= htmlspecialchars($category['second_category_id']) ?>">
                                                <?= htmlspecialchars($category['second_category']) ?>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item-separator"> \ </li>
                                    <?php endif; ?>
                                    <?php if (!empty($category['third_category'])): ?>
                                        <li class="breadcrumb-item">
                                            <a href="category_page.php?category_id=<?= htmlspecialchars($category['third_category_id']) ?>">
                                                <?= htmlspecialchars($category['third_category']) ?>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item-separator"> \ </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product_details['name']); ?></li>
                            <li class="ms-auto">
                                <?php if ($prev_id): ?>
                                    <a href="product_page.php?id=<?php echo htmlspecialchars($prev_id); ?>" class="text-muted">
                                        <i class="bi bi-chevron-left"></i> prev
                                    </a>
                                <?php endif; ?>
                                <?php if ($next_id): ?>
                                    <a href="product_page.php?id=<?php echo htmlspecialchars($next_id); ?>" class="text-muted">
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
                <!-- Display Manufacturer Logo and Name -->
                <div class="brand-logo">
                    <?php if (!empty($manufacturer_details['logo_path'])): ?>
                        <img src="<?php echo htmlspecialchars($manufacturer_details['logo_path']); ?>" alt="<?php echo htmlspecialchars($manufacturer_details['name']); ?> logo" class="img-fluid">
                    <?php endif; ?>
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
                            <?php foreach ($product_attributes as $attribute): ?>
                                <?php if (!empty($attribute['value'])) : ?>
                                    <tr>
                                        <th><?php echo $attribute['name']; ?></th>
                                        <td><?php echo $attribute['value']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
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