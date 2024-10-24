<?php
require 'web/db_connect.php';

$category_id = $_POST['category_id']; // The selected category ID

// Query to fetch products under the selected category (limiting to 3 per row)
$product_query = "
    SELECT p.id, p.name, p.price, p.old_price, pi.image_path
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id
    JOIN product_categories pc ON pc.product_id = p.id
    WHERE pc.category_id = $category_id
    LIMIT 3
";

$product_result = mysqli_query($conn, $product_query);

// HTML output for products
if (mysqli_num_rows($product_result) > 0) {
    $product_count = 0;
    echo '<div class="row w-100">';
    
    while ($product = mysqli_fetch_assoc($product_result)) {
        echo '<div class="col-sm-12 col-md-4 col-lg-4">';
        echo '    <div class="trending-product-card">';
        echo '        <img src="'.htmlspecialchars($product['image_path']).'" alt="'.htmlspecialchars($product['name']).'" class="img-fluid">';
        echo '        <div class="product-info text-center py-3">';
        echo '            <h5 class="product-name">'.htmlspecialchars($product['name']).'</h5>';
        echo '            <div class="product-rating">';
        echo '                <i class="bi bi-star-fill"></i>';
        echo '                <i class="bi bi-star-fill"></i>';
        echo '                <i class="bi bi-star-fill"></i>';
        echo '                <i class="bi bi-star-half"></i>';
        echo '                <i class="bi bi-star"></i>';
        echo '            </div>';
        echo '            <div class="product-price">';
        echo '                <span class="old-price">$'.number_format($product['old_price'], 2).'</span>';
        echo '                <span class="new-price">$'.number_format($product['price'], 2).'</span>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
        
        $product_count++;
    }

    // Add empty columns to maintain the 3-column structure if fewer products are present
    for ($i = $product_count; $i < 3; $i++) {
        echo '<div class="col-sm-12 col-md-4 col-lg-4"></div>';
    }

    echo '</div>';
} else {
    echo '<p>No products available in this category.</p>';
}
?>