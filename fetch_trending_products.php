<?php
require 'web/db_connect.php';
require 'classes/Product.php';

// Initialize the Product object
$productObj = new Product($conn);

$categoryId = $_POST['category_id']; // The selected category ID

// Fetch trending products using the Product class
$trendingProducts = $productObj->getTrendingProductsByCategory($categoryId, 3); // Limiting to 3 products

// HTML output for products
if (!empty($trendingProducts)) {
    $productCount = 0;
    echo '<div class="row w-100">';

    foreach ($trendingProducts as $product) {
        echo '<div class="col-sm-12 col-md-4 col-lg-4">';
        echo '    <div class="trending-product-card">';
        echo '        <img src="' . htmlspecialchars($product['image_path']) . '" alt="' . htmlspecialchars($product['name']) . '" class="img-fluid">';
        echo '        <div class="product-info text-center py-3">';
        echo '            <h5 class="product-name">' . htmlspecialchars($product['name']) . '</h5>';
        echo '            <div class="product-rating">';
        echo '                <i class="bi bi-star-fill"></i>';
        echo '                <i class="bi bi-star-fill"></i>';
        echo '                <i class="bi bi-star-fill"></i>';
        echo '                <i class="bi bi-star-half"></i>';
        echo '                <i class="bi bi-star"></i>';
        echo '            </div>';
        echo '            <div class="product-price">';
        echo '                <span class="old-price">$' . number_format($product['old_price'], 2) . '</span>';
        echo '                <span class="new-price">$' . number_format($product['price'], 2) . '</span>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';

        $productCount++;
    }

    // Add empty columns to maintain the 3-column structure if fewer products are present
    for ($i = $productCount; $i < 3; $i++) {
        echo '<div class="col-sm-12 col-md-4 col-lg-4"></div>';
    }

    echo '</div>';
} else {
    echo '<p>No products available in this category.</p>';
}