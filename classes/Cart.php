<?php

class Cart {
    private $db;
    private $userId;
    private $isGuest;

    public function __construct($dbConnection, $userId = null) {
        $this->db = $dbConnection;
        $this->userId = $userId;
        $this->isGuest = is_null($userId);

        // Initialize session cart for guest users
        if ($this->isGuest && !isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Method to add a product to the cart
    public function addToCart($productId, $quantity = 1) {
        try {
            if ($this->isGuest) {
                // For guests, store in session
                $currentQuantity = $_SESSION['cart'][$productId] ?? 0;
                $_SESSION['cart'][$productId] = max(1, $currentQuantity + $quantity); // Ensure quantity is at least 1
                return true;
            } else {
                // For logged-in users, add to the database
                $query = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $query->execute([$this->userId, $productId]);
                $result = $query->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $newQuantity = $result['quantity'] + $quantity;
                    $updateQuery = $this->db->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                    $updateQuery->execute([$newQuantity, $this->userId, $productId]);
                } else {
                    $insertQuery = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $insertQuery->execute([$this->userId, $productId, $quantity]);
                }
                return true;
            }
        } catch (Exception $e) {
            error_log("Error in addToCart: " . $e->getMessage());
            return false;
        }
    }

    // Method to remove a product from the cart
    public function removeFromCart($productId) {
        try {
            error_log("Attempting to remove product ID: $productId");
    
            if ($this->isGuest) {
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
    
                if ($query->execute()) {
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
            if ($this->isGuest) {
                // Guest cart: Retrieve items from the session
                if (!empty($_SESSION['cart'])) {
                    $productIds = array_keys($_SESSION['cart']);
                    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
                    $stmt = $this->db->prepare("SELECT id, name, price, image_url FROM products WHERE id IN ($placeholders)");
    
                    // Bind parameters dynamically
                    $types = str_repeat('i', count($productIds));
                    $stmt->bind_param($types, ...$productIds);
    
                    if ($stmt->execute()) {
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
    
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $items[] = $row;
                    }
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
            if ($this->isGuest) {
                return $_SESSION['cart'][$productId] ?? 0;
            } else {
                $query = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $query->execute([$this->userId, $productId]);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                return $result ? (int)$result['quantity'] : 0;
            }
        } catch (Exception $e) {
            error_log("Error fetching quantity: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalCartItemCount() {
        try {
            if ($this->isGuest) {
                // For guest users, count items in the session cart
                if (!empty($_SESSION['cart'])) {
                    return array_sum($_SESSION['cart']); // Total quantity of items
                }
                return 0; // No items in the cart
            } else {
                // For logged-in users, count items from the database
                $stmt = $this->db->prepare("SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?");
                $stmt->bind_param("i", $this->userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['total_items'] ?? 0; // Return total or 0 if null
            }
        } catch (Exception $e) {
            error_log('Error fetching total cart item count: ' . $e->getMessage());
            return 0; // Return 0 in case of an error
        }
    }

     // Add the updateQuantity method
     public function updateQuantity($productId, $quantityChange) {
        try {
            if ($this->isGuest) {
                // Update session cart for guest users
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId] += $quantityChange;
                    if ($_SESSION['cart'][$productId] <= 0) {
                        unset($_SESSION['cart'][$productId]);
                    }
                }
                return true;
            } else {
                // Update quantity in the database for logged-in users
                $stmt = $this->db->prepare("
                    UPDATE cart 
                    SET quantity = GREATEST(quantity + ?, 0) 
                    WHERE user_id = ? AND product_id = ?
                ");
                $stmt->execute([$quantityChange, $this->userId, $productId]);
    
                // Check if product needs to be removed
                $deleteStmt = $this->db->prepare("
                    DELETE FROM cart 
                    WHERE user_id = ? AND product_id = ? AND quantity <= 0
                ");
                $deleteStmt->execute([$this->userId, $productId]);
    
                return true;
            }
        } catch (Exception $e) {
            error_log("Error in updateQuantity: " . $e->getMessage());
            return false;
        }
    }
    
    public function mergeCart() {
        try {
            if (!$this->isGuest && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
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
                    $query->execute([$this->userId, $productId]);
                    $existingCartItem = $query->fetch(PDO::FETCH_ASSOC);
    
                    if ($existingCartItem) {
                        // Update quantity if the product exists in the user's cart
                        $newQuantity = $existingCartItem['quantity'] + $quantity;
                        $updateQuery = $this->db->prepare("
                            UPDATE cart 
                            SET quantity = ? 
                            WHERE user_id = ? AND product_id = ?
                        ");
                        $updateQuery->execute([$newQuantity, $this->userId, $productId]);
                    } else {
                        // Insert new item into the user's cart if it doesn't exist
                        $insertQuery = $this->db->prepare("
                            INSERT INTO cart (user_id, product_id, quantity) 
                            VALUES (?, ?, ?)
                        ");
                        $insertQuery->execute([$this->userId, $productId, $quantity]);
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
            if ($this->isGuest) {
                $_SESSION['cart'] = [];
                return true;
            } else {
                $query = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
                $query->execute([$this->userId]);
                return true;
            }
        } catch (Exception $e) {
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }
}