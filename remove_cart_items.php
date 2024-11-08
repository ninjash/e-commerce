<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

header('Content-Type: application/json');

// Validate that a database connection exists
if (!isset($conn)) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection not available.']);
    exit;
}

// Check if the user is logged in or a guest
$userId = $_SESSION['user_id'] ?? null;
$isGuest = $userId === null;

// Initialize the Cart class
$cart = new Cart($conn, $userId);

// Handle the removal request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id'] ?? 0);

    if ($productId > 0) {
        $isRemoved = $cart->removeFromCart($productId);

        if ($isRemoved) {
            echo json_encode(['status' => 'success', 'message' => 'Item removed from cart.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove item from cart.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
    }
    exit;
}

// If no POST request, return an error
echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
exit;