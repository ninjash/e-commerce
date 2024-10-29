<?php
class Product {
    private $db;
    private $id;
    private $name;
    private $sku;
    private $shortDescription;
    private $price;
    private $description;
    private $featureProduct;
    private $oldPrice;
    private $manufacturerId;
    private $imagePath;
    private $manufacturerDetails = []; // Stores manufacturer details

    public function __construct($db, $id = null) {
        $this->db = $db;
        if ($id) {
            $this->getProductById($id);
            $this->imagePath = $this->getProductImage($id); // Fetch product image
            $this->manufacturerDetails = $this->fetchManufacturerDetails($this->manufacturerId); // Fetch manufacturer details
        }
    }

    // Fetch manufacturer details (name and logo)
    public function fetchManufacturerDetails($manufacturerId) {
        $query = "SELECT name, logo_path FROM manufacturers WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $manufacturerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $manufacturer = $result->fetch_assoc();

        return $manufacturer ? $manufacturer : ['name' => 'Unknown', 'logo_path' => '/e-commerce/images/default-logo.png']; // Default values
    }

    // Getters and Setters for existing functionality
    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getSku() {
        return $this->sku;
    }

    public function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
    }

    public function getShortDescription() {
        return $this->shortDescription;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setFeatureProduct($featureProduct) {
        $this->featureProduct = $featureProduct;
    }

    public function getFeatureProduct() {
        return $this->featureProduct;
    }

    public function setOldPrice($oldPrice) {
        $this->oldPrice = $oldPrice;
    }

    public function getOldPrice() {
        return $this->oldPrice;
    }

    public function setManufacturerId($manufacturerId) {
        $this->manufacturerId = $manufacturerId;
    }

    public function getManufacturerId() {
        return $this->manufacturerId;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getManufacturerDetails() {
        return $this->manufacturerDetails;
    }

    // Fetch a single product by ID
    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $this->id = $product['id'];
            $this->name = $product['name'];
            $this->sku = $product['sku'];
            $this->shortDescription = $product['short_description'];
            $this->price = $product['price'];
            $this->description = $product['description'];
            $this->featureProduct = $product['feature_product'];
            $this->oldPrice = $product['old_price'];
            $this->manufacturerId = $product['manufacturer_id'];
        }
    }

    // Fetch the product's primary image
    public function getProductImage($productId) {
        $query = "SELECT image_path FROM product_images WHERE product_id = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();

        return $image ? $image['image_path'] : '/e-commerce/images/default-product.png'; // Default image if not found
    }

    // New methods for category_page.php without affecting product_page.php

    // Fetch products by category IDs
    public static function getProductsByCategory($categoryIds, $db) {
        // Ensure $categoryIds is passed as a comma-separated string
        $query = "SELECT p.*, pi.image_path 
                  FROM products p
                  JOIN product_categories pc ON p.id = pc.product_id
                  LEFT JOIN product_images pi ON p.id = pi.product_id
                  WHERE pc.category_id IN ($categoryIds)";
                  
        $result = $db->query($query);
        return $result;
    }

    // Fetch all products
    public static function getAllProducts($db) {
        $query = "SELECT p.*, pi.image_path 
                  FROM products p
                  LEFT JOIN product_images pi ON p.id = pi.product_id";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Return product details as an array
    public function getProductDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'short_description' => $this->shortDescription,
            'price' => $this->price,
            'description' => $this->description,
            'feature_product' => $this->featureProduct,
            'old_price' => $this->oldPrice,
            'manufacturer_id' => $this->manufacturerId,
            'image_path' => $this->imagePath,  // Added image path to the details
            'manufacturer_name' => $this->manufacturerDetails['name'],
            'manufacturer_logo' => $this->manufacturerDetails['logo_path']
        ];
    }

    // Fetch product attributes
    public function getProductAttributes() {
        $query = "SELECT a.name, pa.value 
                  FROM product_attributes pa 
                  LEFT JOIN attributes a ON pa.attribute_id = a.id 
                  WHERE pa.product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch product categories
    public function getProductCategories() {
        $query = "SELECT c1.name AS third_category, c2.name AS second_category, c3.name AS main_category,
                         c1.id AS third_category_id, c2.id AS second_category_id, c3.id AS main_category_id
                  FROM product_categories pc
                  LEFT JOIN categories c1 ON c1.id = pc.category_id
                  LEFT JOIN categories c2 ON c2.id = c1.parent_id
                  LEFT JOIN categories c3 ON c3.id = c2.parent_id
                  WHERE pc.product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Get next product ID
    public function getNextProductId() {
        $query = "SELECT id FROM products WHERE id > ? ORDER BY id ASC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        $nextProduct = $result->fetch_assoc();
        return $nextProduct ? $nextProduct['id'] : null;
    }

    // Get previous product ID
    public function getPreviousProductId() {
        $query = "SELECT id FROM products WHERE id < ? ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        $prevProduct = $result->fetch_assoc();
        return $prevProduct ? $prevProduct['id'] : null;
    }
}