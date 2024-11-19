<?php

class Cart {
    private $db;
    private $userId;
    private $sessionId;

    public function __construct($dbConnection, $userId = null) {
        $this->db = $dbConnection;
        $this->userId = $userId;
        $this->sessionId = session_id();

        // Initialize session cart for guest users
        if ($this->isGuest() && !isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Check if the user is a guest
    private function isGuest() {
        return $this->userId === null;
    }

    // Method to add a product to the cart
    public function addToCart($productId, $quantity = 1) {
        try {
            $this->db->begin_transaction();
            error_log("Starting addToCart - Product ID: $productId, Quantity: $quantity, User ID: " . ($this->userId ?? 'guest'));
    
            $success = false;
    
            if ($this->isGuest()) {
                // Store in session first
                $currentQuantity = $_SESSION['cart'][$productId] ?? 0;
                $_SESSION['cart'][$productId] = max(1, $currentQuantity + $quantity);
    
                // Check existing cart entry
                $stmt = $this->db->prepare("SELECT quantity FROM cart WHERE session_id = ? AND product_id = ?");
                $stmt->bind_param('si', $this->sessionId, $productId);
                $stmt->execute();
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    // Update existing entry
                    $currentQty = $result->fetch_assoc()['quantity'];
                    $newQty = $currentQty + $quantity;
    
                    $update = $this->db->prepare("UPDATE cart SET quantity = ? WHERE session_id = ? AND product_id = ?");
                    $update->bind_param('isi', $newQty, $this->sessionId, $productId);
                    $success = $update->execute();
    
                    error_log("Updated guest cart - Session: {$this->sessionId}, Product: $productId, New Quantity: $newQty, Success: " . ($success ? 'true' : 'false'));
                } else {
                    // Insert new entry
                    $insert = $this->db->prepare("INSERT INTO cart (session_id, product_id, quantity) VALUES (?, ?, ?)");
                    $insert->bind_param('sii', $this->sessionId, $productId, $quantity);
                    $success = $insert->execute();
    
                    error_log("Inserted guest cart - Session: {$this->sessionId}, Product: $productId, Quantity: $quantity, Success: " . ($success ? 'true' : 'false'));
                }
            } else {
                // Check existing cart entry for logged-in user
                $stmt = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param('ii', $this->userId, $productId);
                $stmt->execute();
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    $currentQty = $result->fetch_assoc()['quantity'];
                    $newQty = $currentQty + $quantity;
    
                    $update = $this->db->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                    $update->bind_param('iii', $newQty, $this->userId, $productId);
                    $success = $update->execute();
    
                    error_log("Updated user cart - ID: {$this->userId}, Product: $productId, New Quantity: $newQty, Success: " . ($success ? 'true' : 'false'));
                } else {
                    $insert = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $insert->bind_param('iii', $this->userId, $productId, $quantity);
                    $success = $insert->execute();
    
                    error_log("Inserted user cart - ID: {$this->userId}, Product: $productId, Quantity: $quantity, Success: " . ($success ? 'true' : 'false'));
                }
            }
    
            if ($success) {
                $this->db->commit();
                error_log("Cart operation completed successfully");
                return true;
            } else {
                throw new Exception("Database operation failed");
            }
    
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error in addToCart: " . $e->getMessage());
            return $e->getMessage();
        }
    }

