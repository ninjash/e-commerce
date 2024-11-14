<?php
require_once 'web/db_connect.php';
require_once 'classes/Address.php';

session_start();
ob_start();

ini_set('display_errors', 1); // Enable during debugging
error_reporting(E_ALL);

// Log data for debugging
error_log('POST Data in save_address.php: ' . print_r($_POST, true));
error_log('Session Data before processing in save_address.php: ' . print_r($_SESSION, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables and validate inputs
    $userId = $_SESSION['user_id'] ?? null; // Optional for guests
    $cartId = $_SESSION['cart_id'] ?? null; // Check for cart session
    $street1 = trim($_POST['street1'] ?? '');
    $street2 = trim($_POST['street2'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $redirectTo = trim($_POST['redirect_to'] ?? 'shop_payment.php'); // Default redirect to payment page

    // Validate mandatory fields
    if (empty($street1) || empty($city) || empty($state) || empty($zip) || empty($country) || empty($phone)) {
        $_SESSION['error_message'] = 'All required fields must be filled in.';
        error_log('Validation failed: Missing required fields.');
        header('Location: shop_address.php');
        exit;
    }

    // Validate phone number format
    if (!preg_match('/^\+?[0-9\s\-]+$/', $phone)) {
        $_SESSION['error_message'] = 'Invalid phone number format.';
        error_log('Validation failed: Invalid phone number format.');
        header('Location: shop_address.php');
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
        'address_type' => 'shipping',
    ];

    try {
        // Pass $conn to the Address class
        $address = new Address($conn);

        // Save the address and log the process
        $addressId = $address->createAddress($data);

        if ($addressId) {
            $_SESSION['address_id'] = $addressId;
            $_SESSION['success_message'] = 'Address saved successfully.';
            error_log("Address saved with ID: $addressId");

            // Only validate `order_summary` to proceed
            if (!isset($_SESSION['order_summary']) || empty($_SESSION['order_summary'])) {
                $_SESSION['error_message'] = 'Order summary missing. Redirecting to cart.';
                error_log('Order summary missing.');
                header('Location: shop_cart.php');
                exit;
            }

            // Redirect to the next step
            header("Location: $redirectTo");
            exit;
        } else {
            throw new Exception('Failed to save the address. Check database connection and query.');
        }
    } catch (Exception $e) {
        // Log detailed error for debugging
        error_log('Error saving address: ' . $e->getMessage());
        $_SESSION['error_message'] = 'An error occurred while saving your address. Please try again later.';

        // Detailed error message for debugging on the page (temporary)
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    $_SESSION['error_message'] = 'Invalid request method.';
    error_log('Invalid request method received.');
    header('Location: shop_address.php');
    exit;
}