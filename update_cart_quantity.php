<?php
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

session_start();

// Ensure JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Decode the JSON input
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Validate input data
        if (!$data) {
            throw new Exception('Invalid JSON input.');
        }

        $productId = intval($data['product_id'] ?? 0);
        $action = $data['action'] ?? ''; // 'increase', 'decrease', or 'update'
        $quantity = intval($data['quantity'] ?? 0); // Only used for 'update' action

        // Validate product ID and action
        if ($productId <= 0 || !in_array($action, ['increase', 'decrease', 'update'])) {
            throw new Exception('Invalid product ID or action.');
        }

        // Initialize Cart class
        $userId = $_SESSION['user_id'] ?? null; // Null for guest users
        $cart = new Cart($pdo, $userId);

        // Determine quantity change
        $quantityChange = match ($action) {
            'increase' => 1,
            'decrease' => -1,
            'update' => $quantity - $cart->getProductQuantity($productId),
            default => throw new Exception('Invalid action type.'),
        };

        // Ensure a meaningful quantity change
        if ($quantityChange === 0) {
            throw new Exception('No change in quantity.');
        }

        // Update the cart
        $success = $cart->updateQuantity($productId, $quantityChange);
        if (!$success) {
            throw new Exception('Failed to update quantity.');
        }

        // Fetch updated cart details
        $cartItems = $cart->getCartItems();
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
        $taxes = $subtotal * 0.00; // Assuming no tax
        $total = $subtotal + $taxes;

        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Cart updated successfully!',
            'cartItems' => array_map(function ($item) {
                return [
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'], // Include item subtotal
                ];
            }, $cartItems),
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'total' => $total,
        ]);
        exit;
    } catch (Exception $e) {
        // Log and return the error message
        error_log("Error in update_cart_quantity.php: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage(),
        ]);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}