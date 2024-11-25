<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Order.php';
require_once 'classes/Cart.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate session data
        $userId = $_SESSION['user_id'] ?? null;
        $cartItems = $_SESSION['cart_items'] ?? [];

        if (empty($cartItems)) {
            throw new Exception('Cart is empty. Please add items before proceeding.');
        }

        // Validate order summary
        $orderSummary = $_SESSION['order_summary'] ?? [];
        if (!isset($orderSummary['subtotal']) || !isset($orderSummary['taxes']) || !isset($orderSummary['delivery'])) {
            throw new Exception('Order summary is incomplete');
        }

        $total = $orderSummary['subtotal'] + $orderSummary['taxes'] + $orderSummary['delivery'];

        // Format order items for database insertion
        $formattedItems = [];
        foreach ($cartItems as $item) {
            if (!isset($item['product_id'], $item['quantity'], $item['price'])) {
                throw new Exception('Invalid cart item data');
            }
            
            $formattedItems[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price']
            ];
        }

        // Begin transaction
        $conn->autocommit(FALSE);

        // Create order
        $order = new Order($conn);
        $orderId = $order->createOrder($userId, $total, 'Credit Card', null, $cartItems);

        // Insert order items with the formatted data
        $orderItemsData = array_map(function($item) {
            return [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'], 
                'price' => $item['price'] // Changed from unit_price to price to match DB structure
            ];
        }, $formattedItems);
        
        $order->addOrderItems($orderId, $orderItemsData);
        
        // Clear the cart
        $cart = new Cart($conn, $userId);
        $cart->clearCart();

        // Store order confirmation
        $_SESSION['order_confirmation'] = [
            'order_id' => $orderId,
            'total_amount' => $total,
            'payment_method' => 'Credit Card',
            'items' => $formattedItems
        ];

        // Commit transaction
        $conn->commit();
        $conn->autocommit(TRUE);

        error_log("Order created successfully: Order ID = $orderId");
        echo json_encode([
            'status' => 'success',
            'order_id' => $orderId
        ]);

    } catch (Exception $e) {
        // Rollback on error
        if (isset($conn)) {
            $conn->rollBack();
        }
        error_log("Order creation failed: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}