<?php

class Product {
    private $conn;
    private $product_id;

    public function __construct($db, $product_id) {
        $this->conn = $db;
        $this->product_id = $product_id;
    }

    public function getProductDetails() {
        $query = "SELECT p.name, p.sku, p.short_description, p.description, p.price, p.old_price, pi.image_path 
                  FROM products p
                  LEFT JOIN product_images pi ON p.id = pi.product_id
                  WHERE p.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getProductAttributes() {
        $query = "SELECT a.name, pa.value
                  FROM product_attributes pa
                  JOIN attributes a ON pa.attribute_id = a.id
                  WHERE pa.product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->product_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getProductImages() {
        $query = "SELECT image_path FROM product_images WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->product_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
