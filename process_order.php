<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Order.php';
require_once 'classes/Cart.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'] ?? null;
    $cartItems = $_SESSION['cart_items'] ?? [];

    if (empty($cartItems)) {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty. Please add items before proceeding.']);
        exit;
    }

    $total = ($_SESSION['order_summary']['subtotal'] ?? 0) + ($_SESSION['order_summary']['taxes'] ?? 0) + ($_SESSION['order_summary']['delivery'] ?? 0);

    $order = new Order($conn);
    try {
        $orderId = $order->createOrder($userId, $total, 'Credit Card', $transactionId, $cartItems);

        // Insert order items
        $order->insertOrderItems($orderId, $cartItems);

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

        echo json_encode(['status' => 'success']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Order creation failed: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}