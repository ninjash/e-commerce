<?php
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

session_start();

// Ensure JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    // Validate input
    if ($productId <= 0 || !in_array($action, ['increase', 'decrease'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product ID or action.']);
        exit;
    }

    $userId = $_SESSION['user_id'] ?? null;
    $cart = new Cart($pdo, $userId);

    try {
        // Calculate the quantity change
        $quantityChange = ($action === 'increase') ? 1 : -1;

        // Update quantity
        $success = $cart->updateQuantity($productId, $quantityChange);

        if ($success) {
            // Get updated cart details
            $cartItems = $cart->getCartItems();
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
            $taxes = $subtotal * 0.00; // Assuming no tax
            $total = $subtotal + $taxes;

            echo json_encode([
                'status' => 'success',
                'cartItems' => $cartItems,
                'subtotal' => number_format($subtotal, 2),
                'taxes' => number_format($taxes, 2),
                'total' => number_format($total, 2),
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update quantity.']);
        }
    } catch (Exception $e) {
        error_log("Error in update_cart_quantity.php: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Server error occurred.']);
    }
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}