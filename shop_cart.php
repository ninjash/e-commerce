<?php
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$userId = $_SESSION['user_id'] ?? null;
$isGuest = $userId === null;

// Initialize the Cart class
if (!isset($conn)) {
    die("Database connection is not set.");
}
$cart = new Cart($conn, $userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Log the request method and raw input
        error_log("Request method: " . $_SERVER['REQUEST_METHOD']);
        $input = file_get_contents('php://input');
        error_log("Raw input: $input");

        // Decode JSON input
        $data = json_decode($input, true);
        if (!$data) {
            throw new Exception('Invalid JSON input: ' . json_last_error_msg());
        }
        error_log("Decoded input: " . print_r($data, true));

        // Extract and validate parameters
        $productId = intval($data['product_id'] ?? 0);
        $action = $data['action'] ?? '';
        if ($productId <= 0 || !in_array($action, ['increase', 'decrease', 'update'])) {
            throw new Exception("Invalid parameters: Product ID: $productId, Action: $action");
        }

        // Calculate quantity change based on action
        $quantityChange = match ($action) {
            'increase' => 1,
            'decrease' => -1,
            'update' => intval($data['quantity'] ?? 0) - $cart->getProductQuantity($productId),
            default => throw new Exception('Invalid action type'),
        };

        // Perform the action
        if (!$cart->updateQuantity($productId, $quantityChange)) {
            throw new Exception('Failed to update quantity in database.');
        }

        // Prepare response data
        $cartItems = $cart->getCartItems();
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
        $taxes = $subtotal * 0.00; // Assuming no tax
        $total = $subtotal + $taxes;

        $response = [
            'status' => 'success',
            'message' => 'Cart updated successfully!',
            'cartItems' => array_map(function ($item) {
                return [
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ];
            }, $cartItems),
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'total' => $total,
        ];

        // Log and send response
        error_log("Response: " . print_r($response, true));
        echo json_encode($response);

    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

// If not a POST request, fetch cart items and calculate totals
function fetchCartItemsAndCalculateTotals($cart) {
    $cartItems = $cart->getCartItems();
    $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
    $taxes = $subtotal * 0.00; // Assuming no tax
    $total = $subtotal + $taxes;

    // Store the order summary in the session
    $_SESSION['order_summary'] = [
        'subtotal' => $subtotal,
        'taxes' => $taxes,
        'total' => $total,
    ];

    // Store the cart items in the session for use on subsequent pages
    $_SESSION['cart_items'] = $cartItems;

    // Debug log to ensure cart items are stored correctly
    error_log('Cart items stored in session: ' . print_r($_SESSION['cart_items'], true));
}

fetchCartItemsAndCalculateTotals($cart);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/e-commerce/styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <?php include 'global/header.php'; ?>
</header>

<main>
    <div class="container-fluid oe_website_sale py-4 mb-3">
        <div class="row w-100">
            <div class="col-12 col-xl-8 oe_cart">
                <!-- Progress Indicator -->
                <div class="container my-4">
                    <div class="progress-bar-wrapper d-flex justify-content-between align-items-center">
                        <div class="progress-step completed">
                            <div class="circle">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="step-label">Review Order</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="circle"></div>
                            <span class="step-label">Billing & Shipping</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="circle"></div>
                            <span class="step-label">Payment</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="circle"></div>
                            <span class="step-label">Confirmation</span>
                        </div>
                    </div>
                </div>
                
                <h2>Shopping Cart</h2>
                <table class="mb-4 table table-striped table-sm js_cart_lines" id="cart_products">
                    <thead>
                        <tr>
                            <th class="td-img">Product</th>
                            <th></th>
                            <th class="text-center td-qty">Quantity</th>
                            <th class="text-center td-price">Price</th>
                            <th class="text-center td-action"></th>
                        </tr>
                    </thead>
                    <tbody id="cartItemsBody">
                        <tr><td colspan="5" class="text-center">Loading your cart...</td></tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between mt-3">
                    <a href="/shop" class="btn btn-continue-shopping">
                        <i class="fa fa-chevron-left"></i> Continue Shopping
                    </a>
                    <a href="shop_address.php" class="btn btn-process-checkout">
                        Process Checkout <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Order Total</h3>
                        <hr>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span id="subtotal">$<?= number_format($_SESSION['order_summary']['subtotal'], 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Taxes:</span>
                                <span>$<?= number_format($_SESSION['order_summary']['taxes'], 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong id="total">$<?= number_format($_SESSION['order_summary']['total'], 2); ?></strong>
                            </li>
                        </ul>
                        <a href="shop_address.php" class="btn btn-success mt-4 w-100">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php include 'global/footer.php'; ?>
</footer>

<div class="text-center text-white footer-secondary py-2">
    <div class="container">
        <p class="mb-0">© 2024 Car Parts E-Commerce. All Rights Reserved. English | Francais</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        function loadCartItems() {
            $.getJSON('fetch_cart_items.php', function (response) {
                if (response.status === 'success') {
                    const cartItems = response.cartItems;
                    let cartHtml = '';

                    if (cartItems.length === 0) {
                        cartHtml = '<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>';
                    } else {
                        cartItems.forEach(item => {
                            cartHtml += `
                                <tr data-product-id="${item.product_id}">
                                    <td align="center" class="td-img d-block">
                                        <img src="${item.image_url}" class="img rounded o_image_64_max" alt="${item.name}" style="max-width: 80px;">
                                    </td>
                                    <td class="td-product_name">
                                        <a href="product_page.php?id=${item.product_id}">
                                            <strong>${item.name}</strong>
                                        </a>
                                        <br>
                                        <a href="#" class="js_delete_product text-light-blue fw-bold" data-product-id="${item.product_id}">
                                            <small><i class="fa fa-trash-o"></i> Remove</small>
                                        </a>
                                    </td>
                                    <td class="text-center td-qty">
                                        <div class="input-group mx-auto justify-content-center align-items-center" style="width: auto; background-color: #122a3c; border-radius: 4px;">
                                            <button class="btn btn-sm btn-light js_decrease_quantity" data-product-id="${item.product_id}" style="border: none; color: white; font-weight: bold;">
                                                -
                                            </button>
                                            <input type="text" class="js_quantity form-control text-center quantity" value="${item.quantity}" 
                                                style="width: 25px; border: none; background-color: #122a3c; color: white; font-weight: bold;" readonly>
                                            <button class="btn btn-sm btn-light js_increase_quantity" data-product-id="${item.product_id}" style="border: none; color: white; font-weight: bold;">
                                                +
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center td-price">$${(item.price * item.quantity).toFixed(2)}</td>
                                    <td class="td-action">
                                        <a href="#" class="js_delete_product no-decoration" data-product-id="${item.product_id}">
                                            <small><i class="fa fa-trash-o"></i></small>
                                        </a>
                                    </td>
                                </tr>`;
                        });
                    }

                    $('#cartItemsBody').html(cartHtml);

                    // Update the order summary after cart items are loaded
                    updateOrderSummary();
                } else {
                    $('#cartItemsBody').html('<tr><td colspan="5" class="text-center">Failed to load cart items.</td></tr>');
                }
            }).fail(function () {
                $('#cartItemsBody').html('<tr><td colspan="5" class="text-center">Error fetching cart items.</td></tr>');
            });
        }

        function updateOrderSummary() {
            let subtotal = 0;

            // Calculate subtotal from cart items
            $('#cartItemsBody tr').each(function () {
                const quantity = parseInt($(this).find('.js_quantity').val(), 10);
                const price = parseFloat($(this).find('.td-price').text().replace('$', ''));

                if (!isNaN(quantity) && !isNaN(price)) {
                    subtotal += quantity * price;
                }
            });

            // Calculate taxes and total
            const taxes = subtotal * 0.00; // Adjust tax rate as necessary
            const total = subtotal + taxes;

            // Update the order summary
            $('#subtotal').text(`$${subtotal.toFixed(2)}`);
            $('#taxes').text(`$${taxes.toFixed(2)}`);
            $('#total').text(`$${total.toFixed(2)}`);
        }

        function updateCartQuantity(productId, actionType) {
            $.ajax({
                url: 'shop_cart.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    product_id: productId,
                    action: actionType
                }),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        console.log('Cart updated:', response);
                        loadCartItems(); // Reload cart items to reflect changes
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        // Event delegation for quantity buttons
        $(document).on('click', '.js_increase_quantity, .js_decrease_quantity', function(e) {
            e.preventDefault();
            
            // Get the closest row to find the product ID
            const row = $(this).closest('tr');
            const productId = row.data('product-id');
            const actionType = $(this).hasClass('js_increase_quantity') ? 'increase' : 'decrease';
            
            // Disable both buttons in this row temporarily
            row.find('.js_increase_quantity, .js_decrease_quantity').prop('disabled', true);
            
            console.log('Button clicked:', {
                productId: productId,
                actionType: actionType,
                rowFound: row.length > 0,
                buttonClass: $(this).attr('class')
            });

            if (!productId) {
                console.error('No product ID found for row:', row);
                return;
            }

            updateCartQuantity(productId, actionType);
            
            // Re-enable the buttons after a short delay
            setTimeout(() => {
                row.find('.js_increase_quantity, .js_decrease_quantity').prop('disabled', false);
            }, 500);
        });

        // Optional: Add input change handler for direct quantity updates
        $(document).on('change', '.js_quantity', function() {
            const row = $(this).closest('tr');
            const productId = row.data('product-id');
            updateCartQuantity(productId, 'update');
        });

        // Event listener for item removal
        $(document).on('click', '.js_delete_product', function (e) {
            e.preventDefault();
            const productId = $(this).data('product-id');

            if (confirm('Are you sure you want to remove this item from your cart?')) {
                $.post('remove_cart_items.php', { product_id: productId }, function (response) {
                    if (response.status === 'success') {
                        loadCartItems(); // Reload cart items
                        alert(response.message);
                    } else {
                        alert(response.message || 'Failed to remove item from cart.');
                    }
                }, 'json').fail(function () {
                    alert('Error processing the request.');
                });
            }
        });
    
        function initializeQuantityButtons() {
            $('.js_quantity').each(function() {
                const quantity = parseInt($(this).val());
                const row = $(this).closest('tr');
                row.find('.js_decrease_quantity').prop('disabled', quantity <= 1);
            });
        }

        $(document).ajaxError(function(event, jqxhr, settings, error) {
            console.error('Ajax Error:', {
                event: event,
                jqxhr: jqxhr,
                settings: settings,
                error: error
            });
        });

        // Load cart items on page load
        loadCartItems();
        initializeQuantityButtons();

        // Handle "Process Checkout" button click
        $(document).on('click', '.btn-process-checkout', function (e) {
            e.preventDefault();

            // Get the order summary data
            const orderSummary = {
                subtotal: parseFloat($('#subtotal').text().replace('$', '')) || 0,
                taxes: parseFloat($('#taxes').text().replace('$', '')) || 0,
                total: parseFloat($('#total').text().replace('$', '')) || 0,
            };

            // Send order summary to the server
            $.ajax({
                url: 'save_order_summary.php', // Backend script to save order summary
                type: 'POST',
                data: orderSummary,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Redirect to shop_address.php if data is saved successfully
                        window.location.href = 'shop_address.php';
                    } else {
                        alert(response.message || 'Failed to save order summary. Please try again.');
                    }
                },
                error: function () {
                    alert('An error occurred while processing your request.');
                },
            });
        });
    });
</script>

</body>
</html>