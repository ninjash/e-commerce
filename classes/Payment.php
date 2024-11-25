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

    public function processPayment($paymentDetails) {
        // Validate payment details
        if (empty($paymentDetails['card_number']) || empty($paymentDetails['expiry_date']) || empty($paymentDetails['cvv'])) {
            throw new Exception("Payment details are incomplete.");
        }

        // Simulate payment processing logic
        // Here you would integrate with a payment gateway
        $this->transactionId = uniqid(); // Generate a unique transaction ID
        $this->status = 'completed'; // Update status to completed

        // Log the payment processing (for debugging)
        error_log("Payment processed: Transaction ID: {$this->transactionId}, Amount: {$this->amount}, Status: {$this->status}");

        return true; // Return true on successful payment processing
    }

    public function savePaymentDetails($userId, $paymentDetails, $orderId) {
        $stmt = $this->db->prepare("INSERT INTO payments (user_id, amount, payment_details, transaction_id, status, session_id, order_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        $paymentDetailsJson = json_encode($paymentDetails);
        $stmt->bind_param("idssssi", $userId, $this->amount, $paymentDetailsJson, $this->transactionId, $this->status, $this->sessionId, $orderId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return true;
    }

    // Getters and Setters
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