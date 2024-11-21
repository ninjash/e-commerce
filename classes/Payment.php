<?php

class Payment {
    private $db;
    private $amount;
    private $paymentMethod;
    private $transactionId;
    private $status;
    private $sessionId;

    public function __construct($db, $amount, $paymentMethod, $sessionId = null) {
        $this->db = $db;
        $this->amount = $amount;
        $this->paymentMethod = $paymentMethod;
        $this->status = 'pending';
        $this->sessionId = $sessionId;
    }

    public function processPayment() {
        // Logic to process the payment
        $this->transactionId = uniqid();
        $this->status = 'completed';
        return true;
    }

    public function savePaymentDetails($userId, $paymentDetails, $orderId) {
        $stmt = $this->db->prepare("INSERT INTO payments (user_id, amount, payment_details, transaction_id, status, session_id, order_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $paymentDetailsJson = json_encode($paymentDetails);
        $status = 'completed'; // or whatever status is appropriate
        $stmt->bind_param("idsssii", $userId, $this->amount, $paymentDetailsJson, $this->transactionId, $status, $this->sessionId, $orderId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return true;
    }

    // Getters
    public function getTransactionId() {
        return $this->transactionId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    public function getSessionId() {
        return $this->sessionId;
    }

    // Setters
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }
}