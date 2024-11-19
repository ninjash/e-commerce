<?php

class Payment {
    private $db;
    private $amount;
    private $paymentMethod;
    private $transactionId;
    private $status;

    public function __construct($db, $amount, $paymentMethod) {
        $this->db = $db;
        $this->amount = $amount;
        $this->paymentMethod = $paymentMethod;
        $this->status = 'pending';
    }

    public function processPayment() {
        // Logic to process the payment
        $this->transactionId = uniqid();
        $this->status = 'completed';
        return true;
    }

    public function savePaymentDetails($userId, $paymentDetails) {
        // Save payment details to the database
        $stmt = $this->db->prepare("INSERT INTO payments (user_id, amount, payment_details, transaction_id, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $userId, $this->amount, json_encode($paymentDetails), $this->transactionId, $this->status);
        return $stmt->execute();
    }

    public function getTransactionId() {
        return $this->transactionId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAmount() {
        return $this->amount;
    }
}