    // Method to remove a product from the cart
    public function removeFromCart($productId) {
        try {
            error_log("Attempting to remove product ID: $productId");

            if ($this->isGuest()) {
                // For guest users, remove from the session cart
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                    error_log("Product removed from guest cart: $productId");
                    return true;
                } else {
                    error_log("Product ID not found in guest cart: $productId");
                    return false; // Product not found in the session cart
                }
            } else {
                // For logged-in users, remove from the database
                $query = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
                $query->bind_param('ii', $this->userId, $productId);
                $query->execute();

                if ($query->affected_rows > 0) {
                    error_log("Product removed from database cart for user ID {$this->userId}: $productId");
                    return true;
                } else {
                    error_log("Database error while removing product: " . $query->error);
                    return false;
                }
            }
        } catch (Exception $e) {
            error_log("Error in removeFromCart: " . $e->getMessage());
            return false;
        }
    }

    // Method to get all items in the cart
    public function getCartItems() {
        try {
            $items = [];
            if ($this->isGuest()) {
                // Guest cart: Retrieve items from the session
                if (!empty($_SESSION['cart'])) {
                    $productIds = array_keys($_SESSION['cart']);
                    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
                    $stmt = $this->db->prepare("SELECT id, name, price, image_url FROM products WHERE id IN ($placeholders)");

                    // Execute the statement with product IDs
                    $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $productId = $row['id'];
                        $items[] = [
                            'product_id' => $productId,
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'image_url' => $row['image_url'],
                            'quantity' => $_SESSION['cart'][$productId],
                        ];
                    }
                }
            } else {
                // Logged-in user: Retrieve items from the database
                $stmt = $this->db->prepare("
                    SELECT c.product_id, c.quantity, p.name, p.price, p.image_url 
                    FROM cart c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.user_id = ?
                ");
                $stmt->bind_param('i', $this->userId);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $items[] = $row;
                }
            }
            return $items;
        } catch (Exception $e) {
            error_log("Error fetching cart items: " . $e->getMessage());
            return [];
        }
    }

    // Method to get the quantity of a specific product
    public function getQuantity($productId) {
        try {
            if ($this->isGuest()) {
                return $_SESSION['cart'][$productId] ?? 0;
            } else {
                $query = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $query->bind_param('ii', $this->userId, $productId);
                $query->execute();
                $result = $query->get_result()->fetch_assoc();
                return $result ? (int)$result['quantity'] : 0;
            }
        } catch (Exception $e) {
            error_log("Error fetching quantity: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalCartItemCount() {
        try {
            if ($this->isGuest()) {
                // For guest users, count items in the session cart
                if (!empty($_SESSION['cart'])) {
                    return array_sum($_SESSION['cart']); // Total quantity of items
                }
                return 0; // No items in the cart
            } else {
                // For logged-in users, count items from the database
                $stmt = $this->db->prepare("SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?");
                $stmt->bind_param('i', $this->userId);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();
                return $result['total_items'] ?? 0; // Return total or 0 if null
            }
        } catch (Exception $e) {
            error_log('Error fetching total cart item count: ' . $e->getMessage());
            return 0; // Return 0 in case of an error
        }
    }

    public function getProductQuantity($productId) {
        $stmt = $this->db->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param('ii', $this->userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['quantity'] ?? 0;
    }

    // Add the updateQuantity method
    public function updateQuantity($productId, $quantityChange) {
        try {
            if ($this->isGuest()) {
                // Update session cart for guest users
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId] += $quantityChange;

                    // Remove product if quantity becomes zero or negative
                    if ($_SESSION['cart'][$productId] <= 0) {
                        unset($_SESSION['cart'][$productId]);
                    }
                } elseif ($quantityChange > 0) {
                    // Add product if it doesn't already exist in the session cart
                    $_SESSION['cart'][$productId] = $quantityChange;
                }
                return true;
            } else {
                // Update quantity in the database for logged-in users
                $this->db->begin_transaction(); // Start transaction

                // Check current quantity in the database
                $currentQuantityStmt = $this->db->prepare("
                    SELECT quantity 
                    FROM cart 
                    WHERE user_id = ? AND product_id = ?
                ");
                $currentQuantityStmt->bind_param('ii', $this->userId, $productId);
                $currentQuantityStmt->execute();
                $currentQuantity = $currentQuantityStmt->get_result()->fetch_column();

                // If product exists in the cart, update quantity
                if ($currentQuantity !== false) {
                    $newQuantity = $currentQuantity + $quantityChange;

                    if ($newQuantity > 0) {
                        // Update the product quantity
                        $updateStmt = $this->db->prepare("
                            UPDATE cart 
                            SET quantity = ? 
                            WHERE user_id = ? AND product_id = ?
                        ");
                        $updateStmt->bind_param('iii', $newQuantity, $this->userId, $productId);
                        $updateStmt->execute();
                    } else {
                        // Remove the product if quantity becomes zero or negative
                        $deleteStmt = $this->db->prepare("
                            DELETE FROM cart 
                            WHERE user_id = ? AND product_id = ?
                        ");
                        $deleteStmt->bind_param('ii', $this->userId, $productId);
                        $deleteStmt->execute();
                    }
                } elseif ($quantityChange > 0) {
                    // If product doesn't exist, add it with the given quantity
                    $insertStmt = $this->db->prepare("
                        INSERT INTO cart (user_id, product_id, quantity) 
                        VALUES (?, ?, ?)
                    ");
                    $insertStmt->bind_param('iii', $this->userId, $productId, $quantityChange);
                    $insertStmt->execute();
                }

                $this->db->commit(); // Commit transaction
                return true;
            }
        } catch (Exception $e) {
            $this->db->rollback(); // Rollback transaction in case of error
            error_log("Error in updateQuantity: " . $e->getMessage());
            return false;
        }
    }

    public function updateProductQuantity($productId, $quantityChange) {
        // Fetch current quantity
        $currentQuantity = $this->getProductQuantity($productId);

        // Calculate new quantity
        $newQuantity = $currentQuantity + $quantityChange;

        if ($newQuantity < 0) {
            throw new Exception('Quantity cannot be negative');
        }

        // Update quantity in the database
        $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param('iii', $newQuantity, $this->userId, $productId);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception('Failed to update product quantity');
        }
    }

    public function mergeCart() {
        try {
            if (!$this->isGuest() && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                // Fetch guest cart from session
                $guestCart = $_SESSION['cart'];

                // Loop through each item in the guest cart
                foreach ($guestCart as $productId => $quantity) {
                    // Check if the product already exists in the user's cart
                    $query = $this->db->prepare("
                        SELECT quantity 
                        FROM cart 
                        WHERE user_id = ? AND product_id = ?
                    ");
                    $query->bind_param('ii', $this->userId, $productId);
                    $query->execute();
                    $existingCartItem = $query->get_result()->fetch_assoc();

                    if ($existingCartItem) {
                        // Update quantity if the product exists in the user's cart
                        $newQuantity = $existingCartItem['quantity'] + $quantity;
                        $updateQuery = $this->db->prepare("
                            UPDATE cart 
                            SET quantity = ? 
                            WHERE user_id = ? AND product_id = ?
                        ");
                        $updateQuery->bind_param('iii', $newQuantity, $this->userId, $productId);
                        $updateQuery->execute();
                    } else {
                        // Insert new item into the user's cart if it doesn't exist
                        $insertQuery = $this->db->prepare("
                            INSERT INTO cart (user_id, product_id, quantity) 
                            VALUES (?, ?, ?)
                        ");
                        $insertQuery->bind_param('iii', $this->userId, $productId, $quantity);
                        $insertQuery->execute();
                    }
                }

                // Clear the guest cart after merging
                unset($_SESSION['cart']);
            }
        } catch (Exception $e) {
            error_log("Error merging cart: " . $e->getMessage());
        }
    }

    // Method to clear the cart
    public function clearCart() {
        try {
            if ($this->isGuest()) {
                $_SESSION['cart'] = [];
                $query = $this->db->prepare("DELETE FROM cart WHERE session_id = ?");
                $query->bind_param('s', $this->sessionId);
                $query->execute();
            } else {
                $query = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
                $query->bind_param('i', $this->userId);
                $query->execute();
            }
            return true;
        } catch (Exception $e) {
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }
}