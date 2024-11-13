<?php
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

session_start();
header('Content-Type: application/json');

try {
    $userId = $_SESSION['user_id'] ?? null;
    $cart = new Cart($conn, $userId); // Initialize Cart with $conn and $userId

    // Use the new method to fetch total item count
    $itemCount = $cart->getTotalCartItemCount();

    echo json_encode(['status' => 'success', 'count' => $itemCount]);
} catch (Exception $e) {
    error_log('Error fetching cart item count: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch cart item count.']);
}