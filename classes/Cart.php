<?php

class Cart {
    private $db;
    private $userId;
    private $isGuest;

    public function __construct($dbConnection, $userId = null) {
        $this->db = $dbConnection;
        $this->userId = $userId;
        $this->isGuest = is_null($userId); // Check if it's a guest session

        if ($this->isGuest) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
        }
    }

    // Method to add a product to the cart
    public function addToCart($productId, $quantity = 1) {
        if ($this->isGuest) {
            // For guests, store in session
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = $quantity;
            }
            return true;
        } else {
            // For logged-in users, store in database
            try {
                // Check if the product is already in the cart
                $query = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $query->execute([$this->userId, $productId]);
                $result = $query->fetch(PDO::FETCH_ASSOC);
    
                if ($result) {
                    // Update the quantity if the product is already in the cart
                    $newQuantity = $result['quantity'] + $quantity;
                    $updateQuery = $this->db->prepare("UPDATE cart SET quantity = ?, added_at = CURRENT_TIMESTAMP WHERE user_id = ? AND product_id = ?");
                    $updateQuery->execute([$newQuantity, $this->userId, $productId]);
                } else {
                    // Insert a new record if the product is not in the cart
                    $insertQuery = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $insertQuery->execute([$this->userId, $productId, $quantity]);
                }
    
                return true;
            } catch (Exception $e) {
                // Handle exception
                error_log("Error adding to cart: " . $e->getMessage());
                return false;
            }
        }
    }

    // Method to remove a product from the cart
    public function removeFromCart($productId) {
        try {
            $query = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $query->execute([$this->userId, $productId]);
            return true;
        } catch (Exception $e) {
            // Handle exception
            error_log("Error removing from cart: " . $e->getMessage());
            return false;
        }
    }

    // Method to get all items in the cart
    public function getCartItems() {
        if ($this->isGuest) {
            $items = [];
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                // Query the database to get product details for each item
                $query = $this->db->prepare("SELECT p.id, p.name, p.price, pi.image_path 
                                            FROM products p
                                            LEFT JOIN product_images pi ON p.id = pi.product_id
                                            WHERE p.id = ?");
                $query->bind_param("i", $productId);
                $query->execute();
                $result = $query->get_result();
                $product = $result->fetch_assoc();
                if ($product) {
                    $product['quantity'] = $quantity;
                    $items[] = $product;
                }
            }
            return $items;
        } else {
            $items = [];
            $query = $this->db->prepare("SELECT c.id, c.product_id, c.quantity, p.name, p.price, pi.image_path
                                        FROM cart c
                                        JOIN products p ON c.product_id = p.id
                                        LEFT JOIN product_images pi ON p.id = pi.product_id
                                        WHERE c.user_id = ?");
            $query->bind_param("i", $this->userId);
            $query->execute();
            $result = $query->get_result();

            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }

            return $items;
        }
    }

    // Method to clear the cart
    public function clearCart() {
        try {
            $query = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
            $query->execute([$this->userId]);
            return true;
        } catch (Exception $e) {
            // Handle exception
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }
}