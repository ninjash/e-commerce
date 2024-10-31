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

    // Static method to fetch all attributes
    public static function getAllAttributes($db) {
        $query = "SELECT * FROM attributes";
        $result = $db->query($query);
        if (!$result) {
            die('Error fetching attributes: ' . $db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Static method to fetch all manufacturers
    public static function getAllManufacturers($db) {
        $query = "SELECT id, name FROM manufacturers";
        $result = $db->query($query);
        if (!$result) {
            die('Error fetching manufacturers: ' . $db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to save the product to the database with parameters for connection and product data
    public function saveProduct($conn, $productData) {
        $name = $productData['name'];
        $sku = $productData['sku'];
        $short_description = $productData['short_description'];
        $price = $productData['price'];
        $description = $productData['description'];
        $feature_product = $productData['feature_product'];
        $manufacturer_id = $productData['manufacturer_id'];
        $main_image = $productData['main_image'];
        $categories = $productData['categories'];
        $attributes = $productData['attributes'];

        // Insert product into the products table
        $query = "INSERT INTO products (name, sku, short_description, price, description, feature_product, manufacturer_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssdssi", $name, $sku, $short_description, $price, $description, $feature_product, $manufacturer_id);
        
        if ($stmt->execute()) {
            $product_id = $conn->insert_id;

            // Insert main image into product_images table
            $image_query = "INSERT INTO product_images (product_id, image_path) VALUES (?, ?)";
            $stmt = $conn->prepare($image_query);
            $stmt->bind_param("is", $product_id, $main_image);
            $stmt->execute();

            // Insert attributes into product_attributes table
            foreach ($attributes as $attribute_id => $value) {
                $attribute_query = "INSERT INTO product_attributes (product_id, attribute_id, value) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($attribute_query);
                $stmt->bind_param("iis", $product_id, $attribute_id, $value);
                $stmt->execute();
            }

            // Insert categories into product_categories table
            foreach ($categories as $category_id) {
                if (!empty($category_id)) { // Ensure category_id is not empty
                    $category_query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
                    $stmt = $conn->prepare($category_query);
                    $stmt->bind_param("ii", $product_id, $category_id);
                    $stmt->execute();
                }
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    }

// Method to fetch all products with their categories and manufacturers
public function getAllProductsWithDetails() {
    $query = "
        SELECT p.id, p.name, p.sku, p.price, p.feature_product, m.name AS manufacturer_name, 
               GROUP_CONCAT(c.name SEPARATOR ', ') AS category_names
        FROM products p
        LEFT JOIN manufacturers m ON p.manufacturer_id = m.id
        LEFT JOIN product_categories pc ON p.id = pc.product_id
        LEFT JOIN categories c ON pc.category_id = c.id
        GROUP BY p.id
    ";
    $result = $this->db->query($query);

    if (!$result) {
        die('Error fetching products: ' . $this->db->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

    // Method to delete a product by ID
    public function deleteProduct($id) {
        // First delete from product_categories if necessary
        $deleteCategories = "DELETE FROM product_categories WHERE product_id = ?";
        $stmt = $this->db->prepare($deleteCategories);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Now delete the product
        $deleteProduct = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($deleteProduct);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }

    // Method to fetch a product's details by ID
    public function getProductDetailsById($id) {
        $query = "
            SELECT p.id, p.name, p.sku, p.short_description, p.price, p.old_price, p.description, p.feature_product, 
                   m.name AS manufacturer_name, m.logo_path
            FROM products p
            LEFT JOIN manufacturers m ON p.manufacturer_id = m.id
            WHERE p.id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Method to fetch product images
    public function getProductImages($productId) {
        $query = "SELECT image_path FROM product_images WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to fetch product categories by product ID
    public function getProductCategoriesById($productId) {
        $query = "
            SELECT c.name, c.id, c.parent_id
            FROM product_categories pc
            INNER JOIN categories c ON pc.category_id = c.id
            WHERE pc.product_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to fetch product attributes by product ID
    public function getProductAttributesById($productId) {
        $query = "
            SELECT a.name, pa.value 
            FROM product_attributes pa
            JOIN attributes a ON pa.attribute_id = a.id
            WHERE pa.product_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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

    // Method to fetch product details by ID
    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
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

    public function getProductCategories() {
        $query = "
            SELECT c.name, c.id, c.parent_id
            FROM product_categories pc
            INNER JOIN categories c ON pc.category_id = c.id
            WHERE pc.product_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getProductAttributes() {
        $query = "
            SELECT a.name, pa.value 
            FROM product_attributes pa
            JOIN attributes a ON pa.attribute_id = a.id
            WHERE pa.product_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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