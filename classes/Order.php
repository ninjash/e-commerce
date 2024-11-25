<?php

class Order {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createOrder($userId, $total, $paymentMethod, $transactionId, $cartItems) {
        $this->db->begin_transaction();
        try {
            // Insert order into the orders table
            $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_amount, payment_method, transaction_id, created_at) VALUES (?, ?, ?, ?, NOW())");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param("idss", $userId, $total, $paymentMethod, $transactionId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $orderId = $stmt->insert_id; // Get the ID of the newly created order

            foreach ($cartItems as $item) {
                if (!isset($item['product_id'], $item['quantity'], $item['price'])) {
                    throw new Exception("Invalid item structure: " . print_r($item, true));
                }
            }
    
            // Commit the order transaction
            $this->db->commit();
    
            // Now handle inserting order items in a separate transaction
            $this->db->begin_transaction();
            $this->addOrderItems($orderId, $cartItems);
            $this->db->commit();
    
            return $orderId; // Return the created order ID
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Transaction rolled back: " . $e->getMessage());
            throw $e;
        }
    }

    public function addOrderItems($orderId, $orderItems) {
        // Prepare statement once for multiple executions
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            throw new Exception("Prepare failed: " . $this->db->error);
        }
    
        try {
            foreach ($orderItems as $item) {
                // Validate item structure
                if (!isset($item['product_id'], $item['quantity'], $item['price'])) {
                    error_log("Invalid item structure: " . print_r($item, true));
                    throw new Exception("Invalid item structure");
                }
    
                // Debug log
                error_log("Inserting order item: " . print_r($item, true));
    
                // Bind parameters using the correct field names
                $stmt->bind_param("iiid", 
                    $orderId, 
                    $item['product_id'], 
                    $item['quantity'], 
                    $item['price']
                );
    
                // Execute insert
                if (!$stmt->execute()) {
                    throw new Exception("Failed to insert order item: " . $stmt->error);
                }
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error in addOrderItems: " . $e->getMessage());
            throw $e;
        } finally {
            $stmt->close();
        }
    }

    public function getOrderById($orderId) {
        // Fetch order details
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $order = $stmt->get_result()->fetch_assoc();

        // Fetch order items
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $orderItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $order['items'] = $orderItems;
        return $order;
    }

    public function updateOrder($orderId, $totalAmount, $paymentMethod, $transactionId) {
        $stmt = $this->db->prepare("UPDATE orders SET total_amount = ?, payment_method = ?, transaction_id = ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("dssi", $totalAmount, $paymentMethod, $transactionId, $orderId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return true;
    }

    public function deleteOrder($orderId) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return true;
    }

    public function getOrdersByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Getters and Setters for Order properties
    public function getDb() {
        return $this->db;
    }

    public function setDb($db) {
        $this->db = $db;
    }
}