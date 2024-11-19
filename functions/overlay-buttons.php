<?php
// Include necessary files
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

// Check if $product is set and valid
if (!isset($product) || !is_array($product) || empty($product)) {
    // Gracefully handle the missing product data
    error_log("Product data not provided to overlay_buttons.php.");
    return; // Exit the script without rendering anything
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
        class="btn button-overlay rounded-circle add-to-wishlist">
        <i class="bi bi-heart"></i>
    </button>
    <button 
        type="button" 
        class="btn button-overlay rounded-circle add-to-compare">
        <i class="bi bi-arrow-left-right"></i>
    </button>
    <button 
        type="button" 
        class="btn button-overlay rounded-circle view-product">
        <i class="bi bi-eye"></i>
    </button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Prevent multiple event bindings
    $(document).off('click', '.add-to-cart').on('click', '.add-to-cart', function (e) {
        e.preventDefault();
        const $button = $(this);
        const productId = $button.data('product-id');
        const quantity = 1;

        // Disable button while processing
        $button.prop('disabled', true);

        console.log('Adding product to cart:', productId);

        if (!productId) {
            console.error('Product ID missing');
            alert('Error: Product ID is missing');
            $button.prop('disabled', false);
            return;
        }

        // AJAX request
        $.ajax({
            url: 'add_to_cart.php',
            type: 'POST',
            data: JSON.stringify({ 
                product_id: productId, 
                quantity: quantity 
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                
                if (response && response.status === 'success') {
                    // Update cart count if available
                    if (typeof response.cartCount !== 'undefined') {
                        const $cartCount = $('#cartItemCount');
                        $cartCount.text(response.cartCount);
                        
                        // Show count if hidden
                        if (response.cartCount > 0) {
                            $cartCount.show();
                        }
                    }

                    // Show success message
                    alert('Product added to cart successfully');
                } else {
                    // Handle error response
                    const errorMsg = response?.message || 'Failed to add product to cart';
                    console.error('Error:', errorMsg);
                    alert(errorMsg);
                }
            },
            error: function(xhr, status, error) {
                // Log detailed error info
                console.error('AJAX Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
                
                // Show user-friendly error
                alert('Unable to add product to cart. Please try again.');
            },
            complete: function() {
                // Re-enable button
                $button.prop('disabled', false);
            }
        });
    });

    // Initialize hover effects
    function initializeHoverEffects() {
        $('.overlay-container').hover(
            function() {
                $(this).find('.overlay-buttons').css({
                    opacity: 1,
                    visibility: 'visible'
                });
            },
            function() {
                $(this).find('.overlay-buttons').css({
                    opacity: 0,
                    visibility: 'hidden'
                });
            }
        );
    }

    // Initial hover setup
    initializeHoverEffects();

    // Reinitialize on dynamic content
    $(document).ajaxComplete(function() {
        initializeHoverEffects();
    });
});
</script>