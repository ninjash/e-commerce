<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

header('Content-Type: application/json');

try {
    // Decode JSON payload
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Validate input
    if (!isset($data['product_id'])) {
        throw new Exception('Product ID is required');
    }

    $productId = (int)$data['product_id'];
    $quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1;

    if ($productId <= 0 || $quantity <= 0) {
        throw new Exception('Invalid product ID or quantity');
    }

    // Get user ID from session
    $userId = $_SESSION['user_id'] ?? null;
    
    // Initialize cart
    $cart = new Cart($conn, $userId);

    // Add to cart and get updated count
    $addToCartResult = $cart->addToCart($productId, $quantity);
    if ($addToCartResult === true) {
        $cartCount = $cart->getTotalCartItemCount();
        error_log("Product added successfully. New cart count: $cartCount");
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'cartCount' => $cartCount
        ]);
        exit;
    } else {
        throw new Exception('Failed to add product to cart: ' . $addToCartResult);
    }

} catch (Exception $e) {
    error_log("Error in add_to_cart.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error', 
        'message' => $e->getMessage()
    ]);
}