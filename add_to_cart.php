<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

header('Content-Type: application/json');

// Use file_get_contents for JSON payload
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Debugging output for received data
error_log("Received data: " . print_r($data, true));

// Check if required fields are provided
if (!isset($data['product_id']) || !isset($data['quantity'])) {
    error_log("Product ID or quantity missing in request.");
    echo json_encode(['status' => 'error', 'message' => 'Product ID and quantity are required']);
    exit;
}

$productId = (int)$data['product_id'];
$quantity = (int)$data['quantity'];

// Validate product ID and quantity
if ($productId <= 0 || $quantity <= 0) {
    error_log("Invalid product ID or quantity. Product ID: $productId, Quantity: $quantity");
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID or quantity']);
    exit;
}

// Check if user is logged in; if not, use guest session
$userId = $_SESSION['user_id'] ?? null; // If logged in, get user ID; otherwise, null for guest

// Log user and cart data
error_log("User ID: " . print_r($userId, true));
error_log("Product ID: $productId, Quantity: $quantity");

// Verify that database connection is established
if (!$conn) {
    error_log("Database connection is null or not established.");
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
} else {
    error_log("Database connection is established.");
}

// Instantiate the Cart object
try {
    $cart = new Cart($conn, $userId);
    error_log("Cart object created successfully.");
} catch (Exception $e) {
    error_log("Error creating Cart object: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Failed to initialize cart']);
    exit;
}

// Attempt to add to cart
try {
    $result = $cart->addToCart($productId, $quantity);
    error_log("addToCart called. Result: " . print_r($result, true));

    // Check if the operation was successful
    if ($result === true) {
        echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
    } else {
        error_log("addToCart operation failed. Result: " . print_r($result, true));
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart']);
    }
} catch (Exception $e) {
    error_log("Error in addToCart: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}