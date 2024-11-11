<?php
// Include necessary files
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

// Ensure $product is set before use
if (!isset($product) || !is_array($product)) {
    throw new Exception("Product data not provided to overlay_buttons.php.");
}

$userId = $_SESSION['user_id'] ?? null;
$cart = new Cart($conn, $userId);
?>

<div class="overlay-buttons btn-group position-absolute top-50 start-50 translate-middle d-none d-lg-flex">
    <button 
        type="button" 
        class="btn button-overlay rounded-circle add-to-cart" 
        data-product-id="<?= htmlspecialchars($product['id'] ?? '') ?>">
        <i class="bi bi-cart"></i>
    </button>
    <button 
        type="button" 
        class="btn button-overlay rounded-circle add-to-wishlist" 
        data-product-id="<?= htmlspecialchars($product['id'] ?? '') ?>">
        <i class="bi bi-heart"></i>
    </button>
    <button 
        type="button" 
        class="btn button-overlay rounded-circle add-to-compare" 
        data-product-id="<?= htmlspecialchars($product['id'] ?? '') ?>">
        <i class="bi bi-arrow-left-right"></i>
    </button>
    <button 
        type="button" 
        class="btn button-overlay rounded-circle view-product" 
        data-product-id="<?= htmlspecialchars($product['id'] ?? '') ?>">
        <i class="bi bi-eye"></i>
    </button>
</div>

<script>
    $(document).ready(function () {
        // Add to cart button functionality
        $(document).on('click', '.add-to-cart', function () {
            const productId = $(this).data('product-id');
            const quantity = 1; // Automatically add 1 item to the cart

            // Debugging: Ensure product ID is being passed
            if (!productId) {
                alert('Product ID is missing.');
                console.error('Missing product ID in add-to-cart button.');
                return;
            }

            // Send POST request to add_to_cart.php
            $.ajax({
                url: 'add_to_cart.php',
                type: 'POST',
                data: JSON.stringify({ product_id: productId, quantity: quantity }),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Product added to cart successfully!');
                        // Optionally refresh the cart count or update UI
                    } else {
                        alert(response.message || 'Failed to add product to cart.');
                    }
                },
                error: function () {
                    alert('Error processing the request.');
                }
            });
        });

        // Add to wishlist functionality
        $(document).on('click', '.add-to-wishlist', function () {
            const productId = $(this).data('product-id');

            if (!productId) {
                alert('Product ID is missing for the wishlist.');
                return;
            }

            $.post('add_to_wishlist.php', { product_id: productId }, function (response) {
                if (response.status === 'success') {
                    alert('Product added to wishlist successfully!');
                } else {
                    alert(response.message || 'Failed to add product to wishlist.');
                }
            }, 'json').fail(function () {
                alert('Error processing the request.');
            });
        });

        // Add to compare functionality
        $(document).on('click', '.add-to-compare', function () {
            const productId = $(this).data('product-id');

            if (!productId) {
                alert('Product ID is missing for compare.');
                return;
            }

            $.post('add_to_compare.php', { product_id: productId }, function (response) {
                if (response.status === 'success') {
                    alert('Product added to compare successfully!');
                } else {
                    alert(response.message || 'Failed to add product to compare.');
                }
            }, 'json').fail(function () {
                alert('Error processing the request.');
            });
        });

        // View product functionality
        $(document).on('click', '.view-product', function () {
            const productId = $(this).data('product-id');

            if (!productId) {
                alert('Product ID is missing for viewing.');
                return;
            }

            window.location.href = `product_page.php?id=${productId}`;
        });
    });
</script>