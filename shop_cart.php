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
<main class="container my-4">
    <h1>Shopping Cart</h1>

    <div class="row">
        <div class="col-md-8">
            <?php if (empty($cartItems)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary">-</button>
                                        <input type="text" class="form-control text-center" value="<?php echo $item['quantity']; ?>">
                                        <button class="btn btn-outline-secondary">+</button>
                                    </div>
                                </td>
                                <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td>
                                    <form method="post" action="shop_cart.php">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-secondary">Continue Shopping</a>
                    <a href="#" class="btn btn-primary">Process Checkout</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <h2>Order Total</h2>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span>$<?php echo number_format($subtotal, 2); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Taxes:</span>
                    <span>$<?php echo number_format($taxes, 2); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong>$<?php echo number_format($total, 2); ?></strong>
                </li>
            </ul>
            <div class="mt-3">
                <label for="promo-code" class="form-label">Gift card or discount code:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="promo-code" placeholder="Enter code">
                    <button class="btn btn-outline-primary">Apply</button>
                </div>
            </div>
            <a href="#" class="btn btn-success mt-3 w-100">Proceed to Checkout</a>
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