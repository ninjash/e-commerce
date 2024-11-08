<?php
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

ini_set('display_errors', 1); // Enable during debugging
error_reporting(E_ALL);

$userId = $_SESSION['user_id'] ?? null;
$isGuest = $userId === null;

// Initialize the Cart class
if (!isset($conn)) {
    die("Database connection is not set.");
}
$cart = new Cart($conn, $userId);

// Handle POST actions (e.g., remove item from cart)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'remove') {
        $productId = intval($_POST['product_id'] ?? 0);

        error_log("POST Request - Action: remove, Product ID: $productId");

        if ($productId > 0) {
            $isRemoved = $cart->removeFromCart($productId);

            if ($isRemoved) {
                echo json_encode(['status' => 'success', 'message' => 'Item removed from cart.']);
            } else {
                error_log("Failed to remove product ID $productId from cart.");
                echo json_encode(['status' => 'error', 'message' => 'Failed to remove item from cart.']);
            }
        } else {
            error_log("Invalid product ID received: $productId");
            echo json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
        }
        exit;
    }

    // Example: Handle other actions like merge_cart
    if (!$isGuest && isset($_POST['merge_cart'])) {
        $cart->mergeCart();
        echo json_encode(['status' => 'success', 'message' => 'Cart merged successfully.']);
        exit;
    }
}

// Fetch cart items and calculate totals
$cartItems = $cart->getCartItems();
$subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
$taxes = $subtotal * 0.00; // Assuming no tax
$total = $subtotal + $taxes;
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
                    <a href="/checkout" class="btn btn-process-checkout">
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
                                <span id="subtotal">$<?= number_format($subtotal, 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Taxes:</span>
                                <span>$<?= number_format($taxes, 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong id="total">$<?= number_format($total, 2); ?></strong>
                            </li>
                        </ul>
                        <a href="/checkout" class="btn btn-success mt-4 w-100">Proceed to Checkout</a>
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
                                        <div class="css_quantity input-group mx-auto justify-content-center">
                                            <button class="btn btn-outline-secondary js_decrease_quantity" data-product-id="${item.product_id}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="text" class="js_quantity form-control text-center quantity" value="${item.quantity}" style="width: 50px;" readonly>
                                            <button class="btn btn-outline-secondary js_increase_quantity" data-product-id="${item.product_id}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center td-price">$${parseFloat(item.price).toFixed(2)}</td>
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

        // Load cart items on page load
        loadCartItems();

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

        // Optionally, handle quantity increase/decrease and update the summary dynamically
        $(document).on('click', '.js_decrease_quantity, .js_increase_quantity', function () {
            updateOrderSummary(); // Update totals whenever quantities are changed
        });
    });
</script>

</body>
</html>