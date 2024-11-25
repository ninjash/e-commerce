<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Payment.php';
require_once 'classes/Order.php';
require_once 'classes/Cart.php';

// Retrieve values from session
$delivery = $_SESSION['order_summary']['delivery'] ?? 130.00;
$subtotal = $_SESSION['order_summary']['subtotal'] ?? 0.00;
$taxes = $_SESSION['order_summary']['taxes'] ?? 0.00;
$total = $subtotal + $taxes + $delivery;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentDetails = [
        'card_number' => $_POST['cardNumber'] ?? '',
        'expiry_date' => $_POST['expiryDate'] ?? '',
        'cvv' => $_POST['cvv'] ?? ''
    ];

    $userId = $_SESSION['user_id'] ?? null; // Null for guest users
    $sessionId = session_id();

    // Debugging session values
    error_log("User ID: " . ($userId ?: 'Guest'));
    error_log("Session Order Summary: " . print_r($_SESSION['order_summary'], true));
    error_log("Session Cart Items: " . print_r($_SESSION['cart_items'], true));

    $payment = new Payment($conn, $total, 'credit_card', $sessionId);

    if ($payment->processPayment($paymentDetails)) {
        $transactionId = $payment->getTransactionId();

        // Create order
        $order = new Order($conn);
        $cartItems = $_SESSION['cart_items'] ?? [];

        // Debugging cart items
        error_log("Cart Items Retrieved: " . print_r($cartItems, true));

        if (empty($cartItems)) {
            error_log("No items in the cart. Cannot proceed with order creation.");
            $error_message = "Your cart is empty. Please add items before checking out.";
        } else {
            try {
                // Begin transaction
                $conn->begin_transaction();

                // Create order
                $orderId = $order->createOrder($userId, $total, 'Credit Card', $transactionId, $cartItems);
                
                if (!$orderId) {
                    throw new Exception("Failed to create order");
                }

                // If we get here, commit the transaction
                $conn->commit();
                error_log("Order created successfully for order ID: $orderId");

                // Clear the cart
                $cart = new Cart($conn, $userId);
                $cart->clearCart();

                // Store order confirmation details in the session
                $_SESSION['order_confirmation'] = [
                    'order_id' => $orderId,
                    'total_amount' => $total,
                    'payment_method' => 'Credit Card',
                    'transaction_id' => $transactionId,
                    'order_items' => $cartItems
                ];

                // Redirect to confirmation page
                header('Location: shop_confirmation.php');
                exit;

            } catch (Exception $e) {
                $conn->rollback();
                error_log("Failed to process order: " . $e->getMessage());
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit;
            }
        }
    } else {
        $error_message = 'Payment processing failed. Please try again.';
        error_log($error_message);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts E-Commerce - Payment</title>
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
    <div class="container-fluid oe_website_sale py-2 my-3">
        <div class="row w-100">
            <div class="col-12 col-lg-4 order-2" id="o_cart_summary">
                <div class="card js_cart_summary">
                    <div class="card-body p-0 mb-3">
                        <h2 class="d-block text-center mb-0 mt-3">Order Total</h2>
                        <hr class="d-none d-xl-block">
                        <div>
                            <div id="cart_total" class="">
                                <table class="table mb-0 order-summary-table">
                                    <tbody>
                                        <tr id="empty">
                                        </tr>
                                        <tr id="order_delivery">
                                            <td class="text-center border-0 text-muted" title="Delivery will be updated after choosing a new delivery method">Delivery:</td>
                                            <td class="text-xl-center border-0 text-muted">
                                                <span class="monetary_field" style="white-space: nowrap;">$&nbsp;<span class="oe_currency_value"><?= number_format($delivery, 2); ?></span></span>
                                            </td>
                                        </tr>
                                        <tr id="order_subtotal">
                                            <td class="text-center border-0 text-muted">Subtotal:</td>
                                            <td class="text-xl-center border-0 text-muted">
                                                <span class="monetary_field" style="white-space: nowrap;">$&nbsp;<span class="oe_currency_value"><?= number_format($subtotal, 2); ?></span></span>
                                            </td>
                                        </tr>
                                        <tr id="order_taxes">
                                            <td class="text-center border-0 text-muted">Taxes:</td>
                                            <td class="text-xl-center border-0 text-muted">
                                                <span class="monetary_field" style="white-space: nowrap;">$&nbsp;<span class="oe_currency_value"><?= number_format($taxes, 2); ?></span></span>
                                            </td>
                                        </tr>
                                        <tr id="order_total">
                                            <td class="text-center border-0 text-muted">Total:</td>
                                            <td class="text-xl-center border-0 text-muted">
                                                <span class="monetary_field" style="white-space: nowrap;">$&nbsp;<span class="oe_currency_value"><?= number_format($total, 2); ?></span></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 order-1 oe_cart">
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
                        <div class="progress-step completed">
                            <div class="circle">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="step-label">Billing & Shipping</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step completed">
                            <div class="circle">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="step-label">Payment</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="circle"></div>
                            <span class="step-label">Confirmation</span>
                        </div>
                    </div>
                </div>
                <div class="oe_structure clearfix mt-3" id="oe_structure_website_sale_payment_1"></div>
                <div class="col-12 bg-white">
                    <h2 class="px-3 py-2 m-0 fs-3">Confirm Order</h2>
                    <hr class="mx-3 m-0">
                    <div class="card">
                        <div class="card-body p-xl-0">
                            <div class="toggle_summary_div_new d-block">
                                <table class="table table-bordered payment-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th></th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart_items_body">
                                        <!-- Cart items will be populated here by AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="delivery_carrier" class="bg-white pt-4 text-muted">
                    <h3 class="mb24 px-3">Choose a delivery method</h3>
                    <div class="card border-0 px-3" id="delivery_method">
                        <ul class="list-group">
                            <li class="list-group-item o_delivery_carrier_select pt-3">
                                <input type="radio" name="delivery_type" value="11" id="delivery_11" checked="checked" class="">
                                <label class="label-optional">Flat Rate Shipping</label>
                                <span class="float-end badge text-bg-secondary o_wsale_delivery_badge_price">$&nbsp;<span class="oe_currency_value">130.00</span></span>
                            </li>
                            <li class="list-group-item o_delivery_carrier_select pt-3">
                                <input type="radio" name="delivery_type" value="14" id="delivery_14" class="">
                                <label class="label-optional">Freight Economy</label>
                                <span class="float-end badge text-bg-secondary o_wsale_delivery_badge_price o_wsale_delivery_carrier_error">Weight is not available.</span>
                            </li>
                            <li class="list-group-item o_delivery_carrier_select pt-3">
                                <input type="radio" name="delivery_type" value="12" id="delivery_12" class="">
                                <label class="label-optional">Freight Priority</label>
                                <span class="float-end badge text-bg-secondary o_wsale_delivery_badge_price o_wsale_delivery_carrier_error">Weight is not available.</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="payment_method" class="mt-0 py-3 bg-white px-3" style="">
                    <h3 class="mb24">Pay with</h3>
                    <form id="o_payment_form" method="POST">
                        <div class="card">
                            <div name="o_payment_option_card" class="card-body o_payment_option_card" style="padding:16px  0px !important">
                                <label>
                                    <input name="o_payment_radio" type="radio" data-payment-option-type="provider" checked="True" class="d-none" data-payment-option-id="4" data-provider="authorize">
                                    <span class="payment_option_name">
                                        <b>Credit Card (powered by Authorize)</b>
                                    </span>
                                </label>      
                                <ul class="payment_icon_list float-end list-inline" data-max-icons="3">
                                    <li class="list-inline-item">
                                        <span data-bs-toggle="tooltip" title="" data-oe-type="image" data-oe-expression="icon.image_payment_form" data-bs-original-title="VISA" aria-label="VISA"><img src=""></span>
                                    </li>
                                    <li class="list-inline-item">
                                        <span data-bs-toggle="tooltip" title="" data-oe-type="image" data-oe-expression="icon.image_payment_form" data-bs-original-title="MasterCard" aria-label="MasterCard"><img src=""></span>
                                    </li>
                                    <li class="list-inline-item">
                                        <span data-bs-toggle="tooltip" title="" data-oe-type="image" data-oe-expression="icon.image_payment_form" data-bs-original-title="American Express" aria-label="American Express"><img src=""></span>
                                    </li>
                                    <li class="list-inline-item">
                                        <span data-bs-toggle="tooltip" title="" data-oe-type="image" data-oe-expression="icon.image_payment_form" data-bs-original-title="Diners Club International" aria-label="Diners Club International"><img src=""></span>
                                    </li>
                                </ul>
                            </div>
                            <div name="o_payment_inline_form" class="card-footer px-3" id="o_payment_provider_inline_form_4">
                                <div class="clearfix">
                                    <div class="o_authorize_form" id="o_authorize_form_4">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="cardNumber">Card Number</label>
                                            <input type="text" name="cardNumber" required="" maxlength="19" class="form-control" id="cardNumber">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-8 mb-3">
                                                <label for="expiryDate">Expiration</label>
                                                <div class="input-group">
                                                    <input type="text" name="expiryDate" placeholder="MM/YY" required="" class="form-control" id="expiryDate" maxlength="5">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <label for="cvv">CVV Code</label>
                                                <input type="text" name="cvv" required="" maxlength="4" class="form-control" id="cvv">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div name="o_checkbox_container" class="form-check mt-2 o_accept_tc_button"></div>
                        <div class="float-start mt-2">
                            <a role="button" href="shop_cart.php" class="btn btn-secondary">
                                <i class="fa fa-chevron-left"></i> Return to Cart
                            </a>
                        </div>
                        <div class="float-end mt-2">
                            <button name="o_payment_submit_button" type="submit" class="btn btn-primary" data-icon-class="fa-chevron-right">
                                Pay Now <i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </form>
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
                    cartHtml = '<tr><td colspan="4" class="text-center">Your cart is empty.</td></tr>';
                } else {
                    cartItems.forEach(item => {
                        const price = parseFloat(item.price).toFixed(2);
                        cartHtml += `
                            <tr>
                                <td class="td-img text-center">
                                    <span><img src="${item.image_url}" class="img rounded o_image_64_max" alt="${item.name}" loading="lazy" style=""></span>
                                </td>
                                <td class="td-product_name">
                                    <div>
                                        <strong>${item.name}</strong>
                                    </div>
                                </td>
                                <td class="td-qty">
                                    <div>${item.quantity}</div>
                                </td>
                                <td class="td-price">
                                    <div>${price}</div>
                                </td>
                            </tr>`;
                    });
                }

                $('#cart_items_body').html(cartHtml);

                // Update order summary
                const deliveryFee = parseFloat(response.delivery) || 130.00;
                const subtotal = parseFloat(response.subtotal) || 0.00;
                const taxes = parseFloat(response.taxes) || 0.00;
                const total = (subtotal + taxes + deliveryFee).toFixed(2);

                $('#order_delivery .oe_currency_value').text(deliveryFee.toFixed(2));
                $('#order_subtotal .oe_currency_value').text(subtotal.toFixed(2));
                $('#order_taxes .oe_currency_value').text(taxes.toFixed(2));
                $('#order_total .oe_currency_value').text(total);
            } else {
                $('#cart_items_body').html('<tr><td colspan="4" class="text-center">Failed to load cart items.</td></tr>');
            }
        }).fail(function () {
            $('#cart_items_body').html('<tr><td colspan="4" class="text-center">Error fetching cart items.</td></tr>');
        });
    }

    // Load cart items on page load
    loadCartItems();

    const expiryDateInput = document.getElementById('expiryDate');
    expiryDateInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
        if (value.length >= 3) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
    });

    $('#o_payment_form').on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: 'process_payment.php',
            type: 'POST',
            data: formData,
            dataType: 'json', // Ensure the response is parsed as JSON
            success: function (response) {
                console.log('AJAX response:', response); // Log the response for debugging
                if (response.status === 'success') {
                    console.log('Redirecting to shop_confirmation.php');
                    window.location.href = 'shop_confirmation.php';
                } else {
                    console.error('Payment processing failed:', response.message);
                    alert('Payment processing failed: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Error processing payment.');
            }
        });
    });
});
</script>

</body>
</html>