<?php

class Address
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection; // Accepts a mysqli database connection
    }

    /**
     * Add a new address
     * @param array $data Address data
     * @return int|false The ID of the inserted address or false on failure
     */
    public function createAddress($data)
    {
        $sql = "INSERT INTO addresses (user_id, cart_id, address_line_1, address_line_2, city, state, postal_code, country, phone_number, address_type, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return false;
        }

        $stmt->bind_param(
            'iissssssss',
            $data['user_id'],
            $data['cart_id'],
            $data['address_line_1'],
            $data['address_line_2'],
            $data['city'],
            $data['state'],
            $data['postal_code'],
            $data['country'],
            $data['phone_number'],
            $data['address_type']
        );

        if ($stmt->execute()) {
            return $stmt->insert_id; // Return the inserted address ID
        } else {
            error_log('Execute failed: ' . $stmt->error);
            return false;
        }
    }

    /**
     * Retrieve an address by its ID
     * @param int $id Address ID
     * @return array|false Address data or false on failure
     */
    public function getAddressById($id)
    {
        $sql = "SELECT * FROM addresses WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return false;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Fetch associative array
    }

    /**
     * Update an address
     * @param int $id Address ID
     * @param array $data Address data
     * @return bool True on success, false on failure
     */
    public function updateAddress($id, $data)
    {
        $sql = "UPDATE addresses 
                SET user_id = ?, cart_id = ?, address_line_1 = ?, address_line_2 = ?, 
                    city = ?, state = ?, postal_code = ?, country = ?, 
                    phone_number = ?, address_type = ?, updated_at = NOW() 
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return false;
        }

        $stmt->bind_param(
            'iissssssssi',
            $data['user_id'],
            $data['cart_id'],
            $data['address_line_1'],
            $data['address_line_2'],
            $data['city'],
            $data['state'],
            $data['postal_code'],
            $data['country'],
            $data['phone_number'],
            $data['address_type'],
            $id
        );

        return $stmt->execute();
    }

    /**
     * Delete an address
     * @param int $id Address ID
     * @return bool True on success, false on failure
     */
    public function deleteAddress($id)
    {
        $sql = "DELETE FROM addresses WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return false;
        }

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    /**
     * Get all addresses for a specific user
     * @param int $userId User ID
     * @return array List of addresses
     */
    public function getAddressesByUserId($userId)
    {
        $sql = "SELECT * FROM addresses WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return [];
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
    }

    /**
     * Get addresses by cart ID
     * @param int $cartId Cart ID
     * @return array List of addresses
     */
    public function getAddressesByCartId($cartId)
    {
        $sql = "SELECT * FROM addresses WHERE cart_id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return [];
        }

        $stmt->bind_param('i', $cartId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
    }

    public function saveUserAddress($userId, $name, $email, $phone, $street1, $street2, $city, $zip, $state, $country, $addressType, $sameAddress) {
        $sql = "INSERT INTO addresses (user_id, name, email, phone_number, address_line_1, address_line_2, city, postal_code, state, country, address_type, same_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                    name = VALUES(name), 
                    email = VALUES(email), 
                    phone_number = VALUES(phone_number), 
                    address_line_1 = VALUES(address_line_1), 
                    address_line_2 = VALUES(address_line_2), 
                    city = VALUES(city), 
                    postal_code = VALUES(postal_code), 
                    state = VALUES(state), 
                    country = VALUES(country), 
                    address_type = VALUES(address_type), 
                    same_address = VALUES(same_address)";
        
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            throw new Exception('Database prepare failed.');
        }

        $stmt->bind_param("issssssssssi", $userId, $name, $email, $phone, $street1, $street2, $city, $zip, $state, $country, $addressType, $sameAddress);
        if (!$stmt->execute()) {
            error_log('Execute failed: ' . $stmt->error);
            throw new Exception('Database execute failed.');
        }
    }

    /**
     * Get the latest address for a user
     * @param int $userId User ID
     * @return array|false The latest address for the user or false if not found
     */
    public function getUserAddress($userId) {
        $sql = "SELECT * FROM addresses WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return false;
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Fetch single row as associative array
    }
}