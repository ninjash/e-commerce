<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

header('Content-Type: application/json');

// Use file_get_contents for JSON payload
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Debugging output
error_log("Received data: " . print_r($data, true));

if (!isset($data['product_id']) || !isset($data['quantity'])) {
    echo json_encode(['status' => 'error', 'message' => 'Product ID and quantity are required']);
    exit;
}

$productId = (int)$data['product_id'];
$quantity = (int)$data['quantity'];

// Check if user is logged in; if not, use guest session
$userId = $_SESSION['user_id'] ?? null;

$cart = new Cart($conn, $userId);

try {
    $cart->addToCart($productId, $quantity);
    echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}