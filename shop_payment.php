<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

// Validate session data
if (!isset($_SESSION['order_summary']) || !isset($_SESSION['cart_items'])) {
    $_SESSION['error_message'] = 'Your cart is empty or order summary is missing.';
    header('Location: shop_cart.php');
    exit;
}

// Fetch order summary and cart items
$orderSummary = $_SESSION['order_summary'];
$cartItems = $_SESSION['cart_items'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts E-Commerce - Address</title>
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
                        <div class="progress-step completed">
                            <div class="circle">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="step-label">Billing & Shipping</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step completed">
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
            </div>

            <div class="container my-4">
            <h2>Payment</h2>
                <hr>
                <div class="row">
                    <!-- Order Summary Section -->
                    <div class="col-12 col-lg-8">
                        <div class="bg-white shadow-sm p-3 mb-4">
                            <h3>Confirm Order</h3>
                            <hr>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="border-top-0 td-img">Product</th>
                                        <th class="border-top-0">Name</th>
                                        <th class="border-top-0 td-qty">Quantity</th>
                                        <th class="border-top-0 text-center td-price">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td class="td-img text-center">
                                                <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-fluid rounded" style="max-width: 80px;">
                                            </td>
                                            <td class="td-product_name">
                                                <strong><?= htmlspecialchars($item['name']) ?></strong>
                                            </td>
                                            <td class="td-qty text-center">
                                                <?= htmlspecialchars($item['quantity']) ?>
                                            </td>
                                            <td class="td-price text-center">
                                                $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <hr>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>$<?= number_format($orderSummary['subtotal'], 2) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Taxes:</span>
                                    <span>$<?= number_format($orderSummary['taxes'], 2) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong>$<?= number_format($orderSummary['total'], 2) ?></strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="col-12 col-lg-4">
                        <div class="bg-white shadow-sm p-3">
                            <h3>Payment Options</h3>
                            <hr>
                            <form action="process_payment.php" method="POST">
                                <div class="mb-3">
                                    <label for="cardNumber" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber" name="card_number" placeholder="1234 5678 9012 3456" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cardHolder" class="form-label">Card Holder Name</label>
                                    <input type="text" class="form-control" id="cardHolder" name="card_holder" placeholder="John Doe" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="expiryDate" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiryDate" name="expiry_date" placeholder="MM/YY" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="saveCard" name="save_card">
                                    <label class="form-check-label" for="saveCard">
                                        Save this card for future purchases
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Pay Now</button>
                            </form>
                        </div>
                    </div>
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
</body>
</html>