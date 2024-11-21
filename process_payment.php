<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Payment.php';
require_once 'classes/Order.php';
require_once 'classes/Cart.php';

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Error and exception handlers
ini_set('display_errors', 0);
error_reporting(E_ALL);

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function ($exception) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $exception->getMessage()]);
    exit;
});

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentDetails = [
        'card_number' => $_POST['cardNumber'] ?? '',
        'expiry_date' => $_POST['expiryDate'] ?? '',
        'cvv' => $_POST['cvv'] ?? ''
    ];

    $total = ($_SESSION['order_summary']['subtotal'] ?? 0) + ($_SESSION['order_summary']['taxes'] ?? 0) + ($_SESSION['order_summary']['delivery'] ?? 0);
    $userId = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    error_log("Processing payment for user ID: " . ($userId ?? 'Guest') . ", Total: $total");

    // Process payment
    $payment = new Payment($conn, $total, 'credit_card', $sessionId);
    if ($payment->processPayment()) {
        $transactionId = $payment->getTransactionId();
        error_log("Payment processed successfully. Transaction ID: " . $transactionId);

        // Create order first
        $order = new Order($conn);
        $cartItems = $_SESSION['cart_items'] ?? [];

        try {
            $orderId = $order->createOrder($userId, $total, 'Credit Card', $transactionId, $cartItems);

            // Insert order items
            $order->insertOrderItems($orderId, $cartItems);

            // Clear the cart
            $cart = new Cart($conn, $userId);
            $cart->clearCart();

            error_log("Order created successfully. Order ID: " . $orderId);

            // Save payment details with the correct order_id
            if ($payment->savePaymentDetails($userId, $paymentDetails, $orderId)) {
                error_log("Payment details saved successfully.");

                // Store order confirmation details in the session
                $_SESSION['order_confirmation'] = [
                    'order_id' => $orderId,
                    'total_amount' => $total,
                    'payment_method' => 'Credit Card',
                    'transaction_id' => $transactionId,
                    'order_items' => $cartItems
                ];

                echo json_encode(['status' => 'success']);
                exit;
            } else {
                error_log("Failed to save payment details.");
                echo json_encode(['status' => 'error', 'message' => 'Failed to save payment details.']);
                exit;
            }
        } catch (Exception $e) {
            error_log("Order creation failed: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Order creation failed: ' . $e->getMessage()]);
            exit;
        }
    } else {
        error_log("Payment processing failed.");
        echo json_encode(['status' => 'error', 'message' => 'Payment processing failed.']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}