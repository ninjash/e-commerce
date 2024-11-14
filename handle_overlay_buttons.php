<?php
// Include necessary files
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

// Start session
session_start();

// Check if the request is AJAX and POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    // Decode JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (isset($input['action']) && isset($input['product_id'])) {
        $action = $input['action'];
        $productId = intval($input['product_id']);
        $userId = $_SESSION['user_id'] ?? null;

        // Initialize Cart class
        $cart = new Cart($conn, $userId);

        switch ($action) {
            case 'add_to_cart':
                $quantity = $input['quantity'] ?? 1;
                if ($cart->addToCart($productId, $quantity)) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Product added to cart successfully!',
                        'cartCount' => $cart->getTotalCartItemCount()
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart.']);
                }
                break;

            case 'add_to_wishlist':
                // Placeholder for wishlist logic
                echo json_encode(['status' => 'success', 'message' => 'Product added to wishlist!']);
                break;

            case 'view_product':
                // Placeholder for viewing product (no backend action needed)
                echo json_encode(['status' => 'success', 'redirect' => "product_page.php?id=$productId"]);
                break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
                break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request data.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}