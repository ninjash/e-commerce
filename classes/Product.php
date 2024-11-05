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
    private $imagePath;

    public function __construct($db, $id = null) {
        $this->db = $db;
        if ($id) {
            $this->loadProductById($id);
        }
    }

    // Load product details by ID
    private function loadProductById($id) {
        $product = $this->getProductDetailsById($id);
        if ($product) {
            $this->id = $product['id'];
            $this->name = $product['name'];
            $this->sku = $product['sku'];
            $this->shortDescription = $product['short_description'];
            $this->price = $product['price'];
            $this->description = $product['description'];
            $this->featureProduct = $product['feature_product'];
            $this->oldPrice = $product['old_price'];
            $this->imagePath = $this->getProductImage($id);
        }
    }

    // Method to fetch featured products
    public function getFeaturedProducts() {
        $query = "
            SELECT p.id, p.name, p.price, p.old_price, pi.image_path
            FROM products p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            WHERE p.feature_product = 1
            GROUP BY p.id
        ";
        $result = $this->db->query($query);

        if (!$result) {
            die('Error fetching featured products: ' . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array of featured products
    }

    // Method to get trending products
    public function getTrendingProducts($limit = 3) {
        $query = "
            SELECT p.id, p.name, p.price, p.old_price, pi.image_path
            FROM products p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            WHERE p.feature_product = 1
            LIMIT ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception('Error fetching trending products: ' . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array of trending products
    }

    public function getTrendingProductsByCategory($categoryId, $limit) {
        $query = "
            SELECT p.id, p.name, p.price, p.old_price, pi.image_path
            FROM products p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            JOIN product_categories pc ON pc.product_id = p.id
            WHERE pc.category_id = ?
            LIMIT ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $categoryId, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if (!$result) {
            throw new Exception('Error fetching trending products: ' . $this->db->error);
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Method to save the product to the database
    public function saveProduct($productData) {
        try {
            $query = "INSERT INTO products (name, sku, short_description, price, description, feature_product) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssdsi", 
                $productData['name'], 
                $productData['sku'], 
                $productData['short_description'], 
                $productData['price'], 
                $productData['description'], 
                $productData['feature_product']
            );

            if ($stmt->execute()) {
                $product_id = $this->db->insert_id;
                $this->saveProductImage($product_id, $productData['main_image']);
                $this->saveProductCategories($product_id, $productData['categories']);
                return true;
            } else {
                throw new Exception("Error: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Save product image
    private function saveProductImage($productId, $imagePath) {
        $query = "INSERT INTO product_images (product_id, image_path) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $productId, $imagePath);
        $stmt->execute();
    }

    // Save product categories
    private function saveProductCategories($productId, $categories) {
        foreach ($categories as $category_id) {
            if (!empty($category_id)) {
                $query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("ii", $productId, $category_id);
                $stmt->execute();
            }
        }
    }

    // Method to fetch all products with their categories
    public function getAllProductsWithDetails() {
        $query = "
            SELECT p.id, p.name, p.sku, p.price, p.feature_product, 
                   GROUP_CONCAT(c.name SEPARATOR ', ') AS category_names,
                   m.name AS manufacturer_name
            FROM products p
            LEFT JOIN product_categories pc ON p.id = pc.product_id
            LEFT JOIN categories c ON pc.category_id = c.id
            LEFT JOIN manufacturers m ON p.manufacturer_id = m.id
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
        // Delete from product_categories
        $deleteCategories = "DELETE FROM product_categories WHERE product_id = ?";
        $stmt = $this->db->prepare($deleteCategories);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Delete the product
        $deleteProduct = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($deleteProduct);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Method to fetch a product's details by ID
    public function getProductDetailsById($id) {
        $query = "
            SELECT p.id, p.name, p.sku, p.short_description, p.price, p.old_price, 
                   p.description, p.feature_product, p.manufacturer_id, pi.image_path
            FROM products p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            WHERE p.id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
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
            SELECT c1.name AS main_category, c1.id AS main_category_id,
                   c2.name AS second_category, c2.id AS second_category_id,
                   c3.name AS third_category, c3.id AS third_category_id
            FROM product_categories pc
            INNER JOIN categories c1 ON pc.category_id = c1.id
            LEFT JOIN categories c2 ON c1.parent_id = c2.id
            LEFT JOIN categories c3 ON c2.parent_id = c3.id
            WHERE pc.product_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $categories = [];
    
        // Loop through the results and create an array of categories
        while ($row = $result->fetch_assoc()) {
            $categories[] = [
                'main_category' => $row['main_category'],
                'main_category_id' => $row['main_category_id'],
                'second_category' => $row['second_category'],
                'second_category_id' => $row['second_category_id'],
                'third_category' => $row['third_category'],
                'third_category_id' => $row['third_category_id']
            ];
        }
    
        return $categories ?: []; // Return an empty array if no categories are found
    }    
    
    // Getters and Setters for product attributes
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

    public function getImagePath() {
        return $this->imagePath;
    }

    // Fetch the product's primary image
    public function getProductImage($productId) {
        $query = "SELECT image_path FROM product_images WHERE product_id = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();
        return $image ? $image['image_path'] : '/e-commerce/images/default-product.png';
    }

    // Fetch products by category IDs
    public static function getProductsByCategory($categoryIds, $db) {
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

    public function getProductsByManufacturerId($manufacturerId) {
        $query = "SELECT * FROM products WHERE manufacturer_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $manufacturerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get next product ID
    public function getNextProductId() {
        $query = "SELECT id FROM products WHERE id > ? ORDER BY id ASC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $nextProduct = $result->fetch_assoc();
        return $nextProduct ? $nextProduct['id'] : null;
    }

    // Get previous product ID
    public function getPreviousProductId() {
        $query = "SELECT id FROM products WHERE id < ? ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $prevProduct = $result->fetch_assoc();
        return $prevProduct ? $prevProduct['id'] : null;
    }

    public function updateProduct($id, $name, $sku, $shortDescription, $price, $oldPrice, $description, $featureProduct, $manufacturerId) {
        $query = "UPDATE products 
                  SET name = ?, sku = ?, short_description = ?, price = ?, old_price = ?, description = ?, 
                      feature_product = ?, manufacturer_id = ? 
                  WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssdssiii", $name, $sku, $shortDescription, $price, $oldPrice, $description, $featureProduct, $manufacturerId, $id);
        if (!$stmt->execute()) {
            die('Error updating product: ' . $stmt->error);
        }
    }

    public function updateProductCategories($productId, $categories) {
        // Delete existing categories
        $deleteQuery = "DELETE FROM product_categories WHERE product_id = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
    
        // Insert new categories
        $insertQuery = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($insertQuery);
        foreach ($categories as $categoryId) {
            $stmt->bind_param("ii", $productId, $categoryId);
            $stmt->execute();
        }
    }

    public function updateProductImage($productId, $imagePath) {
        $query = "UPDATE product_images SET image_path = ? WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $imagePath, $productId);
        if (!$stmt->execute()) {
            die('Error updating product image: ' . $stmt->error);
        }
    }
}