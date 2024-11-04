<?php

class Cart {
    private $db;
    private $userId;

    public function __construct($dbConnection, $userId) {
        $this->db = $dbConnection;
        $this->userId = $userId;
    }

    // Method to add a product to the cart
    public function addToCart($productId, $quantity = 1) {
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
        try {
            $query = $this->db->prepare("SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image_path
                                         FROM cart c
                                         JOIN products p ON c.product_id = p.id
                                         WHERE c.user_id = ?");
            $query->execute([$this->userId]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Handle exception
            error_log("Error fetching cart items: " . $e->getMessage());
            return [];
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