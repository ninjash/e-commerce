<?php
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

session_start();
header('Content-Type: application/json');

try {
    $userId = $_SESSION['user_id'] ?? null; // Null for guest users
    $itemCount = 0; // Default to 0 if no items are present

    if ($userId === null) {
        // Guest user: Calculate the count from the session cart
        if (!empty($_SESSION['cart'])) {
            $itemCount = array_sum($_SESSION['cart']); // Sum all quantities in the session cart
        }
    } else {
        // Logged-in user: Fetch the count from the database
        $stmt = $conn->prepare("
            SELECT SUM(quantity) AS total_quantity
            FROM cart
            WHERE user_id = ?
        ");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $itemCount = intval($row['total_quantity'] ?? 0); // Ensure a valid integer count
        } else {
            throw new Exception("Failed to fetch item count for logged-in user.");
        }
    }

    // Send JSON response
    echo json_encode([
        'status' => 'success',
        'count' => $itemCount,
    ]);
} catch (Exception $e) {
    // Log error for debugging and return a JSON error response
    error_log("Error in fetch_cart_item_count.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch cart item count.',
    ]);
}