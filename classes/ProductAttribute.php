<?php
// Check if the class has already been declared to avoid re-declaration
if (!class_exists('ProductAttribute')) {

    class ProductAttribute {
        private $db;

        // Constructor
        public function __construct(mysqli $db) {
            $this->db = $db;
        }

        // Static method to fetch all attributes
        public static function getAllAttributes(mysqli $db) {
            $query = "SELECT * FROM attributes";
            $result = $db->query($query);
            if (!$result) {
                die('Error fetching attributes: ' . $db->error);
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Method to fetch product attributes by product ID
        public function getProductAttributesById($productId) {
            $query = "
                SELECT a.name, pa.value
                FROM product_attributes pa
                INNER JOIN attributes a ON pa.attribute_id = a.id
                WHERE pa.product_id = ?
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}