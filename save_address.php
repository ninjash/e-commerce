<?php
require_once 'web/db_connect.php';
require_once 'classes/Address.php';

session_start();

ini_set('display_errors', 1); // Enable during debugging
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables and validate inputs
    $userId = $_SESSION['user_id'] ?? null; // Check if user is logged in
    $cartId = $_SESSION['cart_id'] ?? null; // Retrieve cart ID
    $street1 = trim($_POST['street1'] ?? '');
    $street2 = trim($_POST['street2'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    // Validate mandatory fields
    if (empty($street1) || empty($city) || empty($state) || empty($zip) || empty($country) || empty($phone)) {
        $_SESSION['error_message'] = 'All required fields must be filled in.';
        header('Location: /address');
        exit;
    }

    // Validate phone number format (example: basic check for numeric)
    if (!preg_match('/^\+?[0-9\s\-]+$/', $phone)) {
        $_SESSION['error_message'] = 'Invalid phone number format.';
        header('Location: /address');
        exit;
    }

    // Create address data array
    $data = [
        'user_id' => $userId,
        'cart_id' => $cartId,
        'address_line_1' => htmlspecialchars($street1, ENT_QUOTES, 'UTF-8'),
        'address_line_2' => htmlspecialchars($street2, ENT_QUOTES, 'UTF-8'),
        'city' => htmlspecialchars($city, ENT_QUOTES, 'UTF-8'),
        'state' => htmlspecialchars($state, ENT_QUOTES, 'UTF-8'),
        'postal_code' => htmlspecialchars($zip, ENT_QUOTES, 'UTF-8'),
        'country' => htmlspecialchars($country, ENT_QUOTES, 'UTF-8'),
        'phone_number' => htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'),
        'address_type' => 'shipping', // Default to 'shipping'
    ];

    try {
        // Instantiate the Address class and save the address
        $address = new Address($pdo);
        $addressId = $address->createAddress($data);

        if ($addressId) {
            // Address saved successfully
            $_SESSION['address_id'] = $addressId; // Store address ID in session
            $_SESSION['success_message'] = 'Address saved successfully.';
            header('Location: /checkout'); // Redirect to the checkout page
            exit;
        } else {
            throw new Exception('Failed to save the address. Please try again.');
        }
    } catch (Exception $e) {
        // Log error for debugging
        error_log('Error saving address: ' . $e->getMessage());

        // Redirect back to the address form with an error message
        $_SESSION['error_message'] = 'An error occurred while saving your address. Please try again later.';
        header('Location: /address');
        exit;
    }
} else {
    // If request method is not POST, redirect to the address form
    $_SESSION['error_message'] = 'Invalid request method.';
    header('Location: /address');
    exit;
}