<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

// Use a default user ID for testing purposes
$userId = 1; // Replace with a proper user ID for development/testing
$cart = new Cart($conn, $userId);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Add to cart
        if ($action === 'add' && isset($_POST['product_id'], $_POST['quantity'])) {
            $productId = intval($_POST['product_id']);
            $quantity = intval($_POST['quantity']);
            $cart->addToCart($productId, $quantity);
        }

        // Remove from cart
        if ($action === 'remove' && isset($_POST['product_id'])) {
            $productId = intval($_POST['product_id']);
            $cart->removeFromCart($productId);
        }

        // Clear the cart
        if ($action === 'clear') {
            $cart->clearCart();
        }

        // Redirect to avoid form resubmission
        header('Location: shop_cart.php');
        exit();
    }
}

// Retrieve cart items
$cartItems = $cart->getCartItems();
$subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
$taxes = $subtotal * 0.00; // Assuming a 0% tax rate for simplicity
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
    <div class= "container-fluid oe_website_sale py-4 mb-3">
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
                <table class="table table-striped table-sm" id="cart_products">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cartItems)): ?>
                            <tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>
                        <?php else: ?>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td class="text-center"><img src="<?= htmlspecialchars($item['image_path']); ?>" class="img-thumbnail" alt="<?= htmlspecialchars($item['name']); ?>" style="max-width: 80px;"></td>
                                    <td>
                                        <strong><?= htmlspecialchars($item['name']); ?></strong>
                                        <br><a href="#" class="text-muted small">Remove</a>
                                    </td>
                                    <td class="text-center">
                                        <div class="input-group mx-auto justify-content-center" style="width: 120px;">
                                            <a href="#" class="btn btn-link">-</a>
                                            <input type="text" class="form-control text-center" value="<?= $item['quantity']; ?>" style="width: 50px;">
                                            <a href="#" class="btn btn-link">+</a>
                                        </div>
                                    </td>
                                    <td class="text-center">$<?= number_format($item['price'], 2); ?></td>
                                    <td class="text-center"><a href="#" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                                <span>$<?= number_format($subtotal, 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Taxes:</span>
                                <span>$<?= number_format($taxes, 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong>$<?= number_format($total, 2); ?></strong>
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
</body>
</html>