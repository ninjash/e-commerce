<?php

class Order {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createOrder($userId, $totalAmount, $paymentMethod, $transactionId, $orderItems) {
        $this->db->begin_transaction();
        try {
            // Insert order into the orders table
            $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_amount, payment_method, transaction_id, created_at) VALUES (?, ?, ?, ?, NOW())");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param("idss", $userId, $totalAmount, $paymentMethod, $transactionId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $orderId = $stmt->insert_id;

            // Insert order items into the order_items table
            $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            foreach ($orderItems as $item) {
                $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function insertOrderItems($orderId, $orderItems) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        foreach ($orderItems as $item) {
            $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }
    }

    public function addOrderItem($orderId, $productId, $quantity, $price) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
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