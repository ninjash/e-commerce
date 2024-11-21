<?php
include 'web/db_connect.php';
include 'classes/Order.php';
include 'classes/Payment.php';
include 'classes/Cart.php';
session_start();

// Check if the order confirmation details are available in the session
if (!isset($_SESSION['order_confirmation'])) {
    // Call process_order.php to create the order
    $orderData = [
        'total_amount' => $_SESSION['order_summary']['subtotal'] + $_SESSION['order_summary']['taxes'] + $_SESSION['order_summary']['delivery'],
        'payment_method' => 'Credit Card',
        'transaction_id' => $_SESSION['transaction_id']
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'process_order.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($orderData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    if ($response['status'] !== 'success') {
        $_SESSION['error_message'] = 'Order creation failed: ' . $response['message'];
        header('Location: shop_cart.php');
        exit;
    }

    // Fetch order confirmation details from the session
    $orderConfirmation = $_SESSION['order_confirmation'];
} else {
    $orderConfirmation = $_SESSION['order_confirmation'];
}

$orderId = $orderConfirmation['order_id'];
$totalAmount = $orderConfirmation['total_amount'];
$paymentMethod = $orderConfirmation['payment_method'];
$transactionId = $orderConfirmation['transaction_id'];
$orderItems = $orderConfirmation['order_items'];
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
                <li class="list-group-item"><strong>Total Amount:</strong> $<?= number_format($totalAmount, 2) ?></li>
                <li class="list-group-item"><strong>Payment Method:</strong> <?= htmlspecialchars($paymentMethod) ?></li>
                <li class="list-group-item"><strong>Transaction ID:</strong> <?= htmlspecialchars($transactionId) ?></li>
            </ul>
            <h3 class="mt-4">Order Items</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                        <td><?php echo $item['quantity'] * $item['price']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<footer>
    <?php include 'global/footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>