<?php
include 'web/db_connect.php';
include 'classes/Order.php';
include 'classes/Payment.php';
include 'classes/Cart.php';
include 'show_order_summary.php';
session_start();

$orderConfirmation = $_SESSION['order_confirmation'] ?? null;

// Check if the order confirmation details are available in the session
if (!$orderConfirmation) {
    header('Location: shop_cart.php');
    exit;
}

$orderId = $orderConfirmation['order_id'] ?? null;
$totalAmount = $orderConfirmation['total_amount'] ?? 0.00;
$paymentMethod = $orderConfirmation['payment_method'] ?? '';
$transactionId = $orderConfirmation['transaction_id'] ?? '';
$delivery = $_SESSION['order_summary']['delivery'] ?? 130.00;
$subtotal = $_SESSION['order_summary']['subtotal'] ?? 0.00;
$taxes = $_SESSION['order_summary']['taxes'] ?? 0.00;
$total = $subtotal + $taxes + $delivery;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/e-commerce/styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <?php include 'global/header.php'; ?>
</header>

<main class="container my-5">
    <h1 class="text-center">Order Confirmation</h1>
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
            <div class="progress-step completed">
                <div class="circle">
                    <i class="bi bi-check-lg"></i>
                </div>
                <span class="step-label">Confirmation</span>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="card-title">Thank you for your purchase!</h2>
            <p class="card-text">Your order has been successfully placed. Here are the details:</p>
            <ul class="list-group">
                <li class="list-group-item"><strong>Order ID:</strong> <?= htmlspecialchars($orderId) ?></li>
                <li class="list-group-item"><strong>Total Amount:</strong> $<?= number_format($total, 2) ?></li>
                <li class="list-group-item"><strong>Payment Method:</strong> <?= htmlspecialchars($paymentMethod) ?></li>
                <li class="list-group-item"><strong>Transaction ID:</strong> <?= htmlspecialchars($transactionId) ?></li>
            </ul>
            <?php show_order_summary($orderId, $conn); ?>
        </div>
    </div>
</main>

<footer>
    <?php include 'global/footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    // Update order summary
    const deliveryFee = parseFloat($('#order_delivery .oe_currency_value').text()) || 130.00;
    const subtotal = parseFloat($('#order_subtotal .oe_currency_value').text()) || 0.00;
    const taxes = parseFloat($('#order_taxes .oe_currency_value').text()) || 0.00;
    const total = (subtotal + taxes + deliveryFee).toFixed(2);

    $('#order_total .oe_currency_value').text(total);
});
</script>

</body>
</html>