<?php

class Address
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection; // Accepts a database connection
    }

    /**
     * Add a new address
     * @param array $data Address data
     * @return int|false The ID of the inserted address or false on failure
     */
    public function createAddress($data)
    {
        $sql = "INSERT INTO addresses (user_id, cart_id, address_line_1, address_line_2, city, state, postal_code, country, phone_number, address_type, created_at, updated_at)
                VALUES (:user_id, :cart_id, :address_line_1, :address_line_2, :city, :state, :postal_code, :country, :phone_number, :address_type, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':cart_id', $data['cart_id']);
        $stmt->bindParam(':address_line_1', $data['address_line_1']);
        $stmt->bindParam(':address_line_2', $data['address_line_2']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':state', $data['state']);
        $stmt->bindParam(':postal_code', $data['postal_code']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':address_type', $data['address_type']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // Return the inserted address ID
        }
        return false;
    }

    /**
     * Retrieve an address by its ID
     * @param int $id Address ID
     * @return array|false Address data or false on failure
     */
    public function getAddressById($id)
    {
        $sql = "SELECT * FROM addresses WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
                SET user_id = :user_id, cart_id = :cart_id, address_line_1 = :address_line_1, address_line_2 = :address_line_2, 
                    city = :city, state = :state, postal_code = :postal_code, country = :country, 
                    phone_number = :phone_number, address_type = :address_type, updated_at = NOW() 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':cart_id', $data['cart_id']);
        $stmt->bindParam(':address_line_1', $data['address_line_1']);
        $stmt->bindParam(':address_line_2', $data['address_line_2']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':state', $data['state']);
        $stmt->bindParam(':postal_code', $data['postal_code']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':address_type', $data['address_type']);

        return $stmt->execute();
    }

    /**
     * Delete an address
     * @param int $id Address ID
     * @return bool True on success, false on failure
     */
    public function deleteAddress($id)
    {
        $sql = "DELETE FROM addresses WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Get all addresses for a specific user
     * @param int $userId User ID
     * @return array List of addresses
     */
    public function getAddressesByUserId($userId)
    {
        $sql = "SELECT * FROM addresses WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get addresses by cart ID
     * @param int $cartId Cart ID
     * @return array List of addresses
     */
    public function getAddressesByCartId($cartId)
    {
        $sql = "SELECT * FROM addresses WHERE cart_id = :cart_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the latest address for a user
     * @param int $userId User ID
     * @return array|false The latest address for the user or false if not found
     */
    public function getUserAddress($userId)
    {
        $sql = "SELECT * FROM addresses 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}