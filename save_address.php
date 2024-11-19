<?php
require_once 'web/db_connect.php';
require_once 'classes/Address.php';

session_start();

header('Content-Type: application/json');

try {
    $userId = $_SESSION['user_id'] ?? null;
    $isGuest = $userId === null;

    if ($isGuest) {
        // Generate a unique session ID for guest users
        $sessionId = session_id();
        // Insert a new user record for the guest user
        $stmt = $conn->prepare("INSERT INTO users (session_id) VALUES (?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)");
        $stmt->bind_param("s", $sessionId);
        if (!$stmt->execute()) {
            throw new Exception('Failed to create guest user.');
        }
        $userId = $stmt->insert_id;
    }

    $address = new Address($conn);

    // Get address data from POST request
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $street1 = $_POST['street1'] ?? '';
    $street2 = $_POST['street2'] ?? '';
    $city = $_POST['city'] ?? '';
    $zip = $_POST['zip'] ?? '';
    $state = $_POST['state'] ?? '';
    $country = $_POST['country'] ?? '';
    $addressType = $_POST['address_type'] ?? 'billing';
    $sameAddress = isset($_POST['sameAddress']) ? 1 : 0;

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($street1) || empty($city) || empty($zip) || empty($state) || empty($country)) {
        throw new Exception('All required fields must be filled out.');
    }

    // Save the address
    $address->saveUserAddress($userId, $name, $email, $phone, $street1, $street2, $city, $zip, $state, $country, $addressType, $sameAddress);

    // Return success response
    echo json_encode(['success' => true, 'redirect_to' => 'shop_payment.php']);
} catch (Exception $e) {
    error_log("Error in save_address.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}