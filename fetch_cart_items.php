<?php
session_start();
require_once 'web/db_connect.php';
require_once 'classes/Cart.php';

header('Content-Type: application/json');

try {
    $cartItems = [];
    $userId = $_SESSION['user_id'] ?? null; // Null for guest users

    if ($userId === null) {
        // Guest user: Fetch cart from session
        if (!empty($_SESSION['cart'])) {
            $productIds = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($productIds), '?'));

            $stmt = $conn->prepare("
                SELECT 
                    p.id AS product_id, 
                    p.name, 
                    p.price, 
                    (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) AS image_url 
                FROM products p
                WHERE p.id IN ($placeholders)
            ");

            // Dynamically bind the product IDs
            $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result) {
                while ($product = $result->fetch_assoc()) {
                    $productId = $product['product_id'];
                    $cartItems[] = [
                        'product_id' => $productId,
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image_url' => $product['image_url'],
                        'quantity' => $_SESSION['cart'][$productId],
                        'subtotal' => $product['price'] * $_SESSION['cart'][$productId],
                    ];
                }
            } else {
                throw new Exception("Failed to fetch products for guest cart.");
            }
        }
    } else {
        // Logged-in user: Fetch cart from the database
        $stmt = $conn->prepare("
            SELECT 
                c.product_id, 
                c.quantity, 
                p.name, 
                p.price, 
                (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) AS image_url
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $cartItems[] = [
                    'product_id' => $row['product_id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'image_url' => $row['image_url'],
                    'quantity' => $row['quantity'],
                    'subtotal' => $row['price'] * $row['quantity'],
                ];
            }
        } else {
            throw new Exception("Failed to fetch products for user cart.");
        }
    }

    // Calculate totals
    $subtotal = array_sum(array_column($cartItems, 'subtotal'));
    $taxes = $subtotal * 0.00; // Assuming no tax
    $total = $subtotal + $taxes;

    // Send JSON response
    echo json_encode([
        'status' => 'success',
        'cartItems' => $cartItems,
        'subtotal' => $subtotal,
        'taxes' => $taxes,
        'total' => $total,
    ]);
} catch (Exception $e) {
    error_log("Error in fetch_cart_items.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch cart items',
    ]);
}